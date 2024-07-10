@extends('loginForms.layout')

@section('content')
<h3 class="text-center mb-0">Chào bạn!</h3>
<p class="text-center">Bạn đã bị quên mật khẩu! Hãy để chúng tôi giúp bạn.</p>
@if (Session::has('msg'))
<div class="alert alert-{{Session::get('type') ?? 'danger'}}">{!! Session::get('msg') !!}</div>
@endif
<form action="{{route('postForgetPassword')}}" class="login-form" method="POST">
    @csrf
    <div class="form-group">
        <div class="icon d-flex align-items-center justify-content-center">
            <span class="fa fa-user"></span>
        </div>
        <input type="text" name="email" class="form-control" placeholder="Email cần tìm">
    </div>
    @error('email')
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