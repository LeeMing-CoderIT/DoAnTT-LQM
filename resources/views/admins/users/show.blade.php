@extends('admins.layout')

@section('css')

<link rel="stylesheet" href="assets/admins/plugins/sweetalert2/sweetalert2.min.css">
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        @if (Auth::user()->id != $user->id)
                            <h1>{{$user->name_manager()}}: {{$user->fullname}}</h1>
                            @else
                            <h1>Thông tin cá nhân</h1>
                            @endif
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('admin.home')}}">Trang chủ</a></li>
                            @if (Auth::user()->id != $user->id)
                            <li class="breadcrumb-item"><a href="{{route('admin.users.index')}}">Danh sách người dùng</a></li>
                            <li class="breadcrumb-item active">{{$user->name_manager()}}: {{$user->fullname}}</li>
                            @else
                            <li class="breadcrumb-item active">Thông tin cá nhân</li>
                            @endif
                        </ol>
                    </div>
                </div>
                @if (Auth::user()->root==1 || Auth::user()->id == $user->id)
                <div class="row d-flex justify-content-end">
                    <button type="button" class="btn btn-primary addData" data-toggle="modal" data-target="#modal-xl">
                        Cập nhật thông tin
                    </button>
                </div>
                @endif
            </div><!-- /.container-fluid -->
        </section>

        <div class="modal fade" id="modal-xl">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="card-header bg-blue">
                        <h3 class="card-title" id="title-model">Thay đổi thông tin</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form method="POST" id="formDataUser" action="{{route('admin.changeUser')}}">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label>Email: {{$user->email}}</label>
                                <input type="hidden" id="txtID" name="iduser" value="{{$user->id}}">
                            </div>
                            <div class="form-group">
                                <label>Tên người dùng:</label>
                                <input type="text" id="txtname" name="fullname" value="{{$user->fullname}}" class="form-control" placeholder="Nhập tên người dùng">
                            </div>
                            <div class="form-group">
                                <label>Số điện thoại:</label>
                                <input type="text" id="txtphone" name="phone" value="{{$user->phone}}" class="form-control" placeholder="Nhập số điện thoại">
                            </div>
                            <div class="form-group d-flex justify-content-between">
                                <div class="col-9 p-0">
                                    <label>Ảnh đại diện:</label>
                                    <div class="d-flex align-items-center p-0">
                                        <div class="input-group-prepend position-absolute top-0 left-0">
                                            <button type="button" id="lfm" data-input="txtimage" data-preview="holder" class="btn btn-primary" style="scale: 0.9">
                                                <i class="fas fa-image"></i>
                                            </button>
                                        </div>
                                        <!-- /btn-group -->
                                        <input id="txtimage" class="form-control" style="padding-left: 45px;" type="text" name="avatar" readonly value="{{$user->avatar}}">
                                    </div>
                                </div>
                                <div id="holder" class="row col-3"  data-width="5rem" data-height="5rem" data-circle="50%">
                                    <img src="{{$user->avatar}}" style="height: 5rem; width: 5rem; border-radius: 50%;" alt="{{$user->avatar}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Đổi mật khẩu (checked để đổi mật khẩu):</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <input type="checkbox" title="Checked để đổi mật khẩu" id="check-open-pass">
                                        </span>
                                    </div>
                                    <input type="password" id="txtpass" name="password" class="form-control change-pass" disabled placeholder="Nhập mật khẩu muốn đổi(checked trước khi nhập)">
                                    <button class="btn btn-outline-secondary change-pass" type="button" id="btn-eye-pass" data-eye="false" disabled><i class="fas fa-eye-slash"></i></button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary" form="formDataUser" id="submitForm">Xác nhận</button>
                    </div>
                </div>
              <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-3">
                        <!-- Profile Image -->
                        <div class="card card-primary card-outline">
                            <div class="card-body box-profile">
                                <div class="text-center">
                                    <img src="{{$user->avatar}}" style="width: 100px;height: 100px;" class="profile-user-img img-fluid img-circle" alt="{{$user->fullname}}">
                                </div>
                                <h3 class="profile-username text-center">{{$user->fullname}}</h3>
                                <p class="text-muted text-center">{{$user->name_manager()}}</p>
                                <ul class="list-group list-group-unbordered mb-3">
                                    <li class="list-group-item">
                                        <b>Số truyện được quản lý:</b> <a class="float-right">{{$user->hasManagerStories()->count()}}</a>
                                    </li>
                                </ul>
                                @if ($user->root < 0)
                                    <span class="badge bg-warning w-100 p-3" style="font-size: 1.1rem;">Chưa kích hoạt</span>
                                @else
                                    @if ($user->settings()->status == 1)
                                        <span class="badge bg-success w-100 p-3" style="font-size: 1.1rem;">Đang hoạt động</span>
                                    @else
                                        <span class="badge bg-danger w-100 p-3" style="font-size: 1.1rem;" id="view_offline"></span>
                                    @endif
                                @endif
                                @if ($user->root >= 0)
                                    @if (Auth::user()->root == 1 && $user->id!=Auth::user()->id)
                                    <a href="{{route('admin.users.lock', ['user'=>$user->id])}}" class="btn btn-danger w-100 mt-2">Khóa tài khoản</a>
                                    @endif
                                @else
                                <a href="{{route('admin.users.unlock', ['user'=>$user->id])}}" class="btn btn-primary w-100 mt-2">Kích hoạt tài khoản</a>
                                @endif
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->

                        <!-- About Me Box -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Thông tin cá nhân:</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <strong><i class="fas fa-envelope mr-1"></i>Email:</strong>
                                <p class="text-muted">{{$user->email}}</p>
                                <hr>
                                <strong><i class="fas fa-phone mr-1"></i>Số điện thoại:</strong>
                                <p class="text-muted">{{$user->phone}}</p>
                                <hr> 
                                <strong><i class="fas fa-heart mr-1"></i>Thể loại ưu thích:</strong>
                                <p class="text-muted"></p>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-9">
                        <div class="card">
                            <div class="card-header p-2">
                                <ul class="nav nav-pills">
                                    <li class="nav-item"><a class="nav-link active" href="#libray-stories" data-toggle="tab">Tủ truyện</a></li>
                                    <li class="nav-item"><a class="nav-link" href="#request-add-stories" data-toggle="tab">Các yêu cầu đã gửi</a></li>
                                </ul>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="tab-content">
                                    <div class="active tab-pane" id="libray-stories">
                                        @if ($user->hasManagerStories()->count() > 0)
                                            @foreach ($user->hasManagerStories() as $story)
                                            <div class="post">
                                                <div class="user-block">
                                                    <img src="{{$story->image}}" style="width: 40px; height: 60px;" alt="{{$story->name}}">
                                                    
                                                    <span class="username">
                                                        <a >{{$story->name}}</a>
                                                        @if (Auth::user()->root == 1)
                                                        <a href="{{route('lockManagerStory', ['user'=>$user->id, 'story'=>$story->id])}}" 
                                                            class="float-right btn-tool" title="Bỏ quyền quản lý"><i class="fas fa-times"></i></a>
                                                        @endif
                                                    </span>
                                                    <span class="description" data-time="{{$story->created_at}}"></span>
                                                </div>
                                                <p>
                                                    <a href="story/{{$story->slug}}" target="_blank" class="link-black text-sm mr-2"><i class="fas fa-share mr-1"></i>Xem</a>
                                                </p>
                                            </div>
                                            @endforeach
                                        @else
                                        <div class="user-block">
                                            Chưa có truyện quản lý.
                                        </div>
                                        @endif
                                    </div>
                                    <div class="tab-pane" id="request-add-stories">
                                        @if ($user->requestAddStory()->count() > 0)
                                            @foreach ($user->requestAddStory() as $requestAddStory)
                                            <div class="post">
                                                <i class="fas fa-bookmark" style="font-size: 1.8rem; margin-top: 10px;"></i>
                                                <div class="user-block">
                                                    <span class="username">
                                                        <a >Gửi yêu cầu thêm truyện từ nguồn: {{$requestAddStory->source}}</a>
                                                    </span>
                                                    <span class="description" data-text="Gửi yêu cầu " data-time="{{$requestAddStory->updated_at}}"></span>
                                                </div>
                                                <p>
                                                    <span>Link truyện: {{$requestAddStory->link}}</span><br>
                                                    @if ($requestAddStory->status == 1)
                                                    <span class="badge bg-success">Đã hoàn thành</span>
                                                    <a href="story/{{$requestAddStory->next}}" target="_blank" class="link-black text-sm mr-2"><i class="fas fa-share mr-1"></i>Xem</a>
                                                    @elseif ($requestAddStory->status == 0)
                                                    <span class="badge bg-warning">Đang chờ xử lý</span>
                                                    @else
                                                    <span class="badge bg-danger">Đã hủy yêu cầu</span>
                                                    @endif
                                                </p>
                                            </div>
                                            @endforeach
                                        @else
                                        <div class="user-block">
                                            Chưa có yêu cầu nào.
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <!-- /.tab-content -->
                            </div><!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection

