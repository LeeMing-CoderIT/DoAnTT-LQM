<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Đọc truyện online, truyện hay. Demo Truyện luôn tổng hợp và cập nhật các chương truyện một cách nhanh nhất.">
    
    <base href="{{ asset("") }}">

    <!-- ICON -->
    <title>{{$title}}</title>
    <link rel="shortcut icon" href="{{ $logo }}" type="image/x-icon">

    <!-- CSS -->
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin="">

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="assets/users/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/users/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/users/css/app.css">
    @yield('css')
</head>
<body>
    <input type="hidden" id="id-authencation" value="{{Auth::user()->id ?? -1}}">
    @include('users.blocks.header')

    @yield('content')

    @include('users.blocks.footer')

    <!-- JS -->
    <script src="assets/users/js/jquery.min.js"></script>
    <script src="assets/users/js/popper.min.js"></script>
    <script src="assets/users/js/bootstrap.min.js"></script>
    <script src="assets/users/js/all.min.js"></script>
    <script src="assets/users/js/app.js"></script>
    <script src="assets/users/js/common.js"></script>

    @yield('js')
    <script>
        LightOrDark({{(Auth::check() && Auth::user()->settings()->background==1)?'true':'false'}});
    </script>

    <div id="loadingPage" class="loading-full">
        <div class="loading-full_icon">
            <div class="spinner-grow"><span class="visually-hidden">Loading...</span></div>
        </div>
    </div>
</body>
</html>