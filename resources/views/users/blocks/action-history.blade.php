<a href="{{route('listen', ['story'=>$story->slug, 'chap'=>$chapter->index_chap])}}#paragraph={{$paragraph}}" title="Nghe tiếp" class="btn btn-primary btn-custom-action"><i class="fa-solid fa-headphones"></i></i></a>
<a href="javascript:void(0)" class="btn btn-danger" title="Xóa khỏi lịch sử" onclick="deleteHistory({{$index}});">
    <i class="fas fa-trash-alt"></i>
</a>