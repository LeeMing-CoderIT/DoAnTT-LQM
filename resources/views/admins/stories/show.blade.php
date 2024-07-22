@extends('admins.layout')

@section('css')
<!-- DataTables -->
<link rel="stylesheet" href="assets/admins/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="assets/admins/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="assets/admins/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
<link rel="stylesheet" href="assets/admins/plugins/sweetalert2/sweetalert2.min.css">
<!-- summernote -->
<link rel="stylesheet" href="assets/admins/plugins/summernote/summernote-bs4.min.css">
<style>
    #selectCategories .fas{
        position: absolute;
        top: 50%;
        right: 0;
        translate: 0 -50%;
        padding: 20px;
        border-radius: 50%;
        cursor: pointer;
    }
    .form-control, .card{
        transition: all 0.2s linear;
    }
    #collapseCategories{
        transition: all 0.2s linear;
        display: block; scale: 1 0; height: 0;
    }
    #collapseCategories.active{
        scale: 1; height: auto;
    }
    .dark-mode .card.card-custom span{
        color: #fff;
    }
    .card.card-custom span{
        color: #000;
    }
    .show-detail{
        transition: all 0.2s linear;
        scale: 1 0;
        height: 0;
    }
    .show-detail.show{
        scale: 1;
        height: auto;
    }
