@if ($status == 1)
<span class="badge bg-success" style="padding: 5px; font-size: 0.8rem">Đã hoàn thành</span>
@elseif($status == 0)
<span class="badge bg-warning" style="padding: 5px; font-size: 0.8rem">Đang xử lý</span>
@else
<span class="badge bg-danger" style="padding: 5px; font-size: 0.8rem">Đã hủy yêu cầu</span>
@endif