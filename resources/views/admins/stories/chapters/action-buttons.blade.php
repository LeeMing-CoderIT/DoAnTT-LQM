{{-- <a href="javascript:void(0)" title="Xem" class="btn btn-primary btn-custom-action" onclick="showData({{$index_chap}});"><i class="fas fa-book-reader"></i></a> --}}
<a href="javascript:void(0)" class="btn btn-warning" title="Cập nhật" data-toggle="modal" data-target="#modal-xl" onclick="editData({{$id}});">
    <i class="fas fa-edit"></i>
</a>
<a href="javascript:void(0)" class="btn btn-danger" title="Xóa" onclick="deleteData({{$id}});">
    <i class="fas fa-trash-alt"></i>
</a>