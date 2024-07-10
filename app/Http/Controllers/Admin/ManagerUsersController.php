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
            $this->data['user'] = $user;
            return view('admins.users.show', $this->data);
        }else{
            return redirect()->route('admin.info');
        }
    }

    public function add(Request $request)
    {
        $response = []; $response['success'] = false;
        $data = $request->only('author', 'name', 'slug', 'image', 'categories', 'status', 'description');
        try {
            $story = Story::create($data);
            $response['success'] = true;
            $response['msg'] = $story;
        } catch (\Throwable $th) {
            $response['msg'] = $th; 
        }
        return response()->json($response);
    }

    public function edit(Request $request, Story $story)
    {
        $response = []; $response['success'] = false;
        $data = $request->only('author', 'name', 'slug', 'image', 'categories', 'status', 'description');
        try {
            $story->update($data);
            $response['success'] = true;
            $response['msg'] = $story;
        } catch (\Throwable $th) {
            $response['msg'] = $th; 
        }
        return response()->json($response);
    }

    public function delete(Story $story)
    {
        $response = []; $response['success'] = false; $response['msg'] = 'Xóa dữ liệu thất bại.';
        try {
            if($story->delete()){
                $response['success'] = true;
                $response['data'] = $story;
                $response['msg'] = "Xóa dữ liệu thành công.";
            }
        } catch (\Throwable $th) {
            $response['msg'] = $th; 
        }
        return response()->json($response);
    }
}
