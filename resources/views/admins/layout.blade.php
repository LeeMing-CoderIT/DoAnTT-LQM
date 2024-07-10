<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <base href="{{asset('')}}">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{$title ?? 'Trang quản trị'}}</title>
  <link rel="shortcut icon" href="{{ $logo }}" type="image/x-icon">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="assets/admins/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="assets/admins/css/adminlte.min.css">
  <style>
      .form-switch input[type='checkbox'].theme_mode:checked{
          background-color:var(--bs-pink);
          border-color:var(--bs-pink)
      }
      .form-switch .icon-switch-check{
        position: absolute;
      }
      .form-switch .icon-switch-check.icon-left{
        left: -45px;
      }
      .form-switch .icon-switch-check.icon-right{
        right: -15px;
      }
  </style>
  @yield('css')
</head>
<body class="hold-transition light-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">
        @include('admins.blocks.header')
        @include('admins.blocks.sidebar')
        @yield('content')
        @include('admins.blocks.footer')
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->
    <!-- jQuery -->
    <script src="assets/admins/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="assets/admins/plugins/bootstrap/js/bootstrap.bundle.min.js"></script> 
    <!-- Bootstrap Switch -->
    <script src="assets/admins/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="assets/admins/js/demo.js"></script>
    <!-- Xử lý realtime -->
    <script src="assets/admins/js/realtime.js"></script>
    <!-- AdminLTE App -->
    <script src="assets/admins/js/adminlte.js"></script>
    <script>
        {!!(Auth::check() && Auth::user()->settings()->background == 1)?"$('.control-sidebar input[type=checkbox]:eq(0)').click();":''!!}
        $('.control-sidebar input[type=checkbox]:eq(0)').change(function (e) { 
          e.preventDefault();
          let dark = $(this).prop('checked')?1:0;
          $.ajax({
            type: "get",
            url: "/change-background/{{Auth::user()->id}}/"+dark,
            data: {},
            success: function (response) {
              
            }
          });
        });
    </script>
    @yield('js')
</body>
</html>
