@extends('admins.layout')

@section('css')
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="assets/admins/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper iframe-mode bg-dark" data-widget="iframe" data-auto-dark-mode="true" data-loading-screen="750">
        <div class="nav navbar navbar-expand-lg navbar-dark border-bottom border-dark p-0">
            <a class="nav-link bg-danger" data-widget="iframe-close">ĐÓng</a>
            <a class="nav-link bg-dark" data-widget="iframe-scrollleft"><i class="fas fa-angle-double-left"></i></a>
            <ul class="navbar-nav" role="tablist">
            </ul>
            <a class="nav-link bg-dark" data-widget="iframe-scrollright"><i class="fas fa-angle-double-right"></i></a>
            <a class="nav-link bg-dark" data-widget="iframe-fullscreen"><i class="fas fa-expand"></i></a>
            </div>
            <div class="tab-content">
            <div class="tab-empty">
                <h2 class="display-4">Chưa có giao diện được chọn!</h2>
            </div>
            <div class="tab-loading">
                <div>
                <h2 class="display-4">Đang tải giao diện <i class="fa fa-sync fa-spin"></i></h2>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content-wrapper -->
@endsection

@section('js')
<!-- jQuery UI 1.11.4 -->
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- overlayScrollbars -->
<script src="assets/admins/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
@endsection