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

        <!-- Main content -->
        {{-- <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <label class="p-2" style="font-size: 2rem;">Thao tác thủ công:(Nguồn: '{{$story->source['link']??null}}')</label>
                            <div class="card-body d-flex">
                                <div class="form-group col-4">
                                    <label>Tổng số trong nguồn:</label>
                                    <input type="number" id="numPages" class="form-control" placeholder="Tổng số trong nguồn" value="1">
                                </div>
                                <div class="form-group col-4">
                                    <label>Tổng số chương:</label>
                                    <input type="number" id="numChapters" class="form-control" placeholder="Tổng số chương" value="1">
                                </div>
                                <div class="form-group col-4">
                                    <label>Số chương chưa cập nhật:</label>
                                    <input type="number" id="numUpdateChapter" readonly class="form-control" placeholder="Số chương chưa cập nhật" value="1">
                                </div>
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
        </section> --}}
        <!-- /.content -->
    
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
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <table id="example" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Tên chương</th>
                                            <th>Số chương</th>
                                            <th>Tùy biến</th>
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
                link: linkSource, page: nowPage, first: (pagesCrawler==1)?true:false
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
                    console.log(response);
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
                                            link: linkSource, page: nowPage, first: (pagesCrawler==1)?true:false
                                        });
                                    }
                                }
                            });
                        }
                        if(lastSourceChapter == '' && nextPage === false){
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
                                link: linkSource, page: nowPage, first: (pagesCrawler==1)?true:false
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
                    // console.log(response);
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
            autoWidth: false,
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
@endsection