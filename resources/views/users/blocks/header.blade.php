<header class="header d-none d-lg-block">
    <!-- place navbar here -->
    <nav class="navbar navbar-expand-lg navbar-dark header__navbar p-md-0">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="{{$logo}}" alt="Logo Suu Truyen" srcset="" class="img-fluid"
                    style="height: 60px;">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">Thể loại</a>
                        <ul class="dropdown-menu dropdown-menu-custom">
                            @foreach ($categories as $category)
                            <li><a class="dropdown-item" href="{{ route('category', ["category"=> $category->slug]) }}">{{ $category->name }}</a></li>
                            @endforeach
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">Theo số chương</a>
                        <ul class="dropdown-menu dropdown-menu-custom">
                            <li><a class="dropdown-item chaps-item-header" data-at="0-100" href="/filter-stories#chaps=0+100">Dưới 100</a></li>
                            <li><a class="dropdown-item chaps-item-header" data-at="100-500" href="/filter-stories#chaps=100+500">100 - 500</a></li>
                            <li><a class="dropdown-item chaps-item-header" data-at="500-1000" href="/filter-stories#chaps=500+1000">500 - 1000</a></li>
                            <li><a class="dropdown-item chaps-item-header" data-at="1000-50000" href="/filter-stories#chaps=1000+50000">Trên 1000</a></li>
                        </ul>
                    </li>
                </ul>

                <div class="form-check form-switch me-3 d-flex align-items-center">
                    <label class="form-check-label">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor"
                            class="bi bi-brightness-high" viewBox="0 0 16 16" style="fill: #fff;">
                            <path
                                d="M8 11a3 3 0 1 1 0-6 3 3 0 0 1 0 6zm0 1a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0zm0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13zm8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5zM3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8zm10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0zm-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0zm9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707zM4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708z">
                            </path>
                        </svg>
                    </label>
                    <input class="form-check-input theme_mode" type="checkbox"
                        style="transform: scale(1.3); margin-left: 12px; margin-right: 12px;">
                    <label class="form-check-label">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 384 512"
                            style="fill: #fff;">
                            <path
                                d="M144.7 98.7c-21 34.1-33.1 74.3-33.1 117.3c0 98 62.8 181.4 150.4 211.7c-12.4 2.8-25.3 4.3-38.6 4.3C126.6 432 48 353.3 48 256c0-68.9 39.4-128.4 96.8-157.3zm62.1-66C91.1 41.2 0 137.9 0 256C0 379.7 100 480 223.5 480c47.8 0 92-15 128.4-40.6c1.9-1.3 3.7-2.7 5.5-4c4.8-3.6 9.4-7.4 13.9-11.4c2.7-2.4 5.3-4.8 7.9-7.3c5-4.9 6.3-12.5 3.1-18.7s-10.1-9.7-17-8.5c-3.7 .6-7.4 1.2-11.1 1.6c-5 .5-10.1 .9-15.3 1c-1.2 0-2.5 0-3.7 0c-.1 0-.2 0-.3 0c-96.8-.2-175.2-78.9-175.2-176c0-54.8 24.9-103.7 64.1-136c1-.9 2.1-1.7 3.2-2.6c4-3.2 8.2-6.2 12.5-9c3.1-2 6.3-4 9.6-5.8c6.1-3.5 9.2-10.5 7.7-17.3s-7.3-11.9-14.3-12.5c-3.6-.3-7.1-.5-10.7-.6c-2.7-.1-5.5-.1-8.2-.1c-3.3 0-6.5 .1-9.8 .2c-2.3 .1-4.6 .2-6.9 .4z">
                            </path>
                        </svg>
                    </label>
                </div>

                <form class="d-flex header__form-search" action="{{ route('filter') }}" method="GET">
                    <input class="form-control search-story" type="text" placeholder="Tìm kiếm" name="keywords"
                        value="">
                    <div class="col-12 search-result shadow no-result d-none">
                        <div class="card text-white bg-light">
                            <div class="card-body p-0">
                                <ul class="list-group list-group-flush d-none"></ul>
                            </div>
                        </div>
                    </div>
                    <button class="btn" type="submit">
                        <svg xmlns="http://www.w3.org/2000/svg" height="1em"
                            viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                            <path
                                d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z">
                            </path>
                        </svg>
                    </button>
                </form>
                @if (Auth::check())
                <div class="d-flex align-items-center box-user">
                    <img src="{{Auth::user()->avatar}}" title="{{Auth::user()->email}}">
                    <ul class="box-user-item">
                        <li><a class="disabled" title="{{Auth::user()->fullname}}">{{Auth::user()->fullname}}</a></li>
                        <li><a href="{{route('infoUser')}}"><i class="fa-solid fa-circle-user"></i>Trang cá nhân</a></li>
                        <li><a href="{{route('logout')}}"><i class="fa-solid fa-right-from-bracket"></i>Đăng xuất</a></li>
                    </ul>
                </div>
                @else
                <div class="d-flex align-items-center justify-content-center box-user">
                    <i class="fa-solid fa-user"></i>
                    <ul class="box-user-item">
                        <li><a href="{{route('login')}}"><i class="fa-solid fa-right-to-bracket"></i>Đăng nhập</a></li>
                        <li><a href="{{route('register')}}"><i class="fa-solid fa-user-plus"></i>Đăng ký</a></li>
                        <li><a href="{{route('forgetPassword')}}"><i class="fa-solid fa-user-tag"></i>Quên mật khẩu</a></li>
                    </ul>
                </div>
                @endif
            </div>
        </div>
    </nav>
</header>

