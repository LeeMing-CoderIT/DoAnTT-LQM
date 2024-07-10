<div style="width: 600px; margin: 0 auto;">
    <div style="text-align: center;">
        <h2>Xin chào {{$user->fullname}}</h2>
        <p>Bạn đã đăng ký tài khoản tại hệ thống của chúng tôi.</p>
        <p>Để hoàn thành quá trình đăng ký vui lòng click vào nút kích hoạt bên dưới để xác thực tài khoản.</p>
        <p>
            <a href="{{route('accuracyEmail', ['user' => $user->id, 'token'=> $user->remember_token])}}"
                style="display: inline-block; background:  green; color: white; padding: 7px 25px;
                font-weight: bold;">Kích hoạt</a>
        </p>
    </div>
</div>