</style>
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Truyện: {{$story->name}}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('admin.home')}}">Trang chủ</a></li>
                            <li class="breadcrumb-item"><a href="{{route('admin.stories.index')}}">Danh sách truyện</a></li>
                            <li class="breadcrumb-item active">{{$story->name}}</li>
                        </ol>
                    </div>
                </div>
                <div class="row d-flex justify-content-end">
                    <button type="button" class="btn btn-primary mr-2" id="btn-show-detail">
                        Thông tin chi tiết truyện
                    </button>
                    <button type="button" class="btn btn-primary mr-2" data-toggle="modal" data-target="#modal-xll" id="btn-add-manager">
                        Chia sẻ quyền quản lý
                    </button>
                    <button type="button" class="btn btn-primary mr-2 d-none" id="update-chapters-starting">
                        Bắt đầu cập nhật
                    </button>
                    <button type="button" class="btn btn-primary mr-2" id="update-chapters-source">
                        Cập nhật từ nguồn
                    </button>
                    <button type="button" class="btn btn-primary addData" data-toggle="modal" data-target="#modal-xl">
                        Thêm chương
                    </button>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <div class="modal fade" id="modal-xll">
            <div class="modal-dialog modal-xll">
                <div class="modal-content">
                    <div class="card-header bg-blue">
                        <h3 class="card-title">Chia sẻ quyền quản lý</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form method="POST" id="formData" action="{{route('admin.addManager', ['story'=>$story->id])}}">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label>Tìm kiếm:</label>
                                <input type="text" id="txtsearch-user" class="form-control" placeholder="Nhập để tìm kiếm theo tên hoặc email">
                            </div>
                            <div class="form-group">
                                <label>Chọn người dùng:</label>
                                <select id="sl-list-user" class="form-control" multiple="10"></select>
                            </div>
                            <div class="form-group d-flex justify-content-end">
                                <button type="button" id="add-user" class="btn btn-primary">Thêm</button>
                            </div>
                            <div class="form-group">
                                <label>Các người dùng đã chọn:</label>
                                <input type="hidden" name="txtlist-selected" id="txtlist-selected" value="[]">
                                <select id="list-user-selected" class="form-control" multiple="10"></select>
                            </div>
                        </div>
                    </form>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary" form="formData">Xác nhận</button>
                    </div>
                </div>
              <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

        <div class="modal fade" id="modal-xl">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="card-header bg-blue">
                        <h3 class="card-title" id="title-model"></h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form method="POST" id="formDataChapter" data-submit="">
                        <div class="card-body">
                            <input type="hidden" name="txtID" id="txtID" value="">
                            <div class="form-group">
                                <label>Nguồn chương (nếu có):</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <input type="checkbox" title="Checked để lấy chương từ nguồn" id="check-open-source">
                                        </span>
                                    </div>
                                    <input type="text" id="select-source" class="form-control" readonly value="{{$story->source['source']??null}}">
                                </div>
                            </div>
                            <div class="form-group collapse" id="collapse-source">
                                <label>Link nguồn chương:</label>
                                <input type="text" name="source" id="txtsource" class="form-control" readonly placeholder="Nguồn chương: truyenfull.vn">
                            </div>
                            <div class="form-group">
                                <label>Tên chương:</label>
                                <input type="text" id="txtname" name="name" class="form-control" placeholder="Nhập tên chương">
                            </div>
                            <div class="form-group">
                                <label id="propose">Số chương:</label>
                                <input type="number" id="numchap" name="index_chap" value="0" min="0" class="form-control">
                            </div>
                            <div class="form-group m-0 p-0">
                                <label>Nội dung truyện:</label>
                                <div class="position-relative" style="padding: 1px;">
                                    <textarea id="summernote" name="content" class="form-control position-absolute h-100" style="left: 0; top: 0;"></textarea>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary" form="formDataChapter" id="submitForm"></button>
                    </div>
                </div>
              <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

        <!-- Main content -->
        <section class="content show-detail">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                Thông tin truyện
                                <button class="btn btn-danger" id="btn-close-detail" style="position: absolute; top: -3px; right: -3px;"><i class="fas fa-times"></i></button>
                                <button class="btn btn-warning" id="btn-edit-story" style="position: absolute; top: -3px; right: 40px;"><i class="fas fa-edit"></i></button>
                            </div>
                            <div class="card-body">
                                <form method="POST" id="formDataStory">
                                    <div class="form-group">
                                        <label>Nguồn truyện: <span style="font-weight: normal;">{{$story->source?$story->source['source'].' - '.$story->source['link']:'<không cớ>'}}</span></label>
                                    </div>
                                    <div class="form-group">
                                        <label>Tên tác giả: <span class="show-view" id="lbauthor" style="font-weight: normal;"></span></label>
                                        <input type="text" id="txtauthor" name="author" class="form-control edit d-none" placeholder="Nhập tên tác giả">
                                    </div>
                                    <div class="form-group">
                                        <label>Thể loại: <span class="show-view" id="lbcategories" style="font-weight: normal;"></span></label>
                                        <div class="form-control h-auto position-relative p-1 border-0 justify-content-center align-items-center edit d-none">
                                            <input type="text" class="form-control position-absolute top-0 left-0 h-100" id="txtCategories" name="categories">
                                            <div class="card card-custom w-100 m-0">
                                                <a class="d-block w-100 position-relative" id="selectCategories">
                                                    <div class="card-header"></div>
                                                    <div class="icon" data-open="false"><i class="fas fa-chevron-down"></i></div>
                                                </a>
                                                <div id="collapseCategories" class="collapse" data-parent="#accordion">
                                                    <div class="card-body"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Tên truyện: <span class="show-view" id="lbname" style="font-weight: normal;"></span></label>
                                        <input type="text" id="txtnamestory" name="name" class="form-control edit d-none" placeholder="Nhập tên truyện">
                                    </div>
                                    <div class="form-group">
                                        <label>Đường dẫn: <span class="show-view" id="lbslug" style="font-weight: normal;"></span></label>
                                        <input type="text" id="txtslug" name="slug" readonly class="form-control edit d-none" placeholder="Slug của truyện">
                                    </div>
                                    <div class="form-group d-flex justify-content-between">
                                        <div class="col-9 p-0">
                                            <label>Ảnh bìa truyện: <span class="show-view" id="lbimage" style="font-weight: normal;"></span></label>
                                            <div class="align-items-center p-0 edit d-none">
                                                <div class="input-group-prepend position-absolute top-0 left-0">
                                                    <button type="button" id="lfm" data-input="txtimage" data-preview="holder" class="btn btn-primary" style="scale: 0.9">
                                                        <i class="fas fa-image"></i>
                                                    </button>
                                                </div>
                                                <!-- /btn-group -->
                                                <input id="txtimage" class="form-control" style="padding-left: 45px;" type="text" name="image" readonly>
                                            </div>
                                        </div>
                                        <div id="holder" class="row col-2" data-height="6rem">
                                            <img src="" style="height: 6rem;" alt="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Trạng thái: <span class="show-view" id="lbstatus" style="font-weight: normal;"></span></label>
                                        <select id="slStatus" name="status" class="form-control edit d-none">
                                            <option value="0">Hoàn thành</option>
                                            <option value="1">Đang ra</option>
                                            <option value="2">Tạm dừng</option>
                                        </select>
                                    </div>
                                    <div class="form-group m-0 p-0">
                                        <label>Tóm tắt:</label>
                                        <div class="show-view p-2" id="lbdescription" style="font-weight: normal; border: 1px solid white; border-radius: 10px;"></div>
                                        <div class="position-relative edit textaria d-none" style="padding: 1px;">
                                            <textarea id="summernotestory" name="description" class="form-control position-absolute h-100" style="left: 0; top: 0;"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group d-flex justify-content-end mt-3">
                                        <button class="btn btn-default mr-2 d-none" type="button" id="btn-reset-story">Hủy</button>
                                        <button class="btn btn-primary d-none" type="submit" id="btn-submit-story">Xác nhận</button>
                                    </div>
                                </form>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
        <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">Danh sách chương của truyện</div>
                            <div class="card-body">
                                <table id="example" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%;">#</th>
                                            <th style="width: 50%;">Tên chương</th>
                                            <th style="width: 10%;">Số chương</th>
                                            <th style="width: 10%;">Tùy biến</th>
                                        </tr>
                                    </thead>
                                <tbody>

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Tên chương</th>
                                        <th>Số chương</th>
                                        <th>Tùy biến</th>
                                    </tr>
                                </tfoot>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
          <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
      </div>
    <!-- /.content-wrapper -->
