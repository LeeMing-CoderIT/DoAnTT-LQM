@extends('admins.layout')

@section('css')
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="assets/admins/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <link rel="stylesheet" href="assets/admins/plugins/sweetalert2/sweetalert2.min.css">
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
                                <h5 class="card-title"><strong>Thông tin website</strong></h5>

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
                                    <form action="{{route('admin.changeWebsite')}}" class="w-100" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group">
                                            <label>
                                                Tên Website: <span class="show-view" style="font-weight: normal;">{{$name_website}}</span>
                                            </label>
                                            <input type="text" class="form-control edit d-none" id="name_website" name="name_website" data-old="{{$name_website}}" value="{{$name_website}}">
                                        </div>
                                        <div class="form-group">
                                            <label>
                                                Tiêu đề mặc định: <span class="show-view" style="font-weight: normal;">{{$defaulttitle}}</span>
                                            </label>
                                            <input type="text" class="form-control edit d-none" id="title" name="title" data-old="{{$defaulttitle}}" value="{{$defaulttitle}}">
                                        </div>
                                        <div class="form-group d-flex">
                                            <div class="col-4">
                                                <label>
                                                    Logo Website:
                                                </label>
                                                <div class="align-items-center p-0 edit d-none">
                                                    <div class="input-group-prepend position-absolute top-0 left-0">
                                                        <button type="button" id="lfm" data-input="txtimage" data-preview="holder" class="btn btn-primary" style="scale: 0.9">
                                                            <i class="fas fa-image"></i>
                                                        </button>
                                                    </div>
                                                    <input id="txtimage" class="form-control" style="padding-left: 45px;" type="text" name="logo" data-old="{{$logo}}" value="{{$logo}}" readonly>
                                                </div>
                                                
                                                <div id="holder" class="row d-flex mt-3 ml-1" data-width="5rem" data-height="5rem">
                                                    <img src="{{$logo}}" style="height: 5rem; width: 5rem;" alt="">
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <label>
                                                    Ảnh bìa sách mặc định:
                                                </label>
                                                <div class="align-items-center p-0 edit d-none">
                                                    <div class="input-group-prepend position-absolute top-0 left-0">
                                                        <button type="button" id="lfm-story" data-input="txtimagestory" data-preview="holder-story" class="btn btn-primary" style="scale: 0.9">
                                                            <i class="fas fa-image"></i>
                                                        </button>
                                                    </div>
                                                    <input id="txtimagestory" class="form-control" style="padding-left: 45px;" type="text" name="defaultStoryImg" data-old="{{$defaultStoryImg}}" value="{{$defaultStoryImg}}" readonly>
                                                </div>
                                                
                                                <div id="holder-story" class="row d-flex mt-3 ml-1" data-height="5rem">
                                                    <img src="{{$defaultStoryImg}}" style="height: 5rem;" alt="">
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <label>
                                                    Ảnh người dùng mặc định:
                                                </label>
                                                <div class="align-items-center p-0 edit d-none">
                                                    <div class="input-group-prepend position-absolute top-0 left-0">
                                                        <button type="button" id="lfm-user" data-input="txtimageuser" data-preview="holder-user" class="btn btn-primary" style="scale: 0.9">
                                                            <i class="fas fa-image"></i>
                                                        </button>
                                                    </div>
                                                    <input id="txtimageuser" class="form-control" style="padding-left: 45px;" type="text" name="defaultUserImg" data-old="{{$defaultUserImg}}" value="{{$defaultUserImg}}" readonly>
                                                </div>
                                                
                                                <div id="holder-user" class="row d-flex mt-3 ml-1" data-width="5rem" data-height="5rem" data-circle="50%">
                                                    <img src="{{$defaultUserImg}}" style="height: 5rem; width: 5rem; border-radius: 50%;" alt="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>
                                                Nội dung phần trên:
                                            </label>
                                            <textarea name="cap_header" id="cap_header" class="form-control" readonly cols="30" rows="5" data-old="{{$cap_header}}">{{$cap_header}}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>
                                                Nội dung phần dưới:
                                            </label>
                                            <textarea name="cap_footer" id="cap_footer" class="form-control" readonly cols="30" rows="5" data-old="{{$cap_footer}}">{{$cap_footer}}</textarea>
                                        </div>
                                        @if (Auth::user()->root==1)
                                        <div class="form-group d-flex justify-content-end">
                                            <button class="btn btn-warning text-white m-2 show-view" id="btn-edit-website" type="button">Cập nhật</button>
                                            <button class="btn btn-default text-white m-2 edit d-none" id="btn-reset-edit" type="button">Hủy</button>
                                            <button class="btn btn-primary text-white m-2 edit d-none" type="submit">Xác nhận</button>
                                        </div>
                                        @endif
                                    </form>
                                </div>
                                <!-- /.row -->
                            </div>
                            <!-- ./card-body -->
                            {{-- <div class="card-footer">
                                <div class="row">
                                    <div class="col-sm-3 col-6">
                                        <button class="btn btn-primary w-100">Thông tin website</button>
                                    </div>
                                </div>
                                <!-- /.row -->
                            </div> --}}
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
<script src="assets/admins/plugins/sweetalert2/sweetalert2.all.min.js"></script>
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
    $('#lfm-story').filemanager('image');
    $('#lfm-user').filemanager('image');
    $('#btn-edit-website').click(function (e) { 
        e.preventDefault();
        $('.edit').removeClass('d-none');
        $('.show-view').addClass('d-none');
        $('#cap_header').prop('readonly', false);
        $('#cap_footer').prop('readonly', false);
    });
    $('#btn-reset-edit').click(function (e) { 
        e.preventDefault();
        $('.edit').addClass('d-none');
        $('.show-view').removeClass('d-none');
        $('#cap_header').prop('readonly', true);
        $('#cap_footer').prop('readonly', true);
        $('#name_website').val($('#name_website').attr('data-old'));
        $('#title').val($('#title').attr('data-old'));
        $('#txtimage').val($('#txtimage').attr('data-old'));
        $('#txtimagestory').val($('#txtimagestory').attr('data-old'));
        $('#txtimageuser').val($('#txtimageuser').attr('data-old'));
        $('#cap_header').val($('#cap_header').attr('data-old'));
        $('#cap_footer').val($('#cap_footer').attr('data-old'));
        $('#holder img').attr('src', $('#txtimage').attr('data-old'));
        $('#holder-story img').attr('src', $('#txtimagestory').attr('data-old'));
        $('#holder-user img').attr('src', $('#txtimageuser').attr('data-old'));
    });
</script>
@endsection