<div class="header-mobile d-sm-block d-lg-none">
    <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{route('home')}}">
                <img src="{{$logo}}" alt="Logo Suu Truyen" srcset="" class="img-fluid"
                    style="height: 60px;">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="offcanvas offcanvas-end text-bg-dark w-75" tabindex="-1" id="offcanvasDarkNavbar"
                aria-labelledby="offcanvasDarkNavbarLabel">
                <div class="offcanvas-header mobile-header-box-first">
                    @if (Auth::check())
                        <img src="{{Auth::user()->avatar}}" srcset="" title="{{Auth::user()->email}}" class="img-fluid">
                    @else
                        <i class="fa-solid fa-user"></i>
                    @endif
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav justify-content-end flex-grow-1 pe-3 mb-3">
                        @if (Auth::check())
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">{{Auth::user()->fullname}}</a>
                            <ul class="dropdown-menu dropdown-menu-custom">
                                <li><a class="dropdown-item" href="{{route('infoUser')}}">Trang cá nhân</a></li>
                                <li><a class="dropdown-item" href="{{route('logout')}}">Đăng xuất</a></li>
                            </ul>
                        </li>
                        @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">Tài khoản</a>
                            <ul class="dropdown-menu dropdown-menu-custom">
                                <li><a class="dropdown-item" href="{{route('login')}}">Đăng nhập</a></li>
                                <li><a class="dropdown-item" href="{{route('register')}}">Đăng ký</a></li>
                                <li><a class="dropdown-item" href="{{route('forgetPassword')}}">Quên mật khẩu</a></li>
                            </ul>
                        </li>
                        @endif
                    </ul>
                    <ul class="navbar-nav justify-content-end flex-grow-1 pe-3 mb-3">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Thể loại
                            </a>
                            <ul class="dropdown-menu dropdown-menu-custom">
                                @foreach ($categories as $category)
                                <li><a class="dropdown-item" href="{{ route('category', ["category"=> $category->slug]) }}">{{ $category->name }}</a></li>
                                @endforeach
                            </ul>
                        </li>
                    </ul>

                    <ul class="navbar-nav justify-content-end flex-grow-1 pe-3 mb-3">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">Theo số chương</a>
                            <ul class="dropdown-menu dropdown-menu-custom">
                                <li><a class="dropdown-item chaps-item-header" href="/filter-stories#chaps=0+100">Dưới 100</a></li>
                                <li><a class="dropdown-item chaps-item-header" href="/filter-stories#chaps=100+500">100 - 500</a></li>
                                <li><a class="dropdown-item chaps-item-header" href="/filter-stories#chaps=500+1000">500 - 1000</a></li>
                                <li><a class="dropdown-item chaps-item-header" href="/filter-stories#chaps=1000+50000">Trên 1000</a></li>
                            </ul>
                        </li>
                    </ul>

                    <div class="form-check form-switch d-flex align-items-center mb-3 p-0">
                        <label class="form-check-label">
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor"
                                class="bi bi-brightness-high" viewBox="0 0 16 16" style="fill: #fff;">
                                <path
                                    d="M8 11a3 3 0 1 1 0-6 3 3 0 0 1 0 6zm0 1a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0zm0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13zm8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5zM3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8zm10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0zm-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0zm9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707zM4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708z">
                                </path>
                            </svg>
                        </label>
                        <input class="form-check-input theme_mode" type="checkbox"
                            style="transform: scale(1.3); margin-left: 12px; margin-right: 12px;">

                        <label class="form-check-label">
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 384 512"
                                style="fill: #fff;">
                                <path
                                    d="M144.7 98.7c-21 34.1-33.1 74.3-33.1 117.3c0 98 62.8 181.4 150.4 211.7c-12.4 2.8-25.3 4.3-38.6 4.3C126.6 432 48 353.3 48 256c0-68.9 39.4-128.4 96.8-157.3zm62.1-66C91.1 41.2 0 137.9 0 256C0 379.7 100 480 223.5 480c47.8 0 92-15 128.4-40.6c1.9-1.3 3.7-2.7 5.5-4c4.8-3.6 9.4-7.4 13.9-11.4c2.7-2.4 5.3-4.8 7.9-7.3c5-4.9 6.3-12.5 3.1-18.7s-10.1-9.7-17-8.5c-3.7 .6-7.4 1.2-11.1 1.6c-5 .5-10.1 .9-15.3 1c-1.2 0-2.5 0-3.7 0c-.1 0-.2 0-.3 0c-96.8-.2-175.2-78.9-175.2-176c0-54.8 24.9-103.7 64.1-136c1-.9 2.1-1.7 3.2-2.6c4-3.2 8.2-6.2 12.5-9c3.1-2 6.3-4 9.6-5.8c6.1-3.5 9.2-10.5 7.7-17.3s-7.3-11.9-14.3-12.5c-3.6-.3-7.1-.5-10.7-.6c-2.7-.1-5.5-.1-8.2-.1c-3.3 0-6.5 .1-9.8 .2c-2.3 .1-4.6 .2-6.9 .4z">
                                </path>
                            </svg>
                        </label>
                    </div>

                    <form class="d-flex header__form-search" action="{{ route('filter') }}" method="GET">
                        <input class="form-control search-story" type="text" placeholder="Tìm kiếm" name="keywords"
                            value="">
                        <div class="col-12 search-result shadow no-result d-none">
                            <div class="card text-white bg-light">
                                <div class="card-body p-0">
                                    <ul class="list-group list-group-flush d-none"></ul>
                                </div>
                            </div>
                        </div>

                        <button class="btn" type="submit">
                            <svg xmlns="http://www.w3.org/2000/svg" height="1em"
                                viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                <path
                                    d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z">
                                </path>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>
</div>

<div class="bg-light header-bottom">
    <div class="container py-1">
        <p class="mb-0">{{$cap_header}}</p>
    </div>
</div>