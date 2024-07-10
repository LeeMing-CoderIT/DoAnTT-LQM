<div style="width: 600px; margin: 0 auto;">
    <div style="text-align: center;">
        <h2>Xin chào {{$user->fullname}}</h2>
        <p>Bạn đã quên mật khẩu cũ. Và muốn tạo mật khẩu mới.</p>
        <p>Vui lòng click vào nút tạo mật khẩu mới bên dưới để xác thực tiếp tục.</p>
        <p>
            <a href="{{route('emailChangePass', ['user' => $user->id, 'token'=> $user->remember_token])}}"
                style="display: inline-block; background:  green; color: white; padding: 7px 25px;
                font-weight: bold;">Tạo mật khẩu mới</a>
        </p>
    </div>
</div>