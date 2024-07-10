@foreach ($categories as $key => $category)
    @if ($key < 3)
    <span class="badge bg-primary" style="padding: 3px; font-size: 0.8rem">{{$category->name}}</span></br>
    @elseif($key == 3)
    <span class="badge bg-primary" style="padding: 3px; font-size: 0.8rem">...v.v...</span></br>
    @endif
@endforeach