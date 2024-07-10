@extends('users.layout')

@section('css')
    
@endsection

@section('content')
<main>
    <div class="section-stories-hot mb-3" id="list-hot" data-list="hot" title="Truyện Hot"></div>

    <div class="container mb-3">
        <div class="row align-items-start">
            <div class="col-12 col-md-8 col-lg-9">
                <div class="section-stories-new mb-3"  id="list-new-update" data-list="new-update" title="Truyện Mới Cập Nhật"></div>
            </div>

            <div class="col-12 col-md-4 col-lg-3 sticky-md-top">
                <div class="row">
                    <div class="col-12">
                        <div class="section-list-category bg-light p-2 rounded card-custom">
                            <div class="head-title-global mb-2">
                                <div class="col-12 col-md-12 head-title-global__left">
                                    <h2 class="mb-0 border-bottom border-secondary pb-1">
                                        <span href="#" class="d-block text-decoration-none text-dark fs-4">Thể loại truyện</span>
                                    </h2>
                                </div>
                            </div>
                            <div class="row">
                                <!-- Horizontal under breakpoint -->
                                <ul class="list-category">
                                    @foreach ($categories as $category)
                                    <li class="">
                                        <a href="{{route('category', ['category' => $category->slug])}}" class="text-decoration-none text-dark hover-title">{{$category->name}}</a>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="section-stories-hot mb-3" id="list-full" data-list="full" title="Truyện Full"></div>

    <div class="section-stories-hot mb-3" id="list-new" data-list="new" title="Truyện Mới"></div>
</main>
@endsection

@section('js')
<script src="assets/users/js/home.js"></script>
@endsection