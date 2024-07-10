<!doctype html>
<html lang="en">
  <head>
  	<title>Đăng nhập</title>
    <meta charset="utf-8">
    <base href="{{asset('')}}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="{{ $logo }}" type="image/x-icon">
	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="assets/admins/css/login/style.css">
</head>
<body>
	<section class="ftco-section">
		<div class="container">
			<div class="row justify-content-center">
                <div class="col-md-6 col-lg-4">
                    <div class="login-wrap py-5">
                        <div class="img d-flex align-items-center justify-content-center" 
                            style="background-image: url(storage/images/logo.png);">
                        </div>
                        @yield('content')
                    </div>
				</div>
			</div>
		</div>
	</section>

	<script src="assets/admins/js/login/jquery.min.js"></script>
    <script src="assets/admins/js/login/popper.js"></script>
    <script src="assets/admins/js/login/bootstrap.min.js"></script>
    <script src="assets/admins/js/login/main.js"></script>

</body>
</html>

