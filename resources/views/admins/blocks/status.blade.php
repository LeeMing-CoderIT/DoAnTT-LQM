@if ($status == 0)
<span class="badge bg-success" style="padding: 5px; font-size: 0.8rem">Full</span>
@elseif($status == 1)
<span class="badge bg-warning" style="padding: 5px; font-size: 0.8rem">Đang ra</span>
@else
<span class="badge bg-danger" style="padding: 5px; font-size: 0.8rem">Drop</span>
@endif