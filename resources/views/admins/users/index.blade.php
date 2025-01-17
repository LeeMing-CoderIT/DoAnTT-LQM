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

        <div class="modal fade" id="modal-xl">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="card-header bg-blue">
                        <h3 class="card-title">Cập nhật người dùng</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form method="POST" id="formDataUser" action="{{route('admin.users.adminEdit')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label>Email:</label>
                                <div class="input-group">
                                    <input type="text" id="txtemail" class="form-control" readonly>
                                    <input type="hidden" id="txtID" name="id" value="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Tên người dùng:</label>
                                <input type="text" name="fullname" id="txtfullname" class="form-control" placeholder="Nhập tên người dùng">
                            </div>
                            <div class="form-group">
                                <label>Số điện thoại:</label>
                                <input type="text" id="txtphone" name="phone" class="form-control" placeholder="Nhập số điện thoại">
                            </div>
                            <div class="form-group d-flex">
                                <div class="col-9 m-0 p-0">
                                    <label>Ảnh đại diện:</label>
                                    <div class="input-group m-0">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="txtavatar" name="avatar" id="txtavatar">
                                            <label class="custom-file-label" for="txtavatar" id="txtnamefile">Chọn ảnh đại diện</label>
                                        </div>
                                        <div class="input-group-append">
                                            <span class="input-group-text">Tải ảnh lên</span>
                                        </div>
                                      </div>
                                </div>
                                <div class="col-3">
                                    <img class="ml-3" src="" alt="" id="imgavatar" style="width: 80px; height: 80px; border-radius: 50%;">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Đổi mật khẩu:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <input  id="check-change-pass" type="checkbox" title="Checked để đổi mật khẩu">
                                        </span>
                                    </div>
                                    <input type="password" id="txtpassword" class="form-control" title="Nhập mật khẩu mật khẩu" disabled>
                                    <button style="border: 1px solid #6c757d; background: none; color: white; border-radius: 0 .25rem .25rem 0;" id="show-pass" data-open="false"><i class="fas fa-eye-slash"></i></button>
                                </div>
                            </div>
                            
                        </div>
                    </form>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary" form="formDataUser">Cập nhật</button>
                    </div>
                </div>
              <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

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
                                <option value="2">Biên tập viên</option>
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
<script src="assets/admins/plugins/sweetalert2/sweetalert2.all.min.js"></script>
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
                                <a href="javascript:void(0)" onclick="editUser(${user.id});" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="javascript:void(0)" onclick="deleteUser(${user.id});" class="btn btn-sm btn-danger">
                                    <i class="fas fa-times"></i>
                                </a>
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
    $('#check-change-pass').change(function (e) { 
        e.preventDefault();
        let open = $(this).is(':checked');
        $('#txtpassword').prop('disabled', !open);
    });
    $('#show-pass').click(function (e) { 
        e.preventDefault();
        let open = $(this).attr('data-open');
        if(open == 'false'){
            $(this).html('<i class="fas fa-eye"></i>');
            $('#txtpassword').attr('type', 'text');
            $(this).attr('data-open', 'true');
        }else{
            $(this).html('<i class="fas fa-eye-slash"></i>');
            $('#txtpassword').attr('type', 'password');
            $(this).attr('data-open', 'false');
        }
    });
    function editUser(id){
        $.ajax({
            type: "GET",
            url: `admin/users/show/${id}`,
            data: {},
            success: function (response) {
                $('#txtID').val(response.id);
                $('#txtemail').val(response.email);
                $('#txtfullname').val(response.fullname);
                $('#txtphone').val(response.phone);
                $('#imgavatar').attr('src',response.avatar);
                $('#txtavatar').val('');
                $('#modal-xl').modal('show');
                // console.log(response);
            }
        });
    }
    $('#formDataUser').submit(function (e) { 
        e.preventDefault();
        var formData = new FormData();
        formData.append('fullname', $('#txtfullname').val());
        formData.append('phone', $('#txtphone').val());
        formData.append('avatar', $('#txtavatar')[0].files[0]);
        formData.append('_token', '{{csrf_token()}}');
        if($('#check-change-pass').is(':checked')){
            formData.append('password', $('#txtpassword').val());
        }
        $.ajax({
            type: "POST",
            url: `admin/users/edit/${$('#txtID').val()}`,
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                if(response.success){
                    $('#modal-xl').modal('hide');
                    loadContacts();
                }
                Swal.fire(response.msg, "", response.type);
            }
        });
    });
    function deleteUser(id){
        Swal.fire({
            title: "Bạn có chắc chắn muốn xóa không?",
            showCancelButton: true,
            confirmButtonText: "Xác nhận",
            cancelButtonText: "Hủy",
            icon: "question",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "DELETE",
                    url: `admin/users/delete/${id}`,
                    data: {
                        _token: '{{csrf_token()}}',
                    },
                    success: function (response) {
                        if(response.success){
                            loadContacts();
                        }
                        Swal.fire(response.msg, "", response.type);
                    }
                });
            }
        });
    }
    $('#txtavatar').change(function (e) { 
        e.preventDefault();
        if($(this).val()){
            var reader  = new FileReader();
            reader.onloadend = function () {
                $('#imgavatar').attr('src', reader.result);
            }
            if (e.target.files[0]) {
                $('#txtnamefile').html(e.target.files[0].name);
                // console.log(e.target.files[0].name);
                reader.readAsDataURL(e.target.files[0]);
            }
        }
    });
</script>
@endsection