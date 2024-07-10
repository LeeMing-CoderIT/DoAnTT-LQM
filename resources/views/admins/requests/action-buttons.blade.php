@if ($status == 0)
<a href="javascript:void(0)" class="btn btn-primary" title="Xử lý yêu cầu" data-toggle="modal" 
data-target="#modal-xl" onclick="enforcement({{$user->id}},{{$id}});">
    <i class="fas fa-pen-square"></i>
</a>
<a href="javascript:void(0)" class="btn btn-danger" title="Hủy yêu cầu" onclick="cancel({{$id}});">
    <i class="fas fa-times"></i>
</a>
@elseif($status == 1)
<span class="badge bg-success" style="padding: 5px; font-size: 0.8rem">Đã hoàn thành</span>
@else
<span class="badge bg-danger" style="padding: 5px; font-size: 0.8rem">Đã hủy bỏ</span>
@endif
<a href="javascript:void(0)" class="btn btn-danger" title="Xóa yêu cầu" onclick="deleteData({{$id}});">
    <i class="fas fa-trash-alt"></i>
</a>