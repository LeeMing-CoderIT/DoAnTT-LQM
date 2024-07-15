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
                        <h1>Phân quyền người dùng</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('admin.home')}}">Trang chủ</a></li>
                            <li class="breadcrumb-item active">Phân quyền người dùng</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
    
        <div class="modal fade" id="modal-xl">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="card-header bg-blue">
                        <h3 class="card-title" id="title-model"></h3>
                    </div>
                    <form method="POST" id="formDataCategory" data-submit="">
                        <input type="hidden" name="txtID" id="txtID" value="">
                        <div class="card-body">
                            <div class="form-group">
                                <label>Tên thể loại:</label>
                                <select type="text" id="slmanager" class="form-control">
                                    <option value="0">Người dùng</option>
                                    <option value="2">Biên tập viên</option>
                                </select>
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
                                            <th style="width: 25%;">Email</th>
                                            <th style="width: 20%;">Tên người dùng</th>
                                            <th style="width: 12%;">Quyền hiện tại</th>
                                            <th style="width: 5%;">Tùy biến</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th style="width: 5%;">#</th>
                                            <th style="width: 25%;">Email</th>
                                            <th style="width: 20%;">Tên người dùng</th>
                                            <th style="width: 12%;">Quyền hiện tại</th>
                                            <th style="width: 5%;">Tùy biến</th>
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
    $('#formDataCategory').submit(function (e) { 
        e.preventDefault();
        var dataForm = {};
        dataForm._token = '{{csrf_token()}}';
        dataForm.root = $('#slmanager').val();
        let idEdit = $('#txtID').val();
        $.ajax({
            type: "PATCH",
            url: `/admin/users/change-decentralization/${idEdit}`,
            data: dataForm,
            success: function (response) {
                // console.log(response);
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
    });

    //Mở Form cấp quyền
    function decentralization(id) {
        $('#formDataCategory').trigger('reset');
        $('#formDataCategory').attr('data-submit', 'edit');
        $('#title-model').text('Cấp quyền cho người dùng');
        $('#submitForm').text('Xác nhận');
        $.ajax({
            type: "get",
            url: `/admin/users/show/${id}`,
            data: {},
            success: function (response) {
                $('#txtID').val(response.id);
                $('#slmanager').val(response.root);
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
            ajax: '{{route('admin.users.decentralization')}}',
            columns: [
                { data: 'index', name: 'index' },
                { data: 'email', name: 'email' },
                { data: 'fullname', name: 'fullname' },
                { data: 'show', name: 'show', orderable: false },
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
                "emptyTable":     "Không có người dùng nào",
                "info":           "Từ _START_ dến _END_ của _TOTAL_ người dùng tìm được",
                "infoEmpty":      "Không có người dùng phù hợp",
                "infoFiltered":   "(trong tổng _MAX_ người dùng)",
                "infoPostFix":    "",
                "thousands":      ",",
                "lengthMenu":     "Hiển thị _MENU_ người dùng",
                "loadingRecords": "Loading...",
                "processing":     "",
                "search":         "Tìm kiếm:",
                "zeroRecords":    "Không có người dùng nào",
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
                // { extend: 'print', text: 'In' },
                // { extend: 'copy', text: 'Copy'},
                // { extend: 'excel', text: 'Excel' },
                // { extend: 'pdf', text: 'PDF' },
                // { extend: 'colvis', text: 'Các cột hiển thị' },
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
</script>
@endsection