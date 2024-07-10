@extends('admins.layout')

@section('css')

@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{$user->name_manager()}}: {{$user->fullname}}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('admin.home')}}">Trang chủ</a></li>
                            <li class="breadcrumb-item"><a href="{{route('admin.users.index')}}">Danh sách người dùng</a></li>
                            <li class="breadcrumb-item active">{{$user->name_manager()}}: {{$user->fullname}}</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

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
                                @if ($user->root >= 0 && (Auth::user()->root < $user->root || $user->root==0))
                                <a class="btn btn-danger w-100 mt-2">Khóa tài khoản</a>
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
                                                        <a href="#" class="float-right btn-tool" title="Bỏ quyền quản lý"><i class="fas fa-times"></i></a>
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
<script>
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
</script>
@endsection