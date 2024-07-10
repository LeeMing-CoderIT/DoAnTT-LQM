@extends('users.layout')

@section('css')
<link rel="stylesheet" href="assets/admins/plugins/sweetalert2/sweetalert2.min.css">
<link rel="stylesheet" href="assets/admins/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="assets/admins/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="assets/admins/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
<link rel="stylesheet" href="assets/admins/plugins/sweetalert2/sweetalert2.min.css">
    <style>
        form button.position-absolute{
            top: -5px; right: -5px;
        }
        .list-group li{
            cursor: pointer;
        }
        .list-group li:hover{
            background: rgb(192, 192, 192);
        }
        .list-group li.active{
            background: rgb(151, 151, 151); border: none;
        }
        .form-item{
            scale: 0; height: 0; transition: all 0.5s linear; background: white;
            margin: 0;border-radius: 10px;
        }
        .form-item.active{
            scale: 1; height: auto; padding: 20px; 
        }
        .page-item{
            cursor: pointer;
        }
    </style>
@endsection

@section('content')
<main>
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-4">
                <ul class="list-group">
                    <li class="list-group-item" data-form="form-info">Thông tin cá nhân</li>
                    <li class="list-group-item" data-form="form-change-pass">Đổi mật khẩu</li>
                    <li class="list-group-item" data-form="form-request-story">Yêu cầu truyện</li>
                    <li class="list-group-item" data-form="form-manager-story">Tủ truyện</li>
                    <li class="list-group-item" data-form="form-all-request">Lịch sử yêu cầu truyện</li>
                    <li class="list-group-item" data-form="form-all-history">Lịch sử nghe truyện</li>
                    <li class="list-group-item" data-form="form-settings">Cài đặt</li>
                </ul>
            </div>

            <div class="col-12 col-lg-8 mt-3 mt-lg-0">
                <form action="{{route('postInfoUser')}}" method="post" enctype="multipart/form-data" class="position-relative form-item" id="form-info">
                    <button class="btn btn-primary position-absolute" id="btn-open-info" type="button"><i class="fa-solid fa-pen-to-square"></i></button>
                    @csrf
                    <div class="mb-3">
                        <label class="form-label"><strong>Email:</strong> {{Auth::user()->email}}</label>
                    </div>
                    <div class="mb-3">
                        <label class="form-label edit"><strong>Tên đại diện:</strong> {{Auth::user()->fullname}}</label>
                        <input class="form-control d-none" name="fullname" type="text" value="{{Auth::user()->fullname}}" title="Tên đại diện" placeholder="Nhập tên đại diện">
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><strong>Ảnh đại diện:</strong>                            
                            <img src="storage/images/users/{{Auth::user()->avatar}}" alt="<trống>" data-old="{{Auth::user()->avatar}}" style="width: 50px; height: 50px; border-radius: 50%;">
                        </label>
                        <input class="form-control d-none" name="avatar" type="file" id="info-avatar" value="{{Auth::user()->avatar}}" title="Ảnh đại diện" placeholder="Chọn ảnh đại diện">
                    </div>
                    <div class="mb-3">
                        <label class="form-label edit"><strong>Số điện thoại:</strong> {!!Auth::user()->phone ?? '&lt;trống&gt;'!!}</label>
                        <input class="form-control d-none" name="phone" type="text" value="{{Auth::user()->phone}}" title="Số điện thoại" placeholder="Nhập số điện thoại">
                    </div>
                    <button class="btn btn-primary d-none" id="btn-edit-info" type="submit">Xác nhận</button>
                    <button class="btn btn-primary d-none" id="btn-reset-info" type="button">Hủy</button>
                </form>
                <form action="{{route('postChangePass')}}" method="post" enctype="multipart/form-data" class="position-relative form-item" id="form-change-pass">
                    @csrf
                    <input type="hidden" name="form" value="form-change-pass">
                    <div class="mb-3">
                        <label class="form-label"><strong>Email:</strong> {{Auth::user()->email}}</label>
                    </div>
                    <div class="mb-3">
                        <input class="form-control pass" name="password" type="password" value="{{old('password')}}" title="Mật khẩu hiện tại" placeholder="Nhập mật khẩu hiện tại">
                    </div>
                    @error('password')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <div class="mb-3">
                        <input class="form-control pass" name="new_password" type="password" value="{{old('new_password')}}" title="Mật khẩu mới" placeholder="Nhập mật khẩu mới">
                    </div>
                    @error('new_password')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <div class="mb-3">
                        <input class="form-control pass" name="re_password" type="password" value="{{old('re_password')}}" title="Nhập lại mật khẩu mới" placeholder="Nhập lại mật khẩu mới">
                    </div>
                    @error('re_password')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <div class="form-check form-switch mb-2">
                        <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault">
                        <label class="form-check-label" for="flexSwitchCheckDefault">Hiển thị mật khẩu</label>
                    </div>
                    <button class="btn btn-primary" type="submit">Xác nhận</button>
                </form>
                <form action="{{route('postRequestStory')}}" method="post" enctype="multipart/form-data" class="position-relative form-item" id="form-request-story">
                    @csrf
                    <input type="hidden" name="form" value="form-request-story">
                    <div class="mb-3">
                        <label class="form-label"><strong>Email:</strong> {{Auth::user()->email}}</label>
                    </div>
                    <div class="mb-3">
                        <select class="form-select" name="source" title="Nguồn truyện">
                            <option value="">--Chọn nguồn truyện--</option>
                            <option value="truyenfull">Truyện Full (https://truyenfull.vn)</option>
                        </select>
                    </div>
                    @error('source')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <div class="mb-3">
                        <input class="form-control" name="link" type="text" value="{{old('link')??''}}" title="Đường dẫn nguồn truyện" placeholder="Nhập đường dẫn nguồn truyện">
                    </div>
                    @error('link')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <button class="btn btn-primary" type="submit">Xác nhận</button>
                </form>
                <div class="position-relative form-item" id="form-manager-story" style="max-height: 1000px; overflow-y: auto;">
                    <table id="example-all-manager" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tên truyện</th>
                                <th>Số lượng chương</th>
                                <th>Thể loại</th>
                                <th>Trạng thái</th>
                                <th>Tùy biến</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Tên truyện</th>
                                <th>Số lượng chương</th>
                                <th>Thể loại</th>
                                <th>Trạng thái</th>
                                <th>Tùy biến</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="position-relative form-item" id="form-all-request" style="max-height: 1000px; overflow-y: auto;">
                    <table id="example-all-request" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nguồn</th>
                                <th>Trạng thái</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Nguồn</th>
                                <th>Trạng thái</th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="position-relative form-item" id="form-all-history" style="max-height: 1000px; overflow-y: auto;">
                    <table id="example-all-history" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tên truyện</th>
                                <th>Chương đang nghe</th>
                                <th>Đoạn đang nghe</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Tên truyện</th>
                                <th>Chương đang nghe</th>
                                <th>Đoạn đang nghe</th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <form action="{{route('postInfoUserSetting')}}" method="post" enctype="multipart/form-data" class="position-relative form-item" id="form-settings">
                    <button class="btn btn-primary position-absolute" id="btn-open-settings" type="button"><i class="fa-solid fa-pen-to-square"></i></button>
                    @csrf
                    <div class="mb-3">
                        <label class="form-label"><strong>Email:</strong> {{Auth::user()->email}}</label>
                    </div>
                    <div class="mb-3">
                        <label class="form-label edit"><strong>Nền giao diện:</strong> {{Auth::user()->settings()->background==1?'Tối':'Sáng'}}</label>
                        <select class="form-control d-none" id="background" name="background" title="Nền giao diện" data-value="{{Auth::user()->settings()->background}}">
                            <option value="1" {{Auth::user()->settings()->background==1?'selected':''}}>Tối</option>
                            <option value="0" {{Auth::user()->settings()->background==0?'selected':''}}>Sáng</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label edit"><strong>Ngôn ngữ:</strong> {{$lang['country']}}</label>
                        <select class="form-control d-none" id="language" name="language" title="Ngôn ngữ" data-value="{{Auth::user()->settings()->language}}">
                            @foreach ($languages as $language)
                            <option value="{{$language['language']}}" {{Auth::user()->settings()->background==$language['language']?'selected':''}}>{{$language['country']}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label edit"><strong>Tốc độ đọc:</strong> {{Auth::user()->settings()->speech}}</label>
                        <select class="form-control d-none" id="speech" name="speech" title="Tốc độ đọc" data-value="{{Auth::user()->settings()->speech}}">
                            <option value="0.5" {{Auth::user()->settings()->speech==0.5?'selected':''}}>0.5</option>
                            <option value="0.75" {{Auth::user()->settings()->speech==0.75?'selected':''}}>0.75</option>
                            <option value="1" {{Auth::user()->settings()->speech==1?'selected':''}}>1</option>
                            <option value="1.25" {{Auth::user()->settings()->speech==1.25?'selected':''}}>1.25</option>
                            <option value="1.5" {{Auth::user()->settings()->speech==1.5?'selected':''}}>1.5</option>
                            <option value="1.75" {{Auth::user()->settings()->speech==1.75?'selected':''}}>1.75</option>
                            <option value="2" {{Auth::user()->settings()->speech==2?'selected':''}}>2</option>
                        </select>
                    </div>
                    <button class="btn btn-primary d-none" id="btn-edit-settings" type="submit">Xác nhận</button>
                    <button class="btn btn-primary d-none" id="btn-reset-settings" type="button">Hủy</button>
                </form>
            </div>
        </div>
    </div>
</main>
@endsection
@section('js')
<script src="assets/admins/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="assets/admins/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="assets/admins/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="assets/admins/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="assets/admins/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="assets/admins/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="assets/admins/plugins/sweetalert2/sweetalert2.all.min.js"></script>
<script>
    $('#form-request-story select').val('{{old('source')??''}}');

    $('#btn-open-info').click(function (e) { 
        e.preventDefault();
        $('#form-info .form-label.edit').addClass('d-none');
        $('#form-info .form-control').removeClass('d-none');
        $('#btn-open-info').addClass('d-none');
        $('#btn-edit-info').removeClass('d-none');
        $('#btn-reset-info').removeClass('d-none');
    });
    $('#btn-reset-info').click(function (e) { 
        e.preventDefault();
        $('#form-info .form-label.edit').removeClass('d-none');
        $('#form-info .form-control').addClass('d-none');
        $('#btn-open-info').removeClass('d-none');
        $('#btn-edit-info').addClass('d-none');
        $('#btn-reset-info').addClass('d-none');
        $('#form-info img').attr('src', 'storage/images/users/'+$('#form-info img').attr('data-old'));
    });
    $('#info-avatar').change(function (e) { 
        e.preventDefault();
        if($(this).val()){
            var reader  = new FileReader();
            reader.onloadend = function () {
                $('#form-info img').attr('src', reader.result);
            }
            if (e.target.files[0]) {
                reader.readAsDataURL(e.target.files[0]);
            }
        }
    });
    $('#btn-open-settings').click(function (e) { 
        e.preventDefault();
        $('#form-settings .form-label.edit').addClass('d-none');
        $('#form-settings .form-control').removeClass('d-none');
        $('#btn-open-settings').addClass('d-none');
        $('#btn-edit-settings').removeClass('d-none');
        $('#btn-reset-settings').removeClass('d-none');
    });
    $('#btn-reset-settings').click(function (e) { 
        e.preventDefault();
        $('#form-settings .form-label.edit').removeClass('d-none');
        $('#form-settings .form-control').addClass('d-none');
        $('#background').val($('#background').attr('data-value'));
        $('#language').val($('#language').attr('data-value'));
        $('#speech').val($('#speech').attr('data-value'));
        $('#btn-open-settings').removeClass('d-none');
        $('#btn-edit-settings').addClass('d-none');
        $('#btn-reset-settings').addClass('d-none');
    });

    @if (Session::has('msg'))
        Swal.fire('{{Session::get('msg')}}', "", '{{Session::get('type')}}');
    @endif

    var default_params = {
        form: 'form-info'
    };
    var params = {
        form: '{{old('form')??'form-info'}}'
    };
    
    @if (Session::has('form'))
        params.form = '{{Session::get('form')}}';
    @endif

    if(window.location.hash) {
        let str_hash = window.location.hash.slice(1);
        let arr_params = str_hash.split('&');
        for(let i = 0; i < arr_params.length; i++) arr_params[i] = arr_params[i].split('=');
        arr_params.forEach(item =>{
            if(Array.isArray(default_params[item[0]])){
                item[1] = item[1].split('+').map(x => Number(x));
            }
        });
        let ob =  Object.fromEntries(arr_params);
        params = Object.assign(params, ob)
    }

    function buildhash(){
        let first = false, hash = '';
        Object.keys(params).forEach(key => {
            if((!Array.isArray(params[key]) && params[key] != default_params[key]) || (Array.isArray(params[key]) && params[key].length >0)){
                if(first) hash += '&';  
                first = true; hash += key+'='+(Array.isArray(params[key])?params[key].join('+'):params[key]);
            }
        });
        history.replaceState(null, document.title, location.pathname);
        if(first) window.location.hash = hash;
    }

    const listItemsForm = document.querySelectorAll('.list-group li');
    listItemsForm.forEach((item) =>{
        if(item.getAttribute('data-form') == params.form){
            buildhash();
            item.classList.add('active');
            $('#'+item.getAttribute('data-form')).addClass('active');
        }
        item.addEventListener('click', (e) => {
            $('.list-group li').removeClass('active');
            $('.form-item').removeClass('active');
            item.classList.add('active');
            params.form = item.getAttribute('data-form');
            buildhash();
            $('#'+item.getAttribute('data-form')).addClass('active');
        });
    });

    $('#flexSwitchCheckDefault').change(function (e) { 
        e.preventDefault();
        let checkShowPass = $(this).is(":checked");
        if(checkShowPass){
            $('#form-change-pass input.pass').attr('type', 'text');
        }else{
            $('#form-change-pass input.pass').attr('type', 'password');
        }
    });

    //tạo dataTable
    $(function () {
        var table = new DataTable('#example-all-request', {
            processing: true,
            serverSide: true,
            ajax: '{{route('infoUserAllRequest')}}',
            columns: [
                { data: 'index', name: 'index' },
                { data: 'link', name: 'link' },
                { data: 'status-alert', name: 'status-alert', orderable: false },
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
            dom: '<"clear"><"top"Bifrt><"bottom"lp>',
            buttons: [
                { text: 'Load lại', 
                    action: function ( e, dt, node, config ) {
                        dt.ajax.reload();
                    }
                },
            ],
        });
        var table = new DataTable('#example-all-manager', {
            processing: true,
            serverSide: true,
            ajax: '{{route('infoUserAllManager')}}',
            columns: [
                { data: 'index', name: 'index' },
                { data: 'name', name: 'name' },
                { data: 'chapters', name: 'chapters' },
                { data: 'list_categories', name: 'list_categories', orderable: false },
                { data: 'status', name: 'status', orderable: false},
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
            dom: '<"clear"><"top"Bifrt><"bottom"lp>',
            buttons: [
                { text: 'Load lại', 
                    action: function ( e, dt, node, config ) {
                        dt.ajax.reload();
                    }
                },
            ],
        });
        var table = new DataTable('#example-all-history', {
            processing: true,
            serverSide: true,
            ajax: '{{route('showHistory')}}',
            columns: [
                { data: 'index', name: 'index' },
                { data: 'story.name', name: 'name_story' },
                { data: 'chapter.index_chap', name: 'index_chap' },
                { data: 'paragraph', name: 'paragraph'},
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
            dom: '<"clear"><"top"Bifrt><"bottom"lp>',
            buttons: [
                { text: 'Load lại', 
                    action: function ( e, dt, node, config ) {
                        dt.ajax.reload();
                    }
                },
            ],
        });
        $('#example_processing').html('<img src="storage/images/loading.gif" width="80" height="80">');
        $('#example_processing').css({padding: 0, margin: 0, width: '80px', height: '80px', 
            translate: '-50% -50%', 'border-radius': '50%', 'z-index': 100});
        setTimeout(function() {
            $('.dark-mode .dropdown-item').css({color: 'black'});
        }, 10);
    });

    function deleteHistory(){
        
    }
</script>
@endsection