@section('js')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script src="assets/admins/plugins/sweetalert2/sweetalert2.all.min.js"></script>
<script>
    @if (Session::has('msg'))
        Swal.fire('{{Session::get('msg')}}', "", '{{Session::get('type')}}');
    @endif
    function renderTime(time) {
        let miliseconds = (new Date().getTime() - new Date(time).getTime())/86400000;
        let full_text_time = '';
        if(miliseconds > 1){
            full_text_time = Math.round(miliseconds)+' ngày';
        }else{
            if(miliseconds * 24 > 1){
                full_text_time = Math.round(miliseconds * 24)+' giờ';
            }else{
                if(miliseconds * 24 * 60 > 1){
                    full_text_time = Math.round(miliseconds * 24 *60)+' phút';
                }else{
                    full_text_time = (Math.round(miliseconds * 24 *60 * 60)<0?Math.round(miliseconds * 24 *60 * 60):1)+' giây';
                }
            }
        }
        return full_text_time+' trước';
    }
    $('#view_offline').text('Offline '+renderTime('{{$user->settings()->updated_at}}'));
    const addTimes = document.querySelectorAll('.post .user-block .description');
    // console.log(addTimes);
    addTimes.forEach(element => {
        element.innerText = 'Đăng vào ' + renderTime(element.getAttribute('data-time'));
    });

    //link file manager
    $('#lfm').filemanager('image');

    $('#txtimage').change(function (e) { 
        e.preventDefault();
        let value = $(this).val();
        let host = '{{env('APP_URL')}}';
        $(this).val(value.slice(host.length-1));
    });
    
    $('#check-open-pass').change(function (e) { 
        e.preventDefault();
        let open = $(this).is(':checked');
        if(open) {
            $('.change-pass').prop('disabled', false);
        }else{
            $('#txtpass').attr('type', 'password');
            $('#txtpass').val('');
            $('#btn-eye-pass').html('<i class="fas fa-eye-slash"></i>');
            $('.change-pass').prop('disabled', true);
        }
    });

    $('#btn-eye-pass').click(function (e) { 
        e.preventDefault();
        if($(this).attr('data-eye') == 'true'){
            $('#txtpass').attr('type', 'password');
            $(this).html('<i class="fas fa-eye-slash"></i>');
            $(this).attr('data-eye', 'false');
        }else{
            $('#txtpass').attr('type', 'text');
            $(this).html('<i class="fas fa-eye"></i>');
            $(this).attr('data-eye', 'true');
        }
    });

    // var data_old = {
    //     name: '{{$user->fullname}}',
    //     phone: '{{$user->phone}}',
    //     avatar: '{{$user->avatar}}',
    // };

    // $('#formDataUser').submit(function (e) { 
    //     e.preventDefault();
        
    // });
</script>
@endsection