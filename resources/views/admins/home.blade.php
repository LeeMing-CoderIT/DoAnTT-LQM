@extends('admins.layout')

@section('css')
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="assets/admins/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Trang chủ</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active">Trang chủ</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Info boxes -->
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-tasks"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Yêu cầu thêm truyện chưa xử lý</span>
                            <span class="info-box-number">{{$all_request_story->count()}}</span>
                        </div>
                        <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Số người dùng đang hoạt động</span>
                            <span class="info-box-number">{{$all_users_online->count()}}</span>
                        </div>
                        <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                </div>
                <!-- /.row -->

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title"><strong>Cài đặt chung</strong></h5>

                                <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="row">
                                    <form action="" method="post" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label>
                                                Ảnh đại diện:
                                                <div id="holder" class="row d-flex justify-content-center">
                                                    <img src="{{$logo}}" style="height: 5rem; width: 5rem;" alt="">
                                                </div>
                                            </label>
                                            <div class="d-flex align-items-center p-0">
                                                <div class="input-group-prepend position-absolute top-0 left-0">
                                                    <button type="button" id="lfm" data-input="txtimage" data-preview="holder" class="btn btn-primary" style="scale: 0.9">
                                                        <i class="fas fa-image"></i>
                                                    </button>
                                                </div>
                                                <!-- /btn-group -->
                                                <input id="txtimage" class="form-control" style="padding-left: 45px;" type="text" name="image" readonly>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <!-- /.row -->
                            </div>
                            <!-- ./card-body -->
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-sm-3 col-6">
                                        <button class="btn btn-primary w-100">Thông tin website</button>
                                    </div>
                                </div>
                                <!-- /.row -->
                            </div>
                            <!-- /.card-footer -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div><!--/. container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection

@section('js')
<!-- overlayScrollbars -->
<script src="assets/admins/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- jQuery Mapael -->
<script src="assets/admins/plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
<script src="assets/admins/plugins/raphael/raphael.min.js"></script>
<script src="assets/admins/plugins/jquery-mapael/jquery.mapael.min.js"></script>
<script src="assets/admins/plugins/jquery-mapael/maps/usa_states.min.js"></script>
<!-- ChartJS -->
<script src="assets/admins/plugins/chart.js/Chart.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="assets/admins/js/pages/dashboard2.js"></script>
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script>
    @if (Session::has('msg'))
        Swal.fire('{{Session::get('msg')}}', "", '{{Session::get('type')}}');
    @endif
    //link file manager
    $('#lfm').filemanager('image');
</script>
@endsection