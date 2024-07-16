<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RequestAddStory;
use App\Models\User;
use App\Models\Story;
use Illuminate\Http\Request;
use Auth;
use Storage;

class AdminController extends Controller
{
    public $data = [];
    public function __construct(){
        $this->data = json_decode(Storage::get('public/files/infoWebsite.json'), true);
        $this->data['sidebar'] = json_decode(Storage::get('public/files/sidebarAdmin.json'), true);
        $this->data['folder'] = "home";
    }

    public function home(){
        $this->data['defaulttitle'] = $this->data['title'];
        $this->data['title'] = "Trang chủ quản trị";
        $this->data['all_request_story'] = RequestAddStory::where('status', 0)->get();
        $this->data['all_users_online'] = User::select('users.*')->join('setting_users', 'setting_users.user_id', '=', 'users.id')->where('setting_users.status', 1)->get();
        // dd($this->data);
        return view('admins.home', $this->data);
    }

    public function changeWebsite(Request $request){
        if(Auth::user()->root==1){
            $data = $request->only('name_website','title','logo','defaultStoryImg','defaultUserImg','cap_header','cap_footer');
            Storage::put('public/files/infoWebsite.json', json_encode($data, JSON_UNESCAPED_UNICODE));
            return redirect()->route('admin.home')->with('type', 'success')
            ->with('msg', 'Cập nhật thành công.');
        }
        return redirect()->route('admin.home')->with('type', 'error')
            ->with('msg', 'Tài khoản không đủ quyền hạn.');
    }

    public function info(){
        $this->data['title'] = "Trang cá nhân";
        $this->data['folder'] = "info";
        $this->data['user'] = Auth::user();
        return view('admins.users.show', $this->data);
    }

    public function system(){
        $this->data['title'] = "Đa giao diện";
        $this->data['folder'] = "system";
        return view('admins.system', $this->data);
    }

    public function login(){
        if(Auth::check()) Auth::logout();
        $this->data['title'] = "Đăng nhập quản trị";
        return view('loginForms.loginAdmin', $this->data);
    }

    public function postLogin(Request $request){
        // dd($request->all());
        $request->validate([
            'email' => 'email',
            'password' => 'required',
        ], [
            'email' => 'Email không đúng định dạng',
            'password' => 'Mật khẩu không được bỏ trống'
        ]);
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            return redirect()->route('admin.home');
        }
        return redirect()->back()->with('email', $request->email)
        ->with('msg', 'Thông tin tài khoản không chính xác');
    }

    public function logout(){
        if(Auth::check()) Auth::logout();
        return redirect()->route('admin.login');
    }

    public function loadUser(Request $request){
        $users = User::limit(20);
        if($request->has('search')){
            $users->where(function ($user) use ($request){
                $user->where('email', 'like', '%'.$request->search.'%')
                    ->orWhere('fullname', 'like', '%'.$request->search.'%');
            });
        }
        if($request->has('list') && is_array($request->list)){
            foreach ($request->list as $key => $value) {
                $users->where('id', '<>', (int)$value);
            }
        }
        $data = $users->where('root', 0)->get();
        // dd($data);
        return response()->json($data);
    }
    public function loadUserSelected(Request $request){
        $users = User::select('*');
        if($request->has('list') && is_array($request->list)){
            foreach ($request->list as $key => $value) {
                $users->orWhere('id', (int)$value);
            }
            $data = $users->where('root', 0)->get();
        }else{
            $data = [];
        }
        // dd($data);
        return response()->json($data);
    }

    public function addManager(Request $request, Story $story){
        $response = []; $response['success'] = false; $response['msg'] = 'Thêm quyền quản trị của người dùng thất bại.';
        $response['type'] = 'error';
        try{
            $manager = json_decode($story->infoViews()->manager_users, true);
            if($request->has('txtlist-selected')){
                $arr = json_decode($request->get('txtlist-selected'));
                if(is_array($arr)){
                    foreach ($arr as $key => $value) {
                        if(User::find((int)$value) && !in_array((int)$value, $manager)){
                            $manager[] = (int)$value;
                        }
                    }
                }
                // dd($arr);
            }
            $story->infoViews()->update(['manager_users'=>$manager]);
            $response['success'] = true;
            $response['type'] = 'success';
            $response['msg'] = 'Thêm quyền quản trị của người dùng thành công.';
        }catch(\Throwable $th){

        }
        if($request->ajax()){
            return response()->json($response);
        }
        return back()->with('type', $response['type'])
        ->with('msg', $response['msg']);
    }
}
