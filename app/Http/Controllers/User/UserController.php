<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SettingUser;
use Str;
use Mail;
use Auth;

class UserController extends Controller
{
    public $data = [];
    public function __construct(){
        $this->data['logo'] = "logo.png";
    }
    public function login(){
        if(Auth::check()) Auth::logout();
        return view('loginForms.login', $this->data);
    }

    public function postLogin(Request $request){
        $request->validate([
            'email' => 'email',
            'password' => 'required',
        ], [
            'email.email' => 'Email không hợp lệ',
            'password.required' => 'Mật khẩu không được bỏ trống',
        ]);
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            if(Auth::user()->status < 0 || Auth::user()->status > 1){
                return redirect()->back()
                ->with('msg', 'Tài khoản chưa được kích hoạt.<br><a href="'.route('resetAccuracyEmail', ['user'=>Auth::user()->id]).'">Gửi lại yêu cầu kích hoạt.</a>')
                ->with('type', 'danger')->with('email', $request->email);
            }
            return redirect()->route('home');
        }
        return redirect()->back()
        ->with('msg', 'Thông tin tài khoản đăng nhập không chính xác.')
        ->with('type', 'danger')->with('email', $request->email);
    }

    public function logout(){
        if(Auth::check()) Auth::logout();
        return redirect()->route('login');
    }

    public function register(){
        if(Auth::check()) Auth::logout();
        return view('loginForms.register', $this->data);
    }

    public function postRegister(Request $request){
        $request->validate([
            'email' => 'email|unique:users',
            'password' => 'required',
            're_password' => 'required|same:password',
        ], [
            'email.email' => 'Email không hợp lệ',
            'email.unique' => 'Email đã tồn tại tài khoản',
            'password.required' => 'Mật khẩu không được bỏ trống',
            're_password.required' => 'Nhập lại mật khẩu không được bỏ trống',
            're_password.same' => 'Nhập lại mật khẩu không trùng khớp'
        ]);

        $data = $request->only('email', 'password');
        $data['remember_token'] = strtoupper(Str::random(15));
        $data['fullname'] = $request->email;
        $data['password'] = bcrypt($request->password);
        $data['email_verified_at'] = date ( 'Y-m-d H:i:s' , strtotime('+10 minute',strtotime ( date('Y-m-d H:i:s'))));
        if($user = User::create($data)){
            $settings = SettingUser::create(['user_id' => $user->id]);
            $this->senMail('emails.accuracy_email','QMSTUDIO - Xác thực tài khoản', $user);
            return redirect()->route('login')
            ->with('msg', 'Đăng ký thành công! Kiểm tra email để xác thực tài khoản.')
            ->with('type', 'success')->with('email', $request->email)->with('password', $request->password);
        }
        return redirect()->back();
    }

    public function forgetPassword(){
        if(Auth::check()) Auth::logout();
        return view('loginForms.forget_password', $this->data);
    }

    public function postForgetPassword(Request $request){
        $request->validate([
            'email' => 'email',
        ], [
            'email.email' => 'Email không hợp lệ'
        ]);

        $data = [];
        $data['remember_token'] = strtoupper(Str::random(15));
        $data['email_verified_at'] = date ( 'Y-m-d H:i:s' , strtotime('+10 minute',strtotime ( date('Y-m-d H:i:s'))));
        if($user = User::where('email', $request->email)->first()){
            if($user->root < 0){
                return redirect()->back()
                ->with('msg', 'Tài khoản chưa được kích hoạt.<br><a href="'.route('resetAccuracyEmail', ['user'=>Auth::user()->id]).'">Gửi lại yêu cầu kích hoạt.</a>')
                ->with('type', 'danger')->with('email', $request->email);
            }
            if($user->update($data)){
                $this->senMail('emails.email_change_pass','QMSTUDIO - Lấy lại mật khẩu mới', $user);
                return redirect()->route('login')
                ->with('msg', 'Tìm kiếm thành công! Kiểm tra email để xác thực và tạo lại mật khẩu.')
                ->with('type', 'success')->with('email', $request->email)->with('password', $request->password);
            }
            return redirect()->back()->with('msg', 'Lỗi dữ liệu vào. Hãy nhập lại!');
        }
        return redirect()->back()->with('msg', 'Tài khoản của bạn không tồn tại.');
    }

    public function accuracyEmail(User $user, $token) {
        if($user && $user->email_verified_at && $user->remember_token){
            if((strtotime($user->email_verified_at) > strtotime(date('Y-m-d H:i:s')))){
                if($user->remember_token === $token){
                    if($user->root < 0){
                        $user->update([
                            'email_verified_at' => null, 'remember_token' => null, 'root' => 0
                        ]);
                        return redirect()->route('login')
                        ->with('email', $user->email)
                        ->with('msg', 'Kích hoạt tài khoản thành công.')
                        ->with('type', 'success');
                    }
                    return redirect()->route('login')
                    ->with('email', $user->email)
                    ->with('msg', 'Tài khoản của bạn đã được kích hoạt.')
                    ->with('type', 'danger');
                }
                return redirect()->route('login')
                ->with('msg', 'Mã xác thực không chính xác.')
                ->with('type', 'danger');
            }
            $user->update([
                'email_verified_at' => null, 'remember_token' => null
            ]);
            return redirect()->route('login')
            ->with('msg', 'Mã xác thực đã quá hạn.')
            ->with('type', 'danger');
        }
        return redirect()->route('login')
        ->with('msg', 'Chưa có yêu cầu xác thực nào.')
        ->with('type', 'danger');
    }

    public function resetAccuracyEmail(User $user){
        $data = [];
        $data['remember_token'] = strtoupper(Str::random(15));
        $data['email_verified_at'] = date ( 'Y-m-d H:i:s' , strtotime('+10 minute',strtotime ( date('Y-m-d H:i:s'))));
        if($user){
            if($user->root < 0){
                if($user->update($data)){
                    $this->senMail('emails.accuracy_email','QMSTUDIO - Xác thực tài khoản', $user);
                    return redirect()->back()
                    ->with('msg', 'Gửi lại kích hoạt tài khoản thành công.')
                    ->with('type', 'success')->with('email', $user->email);
                }
                return redirect()->back()->with('msg', 'Lỗi hệ thống! Yêu cầu thực hiện lại.');
            }
            return redirect()->back()->with('msg', 'Tài khoản của bạn đã được kích hoạt');
        }
        return redirect()->back()->with('msg', 'Tài khoản của bạn không tồn tại');
    }

    public function emailChangePass(User $user, $token){
        if($user && $user->email_verified_at && $user->remember_token){
            if((strtotime($user->email_verified_at) > strtotime(date('Y-m-d H:i:s')))){
                if($user->remember_token === $token){
                    if($user->root >= 0){
                        $this->data['user'] = $user;
                        return view('loginForms.change_pass_email', $this->data);
                    }
                    return redirect()->route('login')
                    ->with('msg', 'Tài khoản chưa được kích hoạt.<br><a href="'.route('resetAccuracyEmail', ['user'=>Auth::user()->id]).'">Gửi lại yêu cầu kích hoạt.</a>')
                    ->with('type', 'danger')->with('email', $user->email);
                }
                return redirect()->route('login')
                ->with('msg', 'Mã xác thực không chính xác.')
                ->with('type', 'danger');
            }
            $user->update([
                'email_verified_at' => null, 'remember_token' => null
            ]);
            return redirect()->route('login')
            ->with('msg', 'Mã xác thực đã quá hạn.')
            ->with('type', 'danger');
        }
        return redirect()->route('login')
        ->with('msg', 'Chưa có yêu cầu xác thực nào.')
        ->with('type', 'danger');
    }

    public function postEmailChangePass(Request $request, User $user, $token){
        $request->validate([
            'password' => 'required',
            're_password' => 'required|same:password',
        ], [
            'password.required' => 'Mật khẩu không được bỏ trống',
            're_password.required' => 'Nhập lại mật khẩu không được bỏ trống',
            're_password.same' => 'Nhập lại mật khẩu không trùng khớp'
        ]);
        if($user && $user->email_verified_at && $user->remember_token){
            if((strtotime($user->email_verified_at) > strtotime(date('Y-m-d H:i:s')))){
                if($user->remember_token === $token){
                    if($user->root >= 0){
                        $user->update([
                            'email_verified_at' => null, 'remember_token' => null, 'password' => bcrypt($request->password)
                        ]);
                        return redirect()->route('login')
                        ->with('type', 'success')->with('email', $user->email)->with('password', $request->password)
                        ->with('msg', 'Tạo mới mật khẩu thành công.')
                        ->with('type', 'success');
                    }
                    return redirect()->route('login')
                    ->with('msg', 'Tài khoản chưa được kích hoạt.<br><a href="'.route('resetAccuracyEmail', ['user'=>Auth::user()->id]).'">Gửi lại yêu cầu kích hoạt.</a>')
                    ->with('type', 'danger')->with('email', $user->email);
                }
                return redirect()->route('login')
                ->with('msg', 'Mã xác thực không chính xác.')
                ->with('type', 'danger');
            }
            $user->update([
                'email_verified_at' => null, 'remember_token' => null
            ]);
            return redirect()->route('login')
            ->with('msg', 'Mã xác thực đã quá hạn.')
            ->with('type', 'danger');
        }
        return redirect()->route('login')
        ->with('msg', 'Chưa có yêu cầu xác thực nào.')
        ->with('type', 'danger');
    }

    public function changBackground(Request $request, User $user, $background) {
        if($user) $user->settings()->updateBackground($background);
        return response($background);
    }

    protected function senMail($layout, $title, User $user){
        Mail::send($layout, compact('user'), function($email) use($user, $title){
            $email->subject($title);
            $email->to($user->email, $user->fullname);
        });
    }
}
