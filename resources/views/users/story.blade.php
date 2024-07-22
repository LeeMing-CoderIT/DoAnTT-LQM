@extends('users.layout')

@section('css')
    
@endsection

@section('content')
<main>
    <input type="hidden" id="story_slug" value="{{ $story_info->slug }}">
    <div class="container">
        <div class="row align-items-start">
            <div class="col-12 col-md-7 col-lg-8">
                <div class="head-title-global d-flex justify-content-between mb-4 justify-content-center">
                    <div class="col-12 col-md-12 col-lg-4 head-title-global__left d-flex">
                        <h2 class="me-2 mb-0 border-bottom border-secondary pb-1">
                            <span class="d-block text-decoration-none text-dark fs-4 title-head-name"
                                title="Thông tin truyện">Thông tin truyện</span>
                        </h2>
                    </div>
                    <button class="d-none" style="border: none; background: none; color: white;" id="btn-show-review"><i class="fa-solid fa-volume-high"></i></button>
                    <audio id="sound-review"></audio>
                </div>

                <div class="story-detail">
                    <div class="story-detail__top d-flex align-items-start">
                        <div class="row align-items-start">
                            <div class="col-12 col-md-12 col-lg-3 story-detail__top--image">
                                <div class="book-3d">
                                    <img src="{{ $story_info->image }}" class="img-fluid w-100" width="200"
                                        height="300" loading="lazy">
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-9">
                                <h3 class="text-center story-name">{{ ($story_info->name) }}</h3>
                                <div class="rate-story mb-2">
                                    <div class="rate-story__holder" data-score="7.0"></div>
                                    <em class="rate-story__text"></em>
                                    <div class="rate-story__value" itemprop="aggregateRating" itemscope=""
                                        itemtype="https://schema.org/AggregateRating">
                                        <em>
                                            <span>
                                                Đã có
                                            </span>
                                            <strong>
                                                {{$story_info->infoViews()->views_year}}
                                            </strong>
                                            <span>
                                                lượt theo dõi
                                            </span>
                                        </em>
                                    </div>
                                </div>

                                <div class="story-detail__top--desc px-3" style="max-height: 285px;" id="txtdescription">
                                    {!! ($story_info->description) !!}
                                </div>

                                <div class="info-more">
                                    <div class="info-more--more active" id="info_more">
                                        <span class="me-1 text-dark">Xem thêm</span>
                                        <svg width="14" height="8" viewBox="0 0 14 8" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M7.70749 7.70718L13.7059 1.71002C14.336 1.08008 13.8899 0.00283241 12.9989 0.00283241L1.002 0.00283241C0.111048 0.00283241 -0.335095 1.08008 0.294974 1.71002L6.29343 7.70718C6.68394 8.09761 7.31699 8.09761 7.70749 7.70718Z"
                                                fill="#2C2C37"></path>
                                        </svg>
                                    </div>

                                    <a class="info-more--collapse text-decoration-none">
                                        <span class="me-1 text-dark">Thu gọn</span>
                                        <svg width="14" height="8" viewBox="0 0 14 8" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M7.70749 0.292817L13.7059 6.28998C14.336 6.91992 13.8899 7.99717 12.9989 7.99717L1.002 7.99717C0.111048 7.99717 -0.335095 6.91992 0.294974 6.28998L6.29343 0.292817C6.68394 -0.097606 7.31699 -0.0976055 7.70749 0.292817Z"
                                                fill="#2C2C37"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="story-detail__bottom mb-3">
                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-3 story-detail__bottom--info">
                                <p class="mb-1">
                                    <strong>Tác giả:</strong>
                                    <a href="/filter-stories#keywords={{$story_info->author}}"
                                        class="text-decoration-none text-dark hover-title">{{ ($story_info->author) }}</a>
                                </p>
                                <div class="d-flex align-items-center mb-1 flex-wrap">
                                    <strong class="me-1">Thể loại:</strong>
                                    <div class="d-flex align-items-center flex-warp">
                                        @if ($story_info->categories)
                                            @foreach ($story_info->categories as $key => $item)
                                            {{ ($key > 0)?',':'' }}
                                            <a href="{{ route('category', ['category' => $item->slug])}}"
                                                class="text-decoration-none text-dark hover-title  me-1"
                                                style="width: max-content; {{ ($key > 0)?'margin-left: 5px;':'' }}">{{ ($item->name) }}
                                            </a>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>

                                <p class="mb-1">
                                    <strong>Trạng thái:</strong>
                                    @if ($story_info->status == 0)
                                        <span class="text-info">Full</span>
                                    @elseif($story_info->status == 1)
                                        <span class="text-success">Đang ra</span>
                                    @else
                                        <span class="text-danger">Drop</span>
                                    @endif
                                </p>
                            </div>

                        </div>
                    </div>

                    <div class="story-detail__list-chapter">
                        <div class="head-title-global d-flex justify-content-between mb-4">
                            <div class="col-6 col-md-12 col-lg-4 head-title-global__left d-flex">
                                <h2 class="me-2 mb-0 border-bottom border-secondary pb-1">
                                    <span href="#"
                                        class="d-block text-decoration-none text-dark fs-4 title-head-name">Danh sách chương</span>
                                </h2>
                            </div>
                        </div>

                        <div class="story-detail__list-chapter--list">
                            <div class="row" id="chapter-full"></div>
                        </div>
                    </div>

                    <div class="pagination" id="pagination" style="justify-content: center;" data-pages="{{ $story_info->allPage(50) }}" data-limit="50"></div>
                </div>
            </div>

            <div class="col-12 col-md-5 col-lg-4 sticky-md-top">

                <div class="row top-ratings">
                    <div class="col-12 top-ratings__tab mb-2">
                        <div class="list-group d-flex flex-row" id="list-tab" role="tablist">
                            <a class="list-group-item list-group-item-action active" id="top-day-list" onclick="click_tab_pane('top-day')">Ngày</a>
                            <a class="list-group-item list-group-item-action" id="top-month-list" onclick="click_tab_pane('top-month')">Tháng</a>
                            <a class="list-group-item list-group-item-action" id="top-all-time-list" onclick="click_tab_pane('top-all-time')">All time</a>
                        </div>
                    </div>
                    <div class="col-12 top-ratings__content">
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade" id="top-day" role="tabpanel" aria-labelledby="top-month-list" data-list="hot-day">
                                <ul></ul>
                            </div>

                            <div class="tab-pane fade" id="top-month" role="tabpanel" aria-labelledby="top-month-list" data-list="hot-month">
                                <ul></ul>
                            </div>

                            <div class="tab-pane fade" id="top-all-time" role="tabpanel" aria-labelledby="top-all-time-list" data-list="hot">
                                <ul></ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="section-list-category bg-light p-2 rounded card-custom">
                    <div class="head-title-global mb-2">
                        <div class="col-12 col-md-12 head-title-global__left">
                            <h2 class="mb-0 border-bottom border-secondary pb-1">
                                <span class="d-block text-decoration-none text-dark fs-4">Thể loại truyện</span>
                            </h2>
                        </div>
                    </div>
                    <div class="row">
                        <!-- Horizontal under breakpoint -->
                        <ul class="list-category">
                            @foreach ($categories as $category)
                            <li><a href="{{ route('category', ["category"=> $category->slug]) }}" class="text-decoration-none text-dark hover-title">{{ ($category->name) }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@section('js')
<script src="assets/users/js/story.js"></script>
@endsection