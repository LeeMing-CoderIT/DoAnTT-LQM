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
                        <h1>Danh sách thể loại</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('admin.home')}}">Trang chủ</a></li>
                            <li class="breadcrumb-item active">Danh sách thể loại</li>
                        </ol>
                    </div>
                </div>
                <div class="row d-flex justify-content-end">
                    <button type="button" class="btn btn-primary addData" data-toggle="modal" data-target="#modal-xl">
                        Thêm thể loại
                    </button>
                </div>
            </div><!-- /.container-fluid -->
        </section>
    
        <div class="modal fade" id="modal-xl">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="card-header bg-blue">
                        <h3 class="card-title" id="title-model"></h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form method="POST" id="formDataCategory" data-submit="">
                        <input type="hidden" name="txtID" id="txtID" value="">
                        <div class="card-body">
                            <div class="form-group">
                                <label>Tên thể loại:</label>
                                <input type="text" id="txtname" name="name" class="form-control" placeholder="Nhập tên thể loại">
                            </div>
                            <div class="form-group">
                                <label>Đường dẫn slug:</label>
                                <input type="text" id="txtslug" name="slug" readonly class="form-control" placeholder="Slug của thể loại">
                            </div>
                            <div class="form-group m-0 p-0">
                                <label>Mô tả:</label>
                                <div class="position-relative" style="padding: 1px;">
                                    <textarea id="summernote" name="description" class="form-control position-absolute h-100" style="left: 0; top: 0;"></textarea>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary" form="formDataCategory" id="submitForm"></button>
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
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <table id="example" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%;">#</th>
                                            <th style="width: 50%;">Tên thể loại</th>
                                            <th style="width: 10%;">Số lượng truyện</th>
                                            <th style="width: 10%;">Tùy biến</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Tên thể loại</th>
                                            <th>Số lượng truyện</th>
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
    $.validator.addMethod("checkSlug", function(value, element, element_id){
        return value == renderToSlug($(element_id).val());
    },"Đường dẫn slug không hợp lệ");
    $.validator.setDefaults({
        submitHandler: function (e) {
            var dataForm = {};
            dataForm._token = '{{csrf_token()}}';
            dataForm.name = $('#txtname').val();
            dataForm.slug = $('#txtslug').val();
            dataForm.description = $('#summernote').summernote('code');
            let idEdit = $('#txtID').val();
            let method = $('#formDataCategory').attr('data-submit');
            if(idEdit != "" && method == 'edit'){
                $.ajax({
                    type: "PATCH",
                    url: `/admin/categories/edit/${idEdit}`,
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
            else{
                if(method == 'add'){
                    $.ajax({
                        type: "POST",
                        url: `/admin/categories/add`,
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
            }
        }
    });
    $('#formDataCategory').submit(function (e) { 
        e.preventDefault();
    });
    $('#formDataCategory').validate({
        rules: {
            name: {
                required: true,
            },
            slug: {
                required: true,
                checkSlug: '#txtname',
                remote: {
                    url: '{{route('slugCategoriesExist')}}',
                    type: 'get',
                    dataFilter: function (response) {
                        return ($('#formDataCategory').attr('data-submit')=='edit')?true:response;
                    }
                }
            },
            description: {
                required: true,
            },
        },
        messages: {
            name: {
                required: 'Tên thể loại không được bỏ trống.',
            },
            slug: {
                required: 'Đường dẫn không được bỏ trống.',
                remote: 'Đường dẫn đã tồn tại',
            },
            description: {
                required: 'Mô tả ngắn gọn, không được bỏ trống.',
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
        $('#formDataCategory').trigger('reset');
        $('#formDataCategory').attr('data-submit', 'add');
        $('#title-model').text('Thông tin thể loại cần tạo mới');
        $('#submitForm').text('Thêm mới');
        $('#txtID').val('');
        $('#txtname').val('');
        $('#txtslug').val('');
        $('#summernote').summernote('code', '');
    });

    //Mở Form cập nhật truyện
    function editData(id) {
        $('#formDataCategory').trigger('reset');
        $('#formDataCategory').attr('data-submit', 'edit');
        $('#title-model').text('Thông tin thể loại cần cập nhật');
        $('#submitForm').text('Cập nhật');
        $.ajax({
            type: "get",
            url: `/admin/categories/show/${id}`,
            data: {
                show: 'chapter'
            },
            success: function (response) {
                $('#txtID').val(response.id);
                $('#txtname').val(response.name);
                $('#txtslug').val(response.slug);
                $('#summernote').summernote('code', response.description);
            }
        });
    }

    //Xóa truyện
    function deleteData(id){
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
                    url: `/admin/categories/delete/${id}`,
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
            ajax: '{{route('admin.categories.all')}}',
            columns: [
                { data: 'index', name: 'index' },
                { data: 'name', name: 'name' },
                { data: 'stories', name: 'stories' },
                { data: 'action', name: 'action', orderable: false},
            ],
            // columnDefs: [{ width: '10%'},null,{ width: '20%'},{ width: '30%'}],
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
                "emptyTable":     "Không có thể loại nào",
                "info":           "Từ _START_ dến _END_ của _TOTAL_ thể loại tìm được",
                "infoEmpty":      "Không có thể loại phù hợp",
                "infoFiltered":   "(trong tổng _MAX_ thể loại)",
                "infoPostFix":    "",
                "thousands":      ",",
                "lengthMenu":     "Hiển thị _MENU_ thể loại",
                "loadingRecords": "Loading...",
                "processing":     "",
                "search":         "Tìm kiếm:",
                "zeroRecords":    "Không có thể loại nào",
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
        $('#example thead th').css({width: '50px'});
        setTimeout(function() {
            $('.dark-mode .dropdown-item').css({color: 'black'});
        }, 10);
    });

    //hàm tạo slug
    function renderToSlug(text){
        //Đổi chữ hoa thành chữ thường
        var slug = text.toLowerCase();

        //Đổi ký tự có dấu thành không dấu
        slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
        slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
        slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
        slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
        slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
        slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
        slug = slug.replace(/đ/gi, 'd');
        //Xóa các ký tự đặt biệt
        slug = slug.replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '');
        //Đổi khoảng trắng thành ký tự gạch ngang
        slug = slug.replace(/ /gi, "-");
        //Đổi nhiều ký tự gạch ngang liên tiếp thành 1 ký tự gạch ngang
        //Phòng trường hợp người nhập vào quá nhiều ký tự trắng
        slug = slug.replace(/\-\-\-\-\-/gi, '-');
        slug = slug.replace(/\-\-\-\-/gi, '-');
        slug = slug.replace(/\-\-\-/gi, '-');
        slug = slug.replace(/\-\-/gi, '-');
        //Xóa các ký tự gạch ngang ở đầu và cuối
        slug = '@' + slug + '@';
        slug = slug.replace(/\@\-|\-\@|\@/gi, '');
        //In slug ra textbox có id “slug”
        return slug;
    }
    //thao tác slug
    $('#txtname').change(function (e) { 
        e.preventDefault();
        $('#txtslug').val(renderToSlug($('#txtname').val()));
    });
    $('#txtname').keyup(function (e) { 
        e.preventDefault();
        $('#txtslug').val(renderToSlug($('#txtname').val()));
    });
</script>
@endsection