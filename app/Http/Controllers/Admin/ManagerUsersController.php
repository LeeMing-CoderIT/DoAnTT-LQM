<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Story;
use App\Models\User;
use Storage;
use Datatables;
use File;

class ManagerUsersController extends Controller
{
    public $data = [];

    public function __construct(){
        $this->data = json_decode(Storage::get('public/files/infoWebsite.json'), true);
        $this->data['sidebar'] = json_decode(Storage::get('public/files/sidebarAdmin.json'), true);
        $this->data['folder'] = "users";
    }

    public function index(Request $request)
    {
        $this->data['title'] = "Quản lý danh sách người dùng";
        $this->data['path_active'] = $request->path();
        return view('admins.users.index', $this->data);
    }

    public function all(Request $request)
    {
        $success = false; $data=[]; $pages = 0;
        $users = User::select('users.*');
        if($request->has('status') && (!$request->has('root') || (int)$request->root >= 0)){
            $users->join('setting_users', 'users.id', '=', 'setting_users.user_id');
            $users->where('setting_users.status', $request->status);
        }
        if($request->has('root')){
            $users->where('users.root', $request->root);
        }
        if($request->has('search')){
            $users->where(function ($user) use ($request){
                $user->where('users.email', 'like', '%'.$request->search.'%')
                    ->orWhere('users.fullname', 'like', '%'.$request->search.'%');
            });
        }
        $users->where('users.id', '<>', \Auth::user()->id);
        $all_data = $users->get();
        if($all_data->count() > 0){
            $data = $users->limit($request->max)->offset((($request->page-1)*$request->max))->get();
            if($data->count() > 0){
                $success = true;
                $pages = ceil($all_data->count()/$request->max);
                foreach($data as $key => $value){
                    $data[$key]->settings = $value->settings();
                }
            }
        }
        return response()->json(['success' => $success, 'pages'=> $pages, 'data' =>$data]);
    }

    public function show(Request $request, User $user)
    {
        if($request->ajax()){
            return response()->json($user);
        }
        if($user->id != \Auth::user()->id){
            $this->data['title'] = "Quản lý thông tin người dùng: ".$user->fullname;
            $this->data['user'] = $user;
            return view('admins.users.show', $this->data);
        }else{
            return redirect()->route('admin.info');
        }
    }

    public function add(Request $request)
    {
        $response = []; $response['success'] = false;
        $data = $request->only('fullname', 'avatar', 'phone', 'password');
        try {
            $story = Story::create($data);
            $response['success'] = true;
            $response['msg'] = $story;
        } catch (\Throwable $th) {
            $response['msg'] = $th; 
        }
        return response()->json($response);
    }

    public function edit(Request $request, User $user)
    {
        $response = []; $response['success'] = false; $response['msg'] = 'Cập nhật thất bại.';$response['type'] = 'error';
        try {
            $data = $request->only('fullname', 'phone');
            if(\Auth::user()->root==1 || \Auth::user()->id == $user->id){
                if($user){
                    if($request->has('password')){
                        $data['password'] = bcrypt($request->password);
                    }
                    if($request->avatar){
                        $data['avatar'] = time().'_'.$request->avatar->getClientOriginalName();
                        $request->avatar->move(public_path('storage/images/users'), $data['avatar']);
                        Storage::delete('public/images/users/'.$user->avatar);
                    }
                    $user->update($data);
                }
                $response['success'] = true;
                $response['data'] = $data;
                $response['type'] = 'success';
                $response['msg'] = 'Cập nhật thành công.';
            }
        } catch (\Throwable $th) {
            
        }
        if($request->ajax()){
            return response()->json($response);
        }
        return back()->with('type', $response['type'])
        ->with('msg', $response['msg']);;
    }

    public function adminEdit(Request $request)
    {
        $user = User::find($request->id);
        $data = $request->only('fullname', 'phone');
        if($user){
            if($request->avatar){
                $data['avatar'] = time().'_'.$request->avatar->getClientOriginalName();
                $request->avatar->move(public_path('storage/images/users'), $data['avatar']);
                Storage::delete('public/images/users/'.$user->avatar);
            }
            $user->update($data);
            // dd($request->all(), $user);
            return back()->with('msg', 'Cập nhật thành công.')->with('type', 'success');
        }
        return back()->with('msg', 'Tài khoản không tồn tại.')->with('type', 'danger');
    }

