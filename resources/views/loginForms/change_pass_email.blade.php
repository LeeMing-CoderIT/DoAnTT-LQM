@extends('loginForms.layout')

@section('content')
<h3 class="text-center mb-0">Chào bạn {{$user->fullname}}!</h3>
<p class="text-center">Bạn hãy tạo mật khẩu mới và tiếp tục tận hưởng cùng chúng tôi.</p>
<form action="{{route('postEmailChangePass', ['user'=>$user->id, 'token'=>$user->remember_token])}}" class="login-form" method="POST">
    @csrf
    <div class="form-group">
        <div class="icon d-flex align-items-center justify-content-center">
            <span class="fa fa-user"></span>
        </div>
        <input type="password" name="password" class="form-control" placeholder="Mật khẩu">
    </div>
    @error('password')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    <div class="form-group">
        <div class="icon d-flex align-items-center justify-content-center">
            <span class="fa fa-user"></span>
        </div>
        <input type="password" name="re_password" class="form-control" placeholder="Nhập lại mật khẩu">
    </div>
    @error('re_password')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    <div class="form-group">
        <button type="submit" class="btn form-control btn-primary rounded submit px-3">Xác nhận</button>
    </div>
</form>
<div class="w-100 text-center mt-4 text">
    <p class="mb-0">Bạn đã nhớ rồi</p>
    <a href="{{route('login')}}">Đăng nhập ngay!</a>
</div>
@endsection