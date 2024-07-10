@extends('users.layout')

@section('css')
    <style>
        .btn-load-search{
            background: rgb(131, 131, 131); width: 50%; color: white;
        }
        .btn-load-search:focus{
            background: rgb(131, 131, 131); color: white;
        }
        #loading-stories{
            position: absolute; top: -48px; right: 15px; width: 50px; height: 50px;
        }
        .filter-item{
            background: rgb(221, 221, 221); padding: 5px; border-radius: 4px; cursor: pointer;
            display: inline-block; width: auto; margin-bottom: 5px; color: black;
        }
        .filter-item.active{
            background: rgb(141, 141, 141);
        }
        .dark-theme .filter-item{
            background: rgb(92, 92, 92); color: white
        }
        .dark-theme .filter-item.active{
            background: rgb(29, 29, 29);
        }
    </style>
@endsection

@section('content')
<main>
    <div class="container">
        <div class="row align-items-start">
            <div class="col-12 col-md-8 col-lg-9 mb-3 mt-3 position-relative">
                <img src="storage/images/loading.gif" alt="" id="loading-stories">
                <div class="head-title-global d-flex justify-content-between mb-2 gap-1">
                    <select class="form-select" id="list-filter">
                        <option value="new-update" selected>Mới cập nhật</option>
                        <option value="hot">Truyện hot</option>
                        <option value="new">Truyện mới</option>
                    </select>
                    <select class="form-select" id="status-filter">
                        <option value="*" selected>Trạng thái</option>
                        <option value="0">Hoàn thành</option>
                        <option value="1">Đang ra</option>
                      </select>
                    <input class="form-control" type="text" id="text-search" placeholder="Tìm kiếm">
                    <button class="form-control btn-secondary btn-load-search" id="btn-load-search" type="button">Tìm kiếm</button>
                </div>

                <div class="list-story-in-category section-stories-hot__list d-none" id="list-item"></div>
                
                <div class="section-stories-hot__list wrapper-skeleton" id="lazy-load">
                    <div class="skeleton" style="max-width: 150px; width: 100%; height: 230px;"></div>
                    <div class="skeleton" style="max-width: 150px; width: 100%; height: 230px;"></div>
                    <div class="skeleton" style="max-width: 150px; width: 100%; height: 230px;"></div>
                    <div class="skeleton" style="max-width: 150px; width: 100%; height: 230px;"></div>
                    <div class="skeleton" style="max-width: 150px; width: 100%; height: 230px;"></div>
                    <div class="skeleton" style="max-width: 150px; width: 100%; height: 230px;"></div>
                    <div class="skeleton" style="max-width: 150px; width: 100%; height: 230px;"></div>
                    <div class="skeleton" style="max-width: 150px; width: 100%; height: 230px;"></div>
                </div>

                <label id="not-stories" class="form-control d-none">Không có truyện phù hợp yêu cầu tìm kiếm.</label>

                <div class="pagination" id="pagination" style="justify-content: center;" data-pages="5"></div>
            </div>

            <div class="col-12 col-md-4 col-lg-3 sticky-md-top">
                <div class="category-description bg-light p-2 rounded mb-3 card-custom overflow-hidden">
                    @foreach ($categories as $category)
                    <span class="filter-item category-item" data-id="{{ $category->id }}">{{ $category->name }}</span>
                    @endforeach
                </div>

                <div class="category-description bg-light p-2 rounded mb-3 card-custom overflow-hidden">
                    <span class="filter-item chaps-item" data-at="0-100">Dưới 100</span>
                    <span class="filter-item chaps-item" data-at="100-500">Từ 100 - 500</span>
                    <span class="filter-item chaps-item" data-at="500-1000">Từ 500 - 1000</span>
                    <span class="filter-item chaps-item" data-at="1000-50000">Trên 1000</span>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@section('js')
<script src="assets/users/js/filter.js"></script>
@endsection