@extends('loginForms.layout')

@section('content')
@if (Session::has('msg'))
<div class="alert alert-{{Session::get('type') ?? 'success'}}">{!! Session::get('msg') !!}</div>
@endif
<h3 class="text-center mb-0">Chào bạn!</h3>
<p class="text-center">Hãy đăng nhập để trải nghiệm cùng chúng tôi</p>
<form action="{{route('postLogin')}}" class="login-form" method="POST">
    @csrf
    <div class="form-group">
        <div class="icon d-flex align-items-center justify-content-center">
            <span class="fa fa-user"></span>
        </div>
        <input type="text" name="email" class="form-control" placeholder="Email" value="{{Session::get('email') ?? ''}}">
    </div>
    @error('email')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    <div class="form-group">
        <div class="icon d-flex align-items-center justify-content-center">
            <span class="fa fa-lock"></span>
        </div>
        <input type="password" name="password" class="form-control" placeholder="Mật khẩu" value="{{Session::get('password') ?? ''}}">
    </div>
    @error('password')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    <div class="form-group d-md-flex">
        <div class="w-100 text-md-right">
            <a href="{{route('forgetPassword')}}">Quên mật khẩu</a>
        </div>
    </div>
    <div class="form-group">
        <button type="submit" class="btn form-control btn-primary rounded submit px-3">Đăng nhập</button>
    </div>
</form>
<div class="w-100 text-center mt-4 text">
    <p class="mb-0">Bạn chưa có tài khoản?</p>
    <a href="{{route('register')}}">Đăng ký ngay!</a>
</div>
@endsection