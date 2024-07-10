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
                        <h1>Danh sách người dùng</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('home')}}">Trang chủ</a></li>
                            <li class="breadcrumb-item active">Danh sách người dùng</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="form-group col-3">
                            <label>Vị trí:</label>
                            <select id="root" class="form-control">
                                <option value="*">Tất cả</option>
                                <option value="1">Admin</option>
                                <option value="0" selected>Người dùng</option>
                                <option value="-1">Tài khoản chưa kích hoạt</option>
                            </select>
                        </div>
                        <div class="form-group col-6">
                            <label>Tìm kiếm:</label>
                            <input type="text" id="txtSearch" class="form-control" placeholder="Nhập tên người dùng hoặc email để tìm kiếm">
                        </div>
                        <div class="form-group col-3">
                            <label>Trạng thái:</label>
                            <select id="status" class="form-control">
                                <option value="*">Tất cả</option>
                                <option value="0">Không hoạt động</option>
                                <option value="1" selected>Đang hoạt động</option>
                            </select>
                        </div>
                    </div>
                    <div class="row justify-content-between">
                        <div class="form-group col-4">
                            <label>Hiển thị:</label>
                            <select id="max" class="form-control">
                                <option value="1">1 người</option>
                                <option value="3" selected>1 hàng</option>
                                <option value="6">2 hàng</option>
                                <option value="9">3 hàng</option>
                                <option value="12">4 hàng</option>
                            </select>
                        </div>
                        <div class="form-group col-6 d-flex flex-column align-items-start" id="pagination">
                            <label>Trang:</label>
                            <nav aria-label="Contacts Page Navigation">
                                <ul class="pagination justify-content-center m-0"></ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Default box -->
            <div class="card card-solid">
                <div class="card-body" id="">
                    <div class="row" id="list_users"></div>
                    <div class="row justify-content-center" id="loading_users"><img src="storage/images/loading.gif" alt=""></div>
                </div>
                <!-- /.card-footer -->
            </div>
            <!-- /.card -->
    
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection

@section('js')
<script>
    var page = 1;
    function getData() {
        let data = {};
        let root = $('#root').val();
        let search = $('#txtSearch').val();
        let status = $('#status').val();
        data.max = Number($('#max').val());
        data.page = page;
        if(root != '*') data.root = Number(root);
        if(search.length > 0) data.search = search;
        if(status != '*') data.status = Number(status);
        return data;
    }
    $('#root').change(function (e) { 
        e.preventDefault();
        page = 1;
        loadContacts();
    });
    $('#txtSearch').change(function (e) { 
        e.preventDefault();
        page = 1;
        loadContacts();
    });
    $('#txtSearch').keyup(function (e) { 
        page = 1;
        loadContacts();
    });
    $('#status').change(function (e) { 
        e.preventDefault();
        page = 1;
        loadContacts();
    });
    $('#max').change(function (e) { 
        e.preventDefault();
        page = 1;
        loadContacts();
    });
    loadContacts();

    function loadContacts() {
        let data = getData();
        $('#pagination').removeClass('d-flex');
        $('#list_users').hide();
        $('#loading_users').show();
        $.ajax({
            type: "get",
            url: "admin/users/all",
            data: data,
            success: function (response) {
                $('#list_users').html('');
                console.log(response);
                if(response.success){
                    if(response.pages > 1){
                        $('#pagination').addClass('d-flex');
                        $('#pagination ul').html('');
                        for (let i = 0; i < response.pages; i++) {
                            $('#pagination ul').append(`<li class="page-item ${(i==page-1)?'active':''}"><button class="page-link">${(i+1)}</button></li>`);
                        }
                        const btnPage = document.querySelectorAll('#pagination ul li');
                        btnPage.forEach((element, index) =>{
                            element.addEventListener('click', (e) =>{
                                page = Number(element.querySelector('button').innerText);
                                loadContacts();
                            });
                        });
                    }else{
                        $('#pagination').hide();
                    }
                    response.data.forEach((user) => {
                        $('#list_users').append(setContact(user));
                    });
                }
                else{
                    $('#list_users').html('<span>Không có tài khoản nào phù hợp tìm kiếm.</span>');
                    $('#pagination').hide();
                }
                $('#list_users').show();
                $('#loading_users').hide();
            }
        });
    }

    function setContact(user){
        return `<div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
                    <div class="card bg-light d-flex flex-fill">
                        <div class="card-header text-muted border-bottom-0">${user.email}</div>
                        <div class="card-body pt-0">
                            <div class="row">
                                <div class="col-7">
                                    <h2 class="lead"><b>${user.fullname}</b></h2>
                                    <p class="text-muted text-sm">
                                        <b>Hoạt động gần nhất:</b>
                                        <span class="badge bg-${(user.root < 0)?'warning':(user.settings.status==1?'success':'danger')}" 
                                            style="padding: 5px; font-size: 0.8rem">${(user.root < 0)?'Chưa kích hoạt':(user.settings.status==1?'Online':'Offline '+renderTime(user.settings.updated_at))}</span>
                                    </p>
                                    <ul class="ml-4 mb-0 fa-ul text-muted">
                                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span> Liên hệ: ${(user.phone && user.phone !="")?user.phone:'chưa có'}</li>
                                    </ul>
                                </div>
                                <div class="col-5 text-center">
                                    <img src="${user.avatar}" alt="${user.fullname}" class="img-circle img-fluid" style="width:80px;height:80px;">
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="text-right">
                                <a href="admin/users/show/${user.id}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-user"></i> Xem thông tin
                                </a>
                            </div>
                        </div>
                    </div>
                </div>`;
    }
    function renderTime(times) {
        let miliseconds = (new Date().getTime() - new Date(times).getTime())/86400000;
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
</script>
@endsection