    public function unlock(Request $request, User $user)
    {
        $response = []; $response['success'] = false; $response['msg'] = 'Kích hoạt thất bại.';$response['type'] = 'error';
        // dd($user);
        try {
            if(\Auth::user()->root==1){
                $user->update(['root' => 0]);
                $response['success'] = true;
                $response['type'] = 'success';
                $response['msg'] = 'Kích hoạt thành công.';
            }
        } catch (\Throwable $th) {
            
        }
        if($request->ajax()){
            return response()->json($response);
        }
        return back()->with('type', $response['type'])
        ->with('msg', $response['msg']);;
    }

    public function lock(Request $request, User $user)
    {
        $response = []; $response['success'] = false; $response['msg'] = 'Khóa tài khoản thất bại.';$response['type'] = 'error';
        // dd($user);
        try {
            if(\Auth::user()->root==1){
                $user->update(['root' => -1]);
                $response['success'] = true;
                $response['type'] = 'success';
                $response['msg'] = 'Khóa tài khoản thành công.';
            }
        } catch (\Throwable $th) {
            
        }
        if($request->ajax()){
            return response()->json($response);
        }
        return back()->with('type', $response['type'])
        ->with('msg', $response['msg']);
    }

    public function delete(User $user)
    {
        $response = []; $response['success'] = false; $response['msg'] = 'Xóa người dùng thất bại.';$response['type'] = 'error';
        try {
            if(\Auth::user()->root==1){
                if($user->delete()){
                    $user->settings()->delete();
                    $response['success'] = true;
                    $response['data'] = $user;
                    $response['type'] = 'success';
                    $response['msg'] = 'Xóa người dùng thành công.';
                }
            }else{
                $response['msg'] = 'Không có quyền hạn.';
            }
        } catch (\Throwable $th) {
            
        }
        return response()->json($response);
    }

    public function decentralization(Request $request){
        if($request->ajax()){
            $users = User::select('*')->where('users.root', '>=', 0)->where('users.id', '<>', \Auth::user()->id)->get();
            foreach ($users as $key => $value) {
                $users[$key]->index = $key+1;
                $users[$key]->decentralization = $value->name_manager();
            }
            return (datatables()->of($users)
            ->addColumn('show', 'admins.users.show-de')
            ->addColumn('action', 'admins.users.action-de')
            ->rawColumns(['show','action'])
            ->addIndexColumn()
            ->make(true));
        }
        $this->data['title'] = "Phân quyền người dùng";
        $this->data['path_active'] = $request->path();
        return view('admins.users.decentralization', $this->data);
    }

    public function changeDecentralization(Request $request, User $user){
        $response = []; $response['success'] = false; 
        $response['msg'] = [
            'type' => 'error',
            'msg' => 'Cấp quyền thất bại.'
        ];
        try {
            $root = (int)$request->root;
            if($user->update(['root' => $root])){
                $response['success'] = true; 
                $response['msg'] = [
                    'data' => $user,
                    'root' => $root,
                    'type' => 'success',
                    'msg' => 'Cấp quyền thành công.'
                ];
            }
        } catch (\Throwable $th) {

        }
        return response()->json($response);
    }

    public function lockManagerStory(Request $request, Story $story, User $user){
        $response = []; $response['success'] = false; $response['msg'] = 'Xóa quyền quản trị của người dùng thất bại.';
        $response['type'] = 'error';
        try{
            $manager = json_decode($story->infoViews()->manager_users, true);
            if(($index = array_search($user->id, $manager,)) !== false){
                unset($manager[$index]);
            }
            $story->infoViews()->update(['manager_users'=>$manager]);
            $response['success'] = true;
            $response['type'] = 'success';
            $response['msg'] = 'Xóa quyền quản trị của người dùng thành công.';
        }catch(\Throwable $th){

        }
        if($request->ajax()){
            return response()->json($response);
        }
        return back()->with('type', $response['type'])
        ->with('msg', $response['msg']);
    }
}