@endsection

@section('js')
<!-- DataTables  & Plugins -->
<script src="assets/admins/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="assets/admins/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="assets/admins/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="assets/admins/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="assets/admins/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="assets/admins/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="assets/admins/plugins/jszip/jszip.min.js"></script>
<script src="assets/admins/plugins/pdfmake/pdfmake.min.js"></script>
<script src="assets/admins/plugins/pdfmake/vfs_fonts.js"></script>
<script src="assets/admins/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="assets/admins/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="assets/admins/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<script src="assets/admins/plugins/sweetalert2/sweetalert2.all.min.js"></script>
<!-- Summernote -->
<script src="assets/admins/plugins/summernote/summernote-bs4.min.js"></script>
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<!-- jquery-validation -->
<script src="assets/admins/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="assets/admins/plugins/jquery-validation/additional-methods.min.js"></script>

<script>
    var updateChapters = 0, pagesCrawler = 0, newChapterUpdate = 0,
    lastChapter = {{$new_chapter->index_chap??0}}, lastSourceChapter = '{{$new_chapter->source['link']??''}}',
    nowPage = {{$new_chapter->source['page']??1}},
    continueLoading = false, continueStarting = false,
    listLinks = [], indexLoading = 0, dataResponse = null,
    linkSource = '{{$story->source['link']??null}}', sourceStudio = '{{$story->source['source']??null}}';
    
    $.validator.addMethod("checkSource", function(value, element, param){
        return ($('#formDataChapter').attr('data-submit')=='add')?successSource:true;
    },"Đường dẫn nguồn không hợp lệ.");
    $.validator.setDefaults({
        submitHandler: function (e) {
            var dataForm = {};
            if (dataResponse != null) {
                dataForm = dataResponse;
            } else { 
                dataForm.name = $('#txtname').val();
                dataForm.index_chap = Number($('#numchap').val());
                dataForm.content = $('#summernote').summernote('code');
            }
            dataForm._token = '{{csrf_token()}}';
            console.log(dataForm);
            let id = Number($('#txtID').val());
            let method = $('#formDataChapter').attr('data-submit');
            if(method == 'edit'){
                $.ajax({
                    type: "PATCH",
                    url: `/admin/stories/{{$story->id}}/chapters/edit/${id}`,
                    data: dataForm,
                    success: function (response) {
                        console.log(response);
                        if(response.success) {
                            if(response.msg.type == 'success'){
                                $('#modal-xl').modal('hide');
                                var oTable = $('#example').dataTable();
                                oTable.fnDraw(false);
                            }
                            Swal.fire(response.msg.msg, "", response.msg.type);
                        }
                    }
                });
            }
            else if(method == 'add'){
                $.ajax({
                    type: "POST",
                    url: `/admin/stories/{{$story->id}}/chapters/add`,
                    data: dataForm,
                    success: function (response) {
                        if(response.success) {
                            if(response.msg.type == 'success'){
                                $('#modal-xl').modal('hide');
                                var oTable = $('#example').dataTable();
                                oTable.fnDraw(false);
                            }
                            Swal.fire(response.msg.msg, "", response.msg.type);
                        }
                    }
                });
            }
            dataResponse = null;
        }
    });
    $('#formDataChapter').submit(function (e) { 
        e.preventDefault();
    });
    $('#formDataChapter').validate({
        rules: {
            name: {
                required: true,
            },
            index_chap: {
                min: '1',
            },
            content: {
                required: true,
            },
        },
        messages: {
            name: {
                required: 'Tên chương không được bỏ trống',
            },
            index_chap: {
                min: 'Số chương không được nhỏ hơn 1',
            },
            content: {
                required: 'Nội dung quan trọng nhất, cấm bỏ.',
            },
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        }
    });
    //Mở Form thêm truyện
    $('.addData').click(function (e) { 
        e.preventDefault();
        $('#formDataChapter').trigger('reset');
        $('#formDataChapter').attr('data-submit', 'add');
        $('#title-model').text('Thông tin chương cần tạo mới');
        $('#submitForm').text('Thêm mới');
        $('#numchap').prop('readonly', false);
        $('#txtname').val('');
        $.ajax({
            type: "get",
            url: `/admin/stories/{{$story->id}}/chapters/show`,
            data: {
                show: 'new-chapter'
            },
            success: function (response) {
                if(response){
                    if(response.length == 0) $('#numchap').val(1);
                    else $('#numchap').val(response.index_chap+1);
                    $('#propose').text('Số chương: (Đề xuất)');
                    $('#numchap').change(function (e) { 
                        e.preventDefault();
                        $('#propose').text('Số chương:');
                    });
                }
            }
        });
        $('#summernote').summernote('code', '');
        $('#txtID').val('');
    });

    //Mở Form sửa truyện
    function editData(id) {
        $('#formDataChapter').trigger('reset');
        $('#formDataChapter').attr('data-submit', 'edit');
        $('#title-model').text('Thông tin chương cần cập nhật');
        $('#submitForm').text('Cập nhật');
        $.ajax({
            type: "get",
            url: `/admin/stories/{{$story->id}}/chapters/show/${id}`,
            data: {
                show: 'chapter'
            },
            success: function (response) {
                console.log(response);

                $('#txtID').val(response.id);
                $('#txtname').val(response.name);
                $('#numchap').val(response.index_chap);
                $('#propose').text('Số chương:');
                $('#summernote').summernote('code', response.content);
                if(response.source){
                    $('#check-open-source').prop('checked', true);
                    $('#select-source').val(response.source.source);
                    $('#txtsource').val(response.source.link);
                    $('#txtsource').prop('readonly', false);
                    $('#collapse-source').addClass('show');
                }
            }
        });
    }
    //Thay đổi thủ công
    
    $('#check-open-source').change(function (e) { 
        e.preventDefault();
        let open = $(this).is(':checked');
        if(open){
            $('#txtsource').prop('readonly', false);
            $('#collapse-source').addClass('show');
        }else{
            $('#txtsource').val('');
            $('#txtsource').prop('readonly', true);
            $('#collapse-source').removeClass('show');
            $('#formDataChapter').trigger('reset');
            $('#summernote').summernote('code', '');
        }
    });
    $('#select-source').change(function (e) { 
        e.preventDefault();
        loadingChapter();
    });
    $('#txtsource').change(function (e) { 
        e.preventDefault();
        loadingChapter();
    });
    function loadingChapter(bug = false){
        let open = $('#check-open-source').is(':checked');
        let txtSource = $('#txtsource').val();
        let selSource = $('#select-source').val();
        if(open && txtSource != '' && selSource != ''){
            $.ajax({
                type: "get",
                url: `/crawler`,
                data: {
                    source: sourceStudio, type: 'chapter', chapterIndex: lastChapter, story_id: {{$story->id}},
                    link: $('#txtsource').val(), page: nowPage, bug: bug, addNow: false,
                },
                success: function (response) {
                    console.log(response);
                    if(response){
                        if(response.error){
                            let newwin = window.open(response.error, '_blank');
                            loadingChapter(true);
                            setTimeout(() => {
                                newwin.close();
                            }, 10);
                        }else{
                            successSource = true;
                            dataResponse = response.original;
                            $('#txtname').val(response.original.name);
                            $('#summernote').summernote('code', response.original.content);
                        }
                    }else{
                        successSource = false;
                        $('#txtname').val('');
                        $('#summernote').summernote('code', '');
                    }
                }
            });
        }
    }

    //Xóa truyện
    function deleteData(index_chap){
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
                    url: `/admin/stories/{{$story->id}}/chapters/delete/${index_chap}`,
                    data: {
                        _token: '{{csrf_token()}}',
                    },
                    success: function (response) {
                        var success = 'error';
                        if(response.success){
                            success = 'success';
                            var oTable = $('#example').dataTable();
                            oTable.fnDraw(false);
                        }
                        Swal.fire(response.msg, "", success);
                    }
                });
            }
        });
    }
    //Bắt đầu cập nhật
    $('#update-chapters-starting').click(function (e) { 
        e.preventDefault();
        continueStarting = !continueStarting;
        if(continueStarting){
            $(this).text('Dừng');
            loadChaptersCrawler({
                source: sourceStudio, type: 'link-chapters', 
                link: linkSource, page: nowPage
            });
        }else{
            $(this).text('Bắt đầu cập nhật');
        }
    });
    function loadChaptersCrawler(data){
        if(data.page <= pagesCrawler && continueStarting){
            $.ajax({
                type: "get",
                url: `/crawler`,
                data: data,
                success: function (response) {
                    console.log(response, nowPage);
                    if(response.error && response.bug){
                        let newwin = window.open(response.error, '_blank');
                        // data.bug = true;
                        loadChaptersCrawler(data)
                        setTimeout(() => {
                            newwin.close();
                        }, 10);
                    }else{
                        listLinks = response;
                        let nextPage = false;
                        if(lastSourceChapter != ''){
                            listLinks.forEach((element, index) => {
                                if(element == lastSourceChapter){
                                    indexLoading = Number(index)+1;
                                    lastSourceChapter = '';
                                    if(indexLoading > listLinks.length - 1){
                                        indexLoading = 0;
                                        nextPage = true;
                                        nowPage = Number(nowPage)+1;
                                        loadChaptersCrawler({
                                            source: sourceStudio, type: 'link-chapters', 
                                            link: linkSource, page: nowPage,
                                        });
                                    }
                                }
                            });
                        }
                        else if(lastSourceChapter == '' && nextPage === false){
                            loadChapter({
                                source: sourceStudio, type: 'chapter', chapterIndex: lastChapter,
                                link: listLinks[indexLoading], page: nowPage
                            });
                        }
                    }
                }
            });
        }else{
            if(newChapterUpdate > 0){
                continueStarting = false;
                $('#update-chapters-starting').text('Bắt đầu cập nhật');
                Swal.fire(`Đã cập nhật hoàn tất toàn bộ chương từ nguồn.`, "", 'success');
                $('#update-chapters-starting').addClass('d-none');
                newChapterUpdate = 0;
            }
        }
    }
    function loadChapter(data){
        if(continueStarting){
            data.story_id = {{$story->id}};
            $.ajax({
                type: "get",
                url: `/crawler`,
                data: data,
                success: function (response) {
                    console.log(response);
                    if(response.error && response.bug){
                        let newwin = window.open(response.error, '_blank');
                        loadChapter(data)
                        setTimeout(() => {
                            newwin.close();
                        }, 10);
                    }else{
                        indexLoading = Number(indexLoading)+1;
                        lastChapter = Number(response.index_chap);
                        newChapterUpdate = Number(newChapterUpdate)+1;
                        var oTable = $('#example').dataTable();
                        oTable.fnDraw(false);
                        if(indexLoading > listLinks.length - 1){
                            // console.log(indexLoading, listLinks.length);
                            indexLoading = 0;
                            nowPage = Number(nowPage)+1;
                            loadChaptersCrawler({
                                source: sourceStudio, type: 'link-chapters', 
                                link: linkSource, page: nowPage,
                            });
                        }else{
                            loadChapter({
                                source: sourceStudio, type: 'chapter', chapterIndex: lastChapter,
                                link: listLinks[indexLoading], page: nowPage
                            });
                        }
                    }
                }
            });
        }else{
            if(newChapterUpdate > 0){
                Swal.fire(`Đã cập nhật hoàn tất ${newChapterUpdate} chương.`, "", 'success');
                newChapterUpdate = 0;
            }
        }
    }

    //cập nhật chương từ nguồn
    $('#update-chapters-source').click(function (e) { 
        e.preventDefault();
        continueLoading = !continueLoading;
        if(continueLoading){
            $(this).text('Dừng');
            loadPagesCrawler({source: sourceStudio, type: 'count-chapters', link: linkSource});
        }else{
            $(this).text('Cập nhật từ nguồn');
        }
    });
    function loadPagesCrawler(data) {
        if(continueLoading){
            data.story_id = {{$story->id}};
            $.ajax({
                type: "get",
                url: `/crawler`,
                data: data,
                success: function (response) {
                    console.log(response);
                    if(response.error && response.bug){
                        let newwin = window.open(response.error, '_blank');
                        // data.bug = true;
                        loadPagesCrawler(data)
                        setTimeout(() => {
                            newwin.close();
                        }, 10);
                    }else{
                        pagesCrawler = response.pages;
                        updateChapters = Number(response.chapters) - Number(lastChapter);
                        continueLoading = false;
                        if(updateChapters > 0){
                            $('#update-chapters-starting').removeClass('d-none');
                            $('#update-chapters-source').text('Cập nhật từ nguồn');
                            Swal.fire(`Có tổng ${updateChapters} chương mới chưa được cập nhật`, "", 'success');
                        }else{
                            $('#update-chapters-starting').addClass('d-none');
                            $('#update-chapters-source').text('Cập nhật từ nguồn');
                            Swal.fire(`Không có chương mới`, "", 'info');
                        }
                    }
                }
            });
        }
    }
    //tạo editor
    var lfm = function(options, cb) {
        var route_prefix = (options && options.prefix) ? options.prefix : '/laravel-filemanager';
        window.open(route_prefix + '?type=' + options.type || 'file', 'FileManager', 'width=900,height=600');
        window.SetUrl = cb;
    };
    var LFMButton = function(context) {
        var ui = $.summernote.ui;
        var button = ui.button({
            contents: '<i class="note-icon-picture"></i> ',
            tooltip: 'Insert image with filemanager',
            click: function() {
                lfm({type: 'image', prefix: '/laravel-filemanager'}, function(lfmItems, path) {
                    lfmItems.forEach(function (lfmItem) {
                        context.invoke('insertImage', lfmItem.url);
                    });
                });
            }
        });
        return button.render();
    };
    $('#summernote').summernote({
        placeholder: 'Nhập tóm tắt truyện (nếu có)',
        height: 300, 
        minHeight: null,
        maxHeight: null,
        focus: true,
        toolbar: [
            ['style', ['style']],
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['color', ['color']],
            ['insert', ['link', 'video', 'table','filebrowser', 'hr']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['undo', ['undo', 'redo']],
            ['codeview', ['codeview']],
            ['popovers', ['lfm']],
        ],
        buttons: {
            lfm: LFMButton
        }
    });
    $('textarea#summernote').css({display: 'block'});
    $('textarea#summernote ~ .note-editor').css({margin: 0,});
    
    //tạo dataTable
    $(function () {
        var table = new DataTable('#example', {
            processing: true,
            serverSide: true,
            ajax: '{{route('admin.stories.chapters.all', ['story'=>$story->id])}}',
            columns: [
                { data: 'index', name: 'index' },
                { data: 'name', name: 'name' },
                { data: 'index_chap', name: 'index_chap' },
                { data: 'action', name: 'action', orderable: false},
            ],
            paging: true,
            lengthChange: true,
            lengthMenu: [[1, 5, 10, 25, 50, -1], [1,5,10, 25, 50, "Tất cả"]],
            pageLength: 5,
            searching: true,
            ordering: true,
            info: true,
            autoWidth: true,
            responsive: true,
            language: {
                "decimal":        "",
                "emptyTable":     "Không có chương nào",
                "info":           "Từ _START_ dến _END_ của _TOTAL_ chương tìm được",
                "infoEmpty":      "Không có chương phù hợp",
                "infoFiltered":   "(trong tổng _MAX_ chương)",
                "infoPostFix":    "",
                "thousands":      ",",
                "lengthMenu":     "Hiển thị _MENU_ chương",
                "loadingRecords": "Loading...",
                "processing":     "",
                "search":         "Tìm kiếm:",
                "zeroRecords":    "Không có chương nào",
                "paginate": {
                    "first":      "Đầu",
                    "last":       "Cuối",
                    "next":       "Tiếp",
                    "previous":   "Trước"
                },
                "aria": {
                    "orderable":  "Order by this column",
                    "orderableReverse": "Reverse order this column"
                }
            },
            scrollX: true,
            // scrollY: 300,
            dom: '<"clear"><"top"Bifrt><"bottom"lp>',
            buttons: [
                { text: 'Load lại', 
                    action: function ( e, dt, node, config ) {
                        dt.ajax.reload();
                    }
                },
                { extend: 'print', text: 'In' },
                { extend: 'copy', text: 'Copy'},
                { extend: 'excel', text: 'Excel' },
                { extend: 'pdf', text: 'PDF' },
                { extend: 'colvis', text: 'Các cột hiển thị' },
            ],
        });
        $('#example_processing').html('<img src="storage/images/loading.gif" width="80" height="80">');
        $('#example_processing').css({padding: 0, margin: 0, width: '80px', height: '80px', 
            translate: '-50% -50%', 'border-radius': '50%', 'z-index': 100});
        setTimeout(function() {
            $('.dark-mode .dropdown-item').css({color: 'black'});
        }, 10);
    });
</script>
<script>
    @if (Session::has('msg'))
        Swal.fire('{{Session::get('msg')}}', "", '{{Session::get('type')}}');
    @endif

    $('#btn-show-detail').click(function (e) { 
        e.preventDefault();
        $('.show-detail').addClass('show');
    });
    $('#btn-close-detail').click(function (e) { 
        e.preventDefault();
        $('.show-detail').removeClass('show');
    });

    //link file manager
    $('#lfm').filemanager('image');
    $('#txtimage').change(function (e) { 
        e.preventDefault();
        let value = $(this).val();
        let host = '{{env('APP_URL')}}';
        $(this).val(value.slice(host.length-1));
    });

    $.validator.addMethod("checkOrder", function(value, element, param){
        return value != '' && Array.isArray(JSON.parse(value)) && JSON.parse(value).length > 0;
    },"Thể loại không được bỏ trống");
    $.validator.setDefaults({
        submitHandler: function (e) {
            var dataForm = {};
            dataForm._token = '{{csrf_token()}}';
            dataForm.author = $('#txtauthor').val();
            dataForm.name = $('#txtnamestory').val();
            dataForm.slug = $('#txtslug').val();
            dataForm.status = $('#slStatus').val();
            dataForm.image = $('#txtimage').val();
            dataForm.description = $('#summernotestory').summernote('code');
            dataForm.categories = JSON.parse($('#txtCategories').val());
            // console.log(dataForm);
            $.ajax({
                type: "PATCH",
                url: 'admin/stories/edit/{{$story->id}}',
                data: dataForm,
                success: function (response) {
                    if(response.msg.type == 'success'){
                        $('#btn-reset-story').click();
                    }
                    Swal.fire(response.msg.msg, "", response.msg.type);
                }
            });
        }
    });
    $('#formDataStory').validate({
        rules: {
            author: {
                required: true,
            },
            categories: {
                required: true,
                checkOrder: true,
            },
            name: {
                required: true,
                remote: {
                    url: '{{route('slugStoriesExist')}}',
                    type: 'get',
                    data: {
                        author: function() {
                            return $( "#txtauthor" ).val();
                        },
                        submit: 'edit',
                        id: {{$story->id}},
                    },
                    dataFilter: function (response) {
                        return response;
                    }
                }
            },
            slug: {
                required: true,
            },
            image: {
                required: true,
            },
            description: {
                required: true,
            },
        },
        messages: {
            author: {
                required: 'Tên tác giả không được bỏ trống',
            },
            categories: {
                required: 'Thể loại không được bỏ trống',
            },
            name: {
                required: 'Tên truyện không được bỏ trống',
                remote: 'Truyện đã tồn tại',
            },
            slug: {
                required: 'Thể loại không được bỏ trống',
            },
            image: {
                required: 'Ảnh bìa không được bỏ trống',
            },
            description: {
                required: 'Mô tả ngắn gọn không được bỏ trống',
            },
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        }
    });
    //Mở Form thêm truyện
    $('.addData').click(function (e) { 
        e.preventDefault();
        $('#check-open-source').prop('disabled', false);
        $('#formDataStory').trigger('reset');
        $('#collapse-source').removeClass('show');
        $('#formDataStory').attr('data-submit', 'add');
        $('#title-model').text('Thông tin truyện cần tạo mới');
        $('#submitForm').text('Thêm mới');
        $('#summernote').summernote('code', '');
        $('#txtID').val('');
        $('#txtCategories').val('');
        $('#holder').html(``);
        openCollapseSelect('true');
        loadCategories();
    });
    $('#btn-edit-story').click(function (e) { 
        e.preventDefault();
        $('.show-view').addClass('d-none');
        $('.edit').removeClass('d-none');
        $('.edit:not(.textaria)').addClass('d-flex');
        $(this).addClass('d-none');
        $('#btn-reset-story').removeClass('d-none');
        $('#btn-submit-story').removeClass('d-none');
    });
    $('#btn-reset-story').click(function (e) { 
        e.preventDefault();
        $('.show-view').removeClass('d-none');
        $('.edit').addClass('d-none');
        $('.edit:not(.textaria)').removeClass('d-flex');
        $('#btn-edit-story').removeClass('d-none');
        $(this).addClass('d-none');
        $('#btn-submit-story').addClass('d-none');
        loadingStory();
    });

    $('#formDataStory').submit(function (e) { 
        e.preventDefault();
        
    });

    function loadingStory() {
        openCollapseSelect();
        $.ajax({
            type: "get",
            url: "/admin/stories/show/{{$story->id}}",
            data: {},
            success: function (response) {
                // console.log(response);
                $('#txtauthor').val(response.author);
                $('#txtnamestory').val(response.name);
                $('#txtslug').val(response.slug);
                $('#slStatus').val(response.status);
                $('#txtimage').val(response.image);
                $('#holder').html(`<img src="${response.image}" style="height: 5rem;" alt="${response.image}">`);
                $('#summernotestory').summernote('code', response.description);
                $('#txtCategories').val(JSON.stringify(response.categories.map((item)=>item.id)));

                $('#lbauthor').html(response.author);
                $('#lbname').html(response.name);
                $('#lbslug').html(response.slug);
                $('#lbstatus').html((response.status==0)?'Hoàn thành':((response.status==1)?'Đang ra':'Tạm dừng'));
                $('#lbimage').html(response.image);
                $('#lbdescription').html(response.description);
                $('#lbcategories').html(response.categories.map((item)=>item.name).join(', '));
                loadCategories();
            }
        });
    }
    loadingStory();

    //tạo editor
    $('#summernotestory').summernote({
        placeholder: 'Nhập tóm tắt truyện (nếu có)',
        height: 300, 
        minHeight: null,
        maxHeight: null,
        focus: true,
        toolbar: [
            ['style', ['style']],
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['color', ['color']],
            ['insert', ['link', 'video', 'table','filebrowser', 'hr']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['undo', ['undo', 'redo']],
            ['codeview', ['codeview']],
            ['popovers', ['lfm']],
        ],
        buttons: {
            lfm: LFMButton
        }
    });
    $('textarea#summernotestory').css({display: 'block'});
    $('textarea#summernotestory ~ .note-editor').css({margin: 0,});

    function loadingUsers(){
        $.ajax({
            type: "get",
            url: "{{route('admin.loadUser')}}",
            data: {
                search: $('#txtsearch-user').val(),
                list: listUs(),
            },
            success: function (response) {
                $('#sl-list-user').html('');
                response.forEach((user, index)=>{
                    $('#sl-list-user').append(`<option value="${user.id}" class="p-2">${user.email+' - '+user.fullname}</option>`);
                });
            }
        });
    }
    function loadingUsersSelected(){
        $.ajax({
            type: "get",
            url: "{{route('admin.loadUserSelected')}}",
            data: {
                list: listUs(),
            },
            success: function (response) {
                $('#list-user-selected').html('');
                response.forEach((user, index)=>{
                    $('#list-user-selected').append(`<option value="${user.id}" class="p-2">${user.email+' - '+user.fullname}</option>`);
                });
            }
        });
    }
    $('#btn-add-manager').click(function (e) { 
        e.preventDefault();
        $('#txtsearch-user').val('');
        $('#txtlist-selected').val('[]');
        loadingUsers();
        loadingUsersSelected();
    });
    $('#txtsearch-user').change(function (e) { 
        e.preventDefault();
        loadingUsers();
    });
    $('#txtsearch-user').keyup(function (e) { 
        e.preventDefault();
        loadingUsers();
    });
    $('#add-user').click(function (e) { 
        e.preventDefault();
        let list_selected = $('#sl-list-user').val();
        let list = listUs();
        list = list.concat(list_selected);
        $('#txtlist-selected').val(JSON.stringify(list));
        loadingUsersSelected();
        // console.log(list_selected,list);
    });

    function listUs(){
        let list = [];
        if(!Array.isArray($('#txtlist-selected').val())){
            list = JSON.parse($('#txtlist-selected').val());
            if(!Array.isArray(list)) list = [];
        }
        return list;
    }

    //nút đóng mở collapse
    $('#selectCategories .icon').click(function (e) { 
        e.preventDefault();
        let open = $('#selectCategories .icon').attr('data-open');
        openCollapseSelect(open);
    });
    
    loadCategories();
    //load các thể loại
    function loadCategories(){
        var list_categories = $('#txtCategories').val();
        if(list_categories == ''){
            list_categories = [];
        }
        else{
            list_categories = JSON.parse(list_categories);
            if(!Array.isArray(list_categories)){
                list_categories = [];
            }
        }
        $('#txtCategories').val(JSON.stringify(list_categories));
        $.ajax({
            type: "get",
            url: "/admin/categories/all",
            data: {},
            success: function (response) {
                let htmlSelect = '', htmlAll = '';
                response.data.forEach((item, index) => {
                    if(list_categories.includes(item.id)){
                        htmlSelect += `<button type="button" class="btn btn-primary btn-category-item m-1" title="click để bỏ chọn" data-id="${item.id}">${item.name}</button>`;
                    }else{
                        htmlAll += `<button type="button" class="btn btn-primary btn-category-item m-1" title="click để thêm" data-id="${item.id}">${item.name}</button>`;
                    }
                });
                if(htmlSelect == '') htmlSelect = '<span>Chưa chọn thể loại nào</span>';
                if(htmlAll == '') htmlAll = '<span>Đã hết thể loại có thể chọn</span>';
                $('#selectCategories .card-header').html(htmlSelect);
                $('#collapseCategories .card-body').html(htmlAll);
                const allItemCategories = document.querySelectorAll('.btn-category-item');
                allItemCategories.forEach((itemCate)=>{
                    itemCate.addEventListener('click', (e)=>{
                        let list_item_selected = JSON.parse($('#txtCategories').val());
                        let id_selected = Number(itemCate.getAttribute('data-id'));
                        if(list_item_selected.includes(id_selected)){
                            list_item_selected.splice(list_item_selected.indexOf(id_selected), 1);
                        }else{
                            list_item_selected.push(id_selected);
                        }
                        $('#txtCategories').val(JSON.stringify(list_item_selected));
                        loadCategories();
                    });
                });
            }
        });
    }
    //collapse all categories
    function openCollapseSelect(open = 'false'){
        $('#collapseCategories').removeClass('active');
        if(open == 'false'){
            $('#selectCategories .icon').attr('data-open', 'true');
            $('#collapseCategories').addClass('active');
            $('#selectCategories .icon').html('<i class="fas fa-chevron-up"></i>');
        }
        else{
            $('#selectCategories .icon').attr('data-open', 'false');
            $('#selectCategories .icon').html('<i class="fas fa-chevron-down"></i>');
        }
    }
</script>
@endsection