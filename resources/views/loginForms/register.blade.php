@extends('loginForms.layout')

@section('content')
<h3 class="text-center mb-0">Chào bạn!</h3>
<p class="text-center">Hãy đăng ký để trải nghiệm cùng chúng tôi</p>
<form action="{{route('postRegister')}}" class="login-form" method="POST">
    @csrf
    <div class="form-group">
        <div class="icon d-flex align-items-center justify-content-center">
            <span class="fa fa-user"></span>
        </div>
        <input type="text" name="email" class="form-control" placeholder="Email" value="{{old('email')}}">
    </div>
    @error('email')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    <div class="form-group">
        <div class="icon d-flex align-items-center justify-content-center">
            <span class="fa fa-lock"></span>
        </div>
        <input type="password" name="password" class="form-control" placeholder="Mật khẩu">
    </div>
    @error('password')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    <div class="form-group">
        <div class="icon d-flex align-items-center justify-content-center">
            <span class="fa fa-lock"></span>
        </div>
        <input type="password" name="re_password" class="form-control" placeholder="Nhập lại mật khẩu">
    </div>
    @error('re_password')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    <div class="form-group">
        <button type="submit" class="btn form-control btn-primary rounded submit px-3">Đăng ký</button>
    </div>
</form>
<div class="w-100 text-center mt-4 text">
    <p class="mb-0">Bạn đã có tài khoản?</p>
    <a href="{{route('login')}}">Đăng nhập ngay!</a>
</div>
@endsection