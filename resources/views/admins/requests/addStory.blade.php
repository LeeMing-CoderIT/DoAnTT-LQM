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
                        <h1>Danh sách yêu cầu thêm truyện</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('admin.home')}}">Trang chủ</a></li>
                            <li class="breadcrumb-item active">Danh sách yêu cầu thêm truyện</li>
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
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form method="POST" id="formDataStory" data-submit="">
                        <div class="card-body">
                            <div class="form-group">
                                <input type="hidden" class="form-control" id="txtID" name="id" value="" readonly>
                                <input type="hidden" class="form-control" id="txtIDuser" name="id_user" value="" readonly>
                            </div>
                            <div class="form-group">
                                <label>Nguồn truyện (nếu có):</label>
                                <select id="select-source" class="form-control" disabled>
                                    <option value="">--Chọn nguồn truyện--</option>
                                    <option value="truyenfull">Truyện Full (truyenfull.vn)</option>
                                </select>
                            </div>
                            <div class="form-group collapse" id="collapse-source">
                                <label>Link nguồn truyện:</label>
                                <input type="text" name="source" id="txtsource" class="form-control" readonly placeholder="Nguồn truyện: truyenfull.vn">
                            </div>
                            <div class="form-group">
                                <label>Tên tác giả:</label>
                                <input type="text" id="txtauthor" name="author" class="form-control" placeholder="Nhập tên tác giả">
                            </div>
                            <div class="form-group">
                                <label>Thể loại:</label>
                                <div class="form-control h-auto position-relative p-1 border-0 d-flex justify-content-center align-items-center">
                                    <input type="text" class="form-control position-absolute top-0 left-0 h-100" id="txtCategories" name="categories" value="">
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
                                <label>Tên truyện:</label>
                                <input type="text" id="txtname" name="name" class="form-control" placeholder="Nhập tên truyện">
                            </div>
                            <div class="form-group">
                                <label>Đường dẫn slug:</label>
                                <input type="text" id="txtslug" name="slug" readonly class="form-control" placeholder="Slug của truyện">
                            </div>
                            <div class="form-group">
                                <label>Ảnh đại diện:</label>
                                <div class="d-flex align-items-center p-0">
                                    <div class="input-group-prepend position-absolute top-0 left-0">
                                        <button type="button" id="lfm" data-input="txtimage" data-preview="holder" class="btn btn-primary" style="scale: 0.9">
                                            <i class="fas fa-image"></i>
                                        </button>
                                    </div>
                                    <!-- /btn-group -->
                                    <input id="txtimage" class="form-control" style="padding-left: 45px;" type="text" name="image" readonly>
                                </div>
                                <div id="holder" class="row d-flex justify-content-center" style="max-height:120px;"></div>
                            </div>
                            <div class="form-group">
                                <label>Trạng thái:</label>
                                <select id="slStatus" name="status" class="form-control">
                                    <option value="0">Hoàn thoành</option>
                                    <option value="1">Đang ra</option>
                                    <option value="2">Tạm dừng</option>
                                </select>
                            </div>
                            <div class="form-group m-0 p-0">
                                <label>Tóm tắt:</label>
                                <div class="position-relative" style="padding: 1px;">
                                    <textarea id="summernote" name="description" class="form-control position-absolute h-100" style="left: 0; top: 0;"></textarea>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary" form="formDataStory" id="submitForm"></button>
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
                                            <th style="width: 20%;">Người yêu cầu</th>
                                            <th style="width: 20%;">Nguồn truyện</th>
                                            <th style="width: 20%;">Đường dẫn</th>
                                            <th style="width: 10%;">Tùy biến</th>
                                        </tr>
                                    </thead>
                                <tbody>

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Người yêu cầu</th>
                                        <th>Nguồn truyện</th>
                                        <th>Đường dẫn</th>
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
    var successSource = false;
    $.validator.addMethod("checkSource", function(value, element, param){
        return successSource;
    },"Đường dẫn nguồn không hợp lệ.");
    $.validator.addMethod("checkOrder", function(value, element, param){
        return value != '' && Array.isArray(JSON.parse(value)) && JSON.parse(value).length > 0;
    },"Thể loại không được bỏ trống");
    $.validator.addMethod("checkSlug", function(value, element, element_id){
        return value == renderToSlug($(element_id).val());
    },"Đường dẫn slug không hợp lệ");
    $.validator.setDefaults({
        submitHandler: function (e) {
            var dataForm = {};
            dataForm._token = '{{csrf_token()}}';
            dataForm.author = $('#txtauthor').val();
            dataForm.name = $('#txtname').val();
            dataForm.slug = $('#txtslug').val();
            dataForm.status = $('#slStatus').val();
            dataForm.image = $('#txtimage').val();
            dataForm.description = $('#summernote').summernote('code');
            dataForm.categories = JSON.parse($('#txtCategories').val());
            dataForm.source = {};
            dataForm.source.link = $('#txtsource').val();
            dataForm.source.source = $('#select-source').val();
            if($('#txtIDuser').val()){
                dataForm.user = Number($('#txtIDuser').val());
            }
            $.ajax({
                type: "POST",
                url: `admin/stories/add`,
                data: dataForm,
                success: function (response) {
                    // console.log(response);
                    if(response.msg.type == 'success'){
                        updateStatus($("#txtID").val(),$('#txtslug').val(),1);
                    }else{
                        Swal.fire(response.msg.msg, "", response.msg.type);
                    }
                }
            });
        }
    });
    //Cập nhật trạng thái
    function updateStatus(id, next, status){
        $.ajax({
            type: "PATCH",
            url: `admin/requests/editAddStory/${id}`,
            data: {
                _token: '{{csrf_token()}}',
                next: next,
                status: status,
            },
            success: function (response) {
                console.log(response);
                if(response.msg.type == 'success'){
                    $('#modal-xl').modal('hide');
                    var oTable = $('#example').dataTable();
                    oTable.fnDraw(false);
                }
                Swal.fire(response.msg.msg, "", response.msg.type);
            }
        });
    }

    $('#formDataStory').validate({
        rules: {
            source:{
                checkSource: true,
            },
            author: {
                required: true,
            },
            categories: {
                required: true,
                checkOrder: true,
            },
            name: {
                required: true,
            },
            slug: {
                required: true,
                checkSlug: '#txtname',
                remote: {
                    url: '{{route('slugStoriesExist')}}',
                    type: 'get',
                    dataFilter: function (response) {
                        return ($('#formDataStory').attr('data-submit')=='edit')?true:response;
                    }
                }
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
            },
            slug: {
                required: 'Thể loại không được bỏ trống',
                remote: 'Đường dẫn đã tồn tại',
            },
            image: {
                required: 'Hình ảnh đại diện không được bỏ trống',
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

    //Thực thi yêu cầu thêm truyện
    function enforcement(user_id, id) {
        $('#formDataStory').trigger('reset');
        $('#formDataStory').attr('data-submit', 'edit');
        $('#title-model').text('Thông tin truyện cần thêm');
        $('#submitForm').text('Thêm truyện');
        openCollapseSelect();
        $.ajax({
            type: "get",
            url: "/admin/requests/showAddStory/"+id,
            data: {},
            success: function (response) {
                if(response.source){
                    $('#select-source').val(response.source);
                    $('#txtsource').val(response.link);
                    $('#collapse-source').addClass('show');
                    $("#txtID").val(id);
                    $("#txtIDuser").val(user_id);
                    loadingStory();
                }
            }
        });
    }

    //Hủy yêu cầu thêm truyện
    function cancel(id) {
        Swal.fire({
            title: "Bạn có chắc chắn muốn hủy yêu cầu không?",
            showCancelButton: true,
            confirmButtonText: "Xác nhận",
            cancelButtonText: "Hủy",
            icon: "question",
        }).then((result) => {
            if (result.isConfirmed) {
                updateStatus(id,null,2);
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
                    url: `admin/requests/deleteAddStory/${id}`,
                    data: {
                        _token: '{{csrf_token()}}',
                    },
                    success: function (response) {
                        if(response.success){
                            var oTable = $('#example').dataTable();
                            oTable.fnDraw(false);
                        }
                        Swal.fire(response.msg.msg, "", response.msg.type);
                    }
                });
            }
        });
    }
    //submit Form
    $('#formDataStory').submit(function (e) { 
        e.preventDefault();
    });

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

    //nút đóng mở collapse
    $('#selectCategories .icon').click(function (e) { 
        e.preventDefault();
        let open = $('#selectCategories .icon').attr('data-open');
        openCollapseSelect(open);
    });

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

    
    //link file manager
    $('#lfm').filemanager('image');
    //tạo dataTable
    $(function () {
        var table = new DataTable('#example', {
            processing: true,
            serverSide: true,
            ajax: '{{route('admin.requests.allAddStory')}}',
            columns: [
                { data: 'index', name: 'index' },
                { data: 'user', name: 'user' },
                { data: 'source', name: 'source' },
                { data: 'link', name: 'link' },
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
                "emptyTable":     "Không có yêu cầu nào",
                "info":           "Từ _START_ dến _END_ của _TOTAL_ yêu cầu tìm được",
                "infoEmpty":      "Không có yêu cầu phù hợp",
                "infoFiltered":   "(trong tổng _MAX_ yêu cầu)",
                "infoPostFix":    "",
                "thousands":      ",",
                "lengthMenu":     "Hiển thị _MENU_ yêu cầu",
                "loadingRecords": "Loading...",
                "processing":     "",
                "search":         "Tìm kiếm:",
                "zeroRecords":    "Không có yêu cầu nào",
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
    function loadingStory(bug = false){
        let txtSource = $('#txtsource').val();
        let selSource = $('#select-source').val();
        // console.log({source: selSource, type: 'story', link: txtSource, bug: bug});
        if(txtSource != '' && selSource != ''){
            $.ajax({
                type: "get",
                url: `/crawler`,
                data: {source: selSource, type: 'story', link: txtSource, bug: bug},
                success: function (response) {
                    // console.log(response);
                    if(response){
                        if(response.error){
                            let newwin = window.open(response.error, '_blank');
                            loadingStory(true);
                            setTimeout(() => {
                                newwin.close();
                            }, 1000);
                        }else{
                            successSource = true;
                            $('#txtauthor').val(response.author);
                            $('#txtname').val(response.name);
                            $('#txtslug').val(renderToSlug($('#txtname').val()));
                            // $('#txtslug').val(response.slug);
                            let status = 1;
                            if(response.status && response.status == 'Full'){
                                status = 0;
                            }
                            $('#slStatus').val(status);
                            $('#txtimage').val(response.image);
                            $('#holder').html(`<img src="${response.image}" style="height: 5rem;" alt="${response.image}">`);
                            $('#summernote').summernote('code', response.description);
                            $('#txtCategories').val(JSON.stringify(response.categories));
                            loadCategories();
                        }
                    }else{
                        Swal.fire('Không tìm thấy truyện. Kiểm tra lại truyện từ nguồn!', "Chú ý", 'error');
                    }
                }
            });
        }
    }
</script>
@endsection