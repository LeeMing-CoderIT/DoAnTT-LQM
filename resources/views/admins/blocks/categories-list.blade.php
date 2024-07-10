@foreach ($categories as $key => $category)
    <span class="badge bg-cyan" style="padding: 3px; font-size: 0.8rem">{{$category->name}}</span></br>
@endforeach