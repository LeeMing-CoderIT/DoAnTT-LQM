@extends('users.layout')

@section('css')
    
@endsection

@section('content')
<main>
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-8 col-lg-9 mb-3">
                <div class="head-title-global d-flex justify-content-between mb-2">
                    <div class="col-12 col-md-12 col-lg-12 head-title-global__left d-flex">
                        <h2 class="me-2 mb-0 border-bottom border-secondary pb-1">
                            <span href="#" class="d-block text-decoration-none text-dark fs-4 category-name"
                                title="{{ $category_info->name }}">{{ $category_info->name }}</span>
                        </h2>
                    </div>
                </div>

                <div class="list-story-in-category section-stories-hot__list d-none" data-category="{{$category_info->id}}"></div>
                
                <div class="section-stories-hot__list wrapper-skeleton">
                    <div class="skeleton" style="max-width: 150px; width: 100%; height: 180px;"></div>
                    <div class="skeleton" style="max-width: 150px; width: 100%; height: 180px;"></div>
                    <div class="skeleton" style="max-width: 150px; width: 100%; height: 180px;"></div>
                    <div class="skeleton" style="max-width: 150px; width: 100%; height: 180px;"></div>
                    <div class="skeleton" style="max-width: 150px; width: 100%; height: 180px;"></div>
                    <div class="skeleton" style="max-width: 150px; width: 100%; height: 180px;"></div>
                    <div class="skeleton" style="max-width: 150px; width: 100%; height: 180px;"></div>
                    <div class="skeleton" style="max-width: 150px; width: 100%; height: 180px;"></div>
                </div>
                <label id="not-stories" class="form-control d-none">Không có truyện phù hợp yêu cầu tìm kiếm.</label>
            </div>

            <div class="col-12 col-md-4 col-lg-3 sticky-md-top">
                <div class="category-description bg-light p-2 rounded mb-3 card-custom">
                    <p class="mb-0 text-secondary"></p>
                    <p>{!! $category_info->description !!}</p>
                    <p></p>
                </div>
            </div>
            
        </div>
    </div>
</main>
@endsection

@section('js')
<script src="assets/users/js/category.js"></script>
@endsection