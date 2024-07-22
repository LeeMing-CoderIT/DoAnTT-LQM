@extends('users.layout')

@section('css')
<link rel="stylesheet" href="assets/users/css/listen.css">
<link rel="stylesheet" href="assets/admins/plugins/sweetalert2/sweetalert2.min.css">
@endsection

@section('content')
<main>
    <div class="chapter-wrapper container my-5">
        <a href="/story/{{$story_info->slug}}" class="text-decoration-none">
            <h1 class="text-center text-success" id="name-story" data-slug="{{$story_info->slug}}">{{$story_info->name}}</h1>
        </a>
        <a class="text-decoration-none">
            <p class="text-center text-dark" style="font-weight: bolder !important;" id="name-chapter" data-id="{{$chapter_id}}"></p>
        </a>
        <hr class="chapter-end container-fluid">


        <div class="chapter-content mb-3 d-flex justify-content-center" id="loading-content">
            <img src="storage/images/loading.gif" width="50" height="50" alt="">
        </div>
        <div class="chapter-content mb-3 d-none" id="contents"></div>

        <div class="chapter-content mb-3 d-none" id="error-chapter">
            <div class="alert alert-danger">Chương không tồn tại.</div>
        </div>
        
        <ul id="options-contextmenu" class="d-none" data-current="0">
            <li id="context-play">Phát</li>
            <li>Tạm ngưng</li>
            <li>Đọc lại</li>
        </ul>
        <div id="setting-speech" class="d-none" data-current="0">
            <div class="d-flex align-items-center gap-1 w-100">
                <span>Tốc độ: </span><span id="currentSpeed">{{Auth::user()->settings()->speech}}</span>
            </div>
            <div class="d-flex justify-content-center align-items-center gap-1 w-100 position-relative">
                <div class="number-speech">0.5</div>
                <div class="col-10">
                    <input type="range" class="form-range" min="0.5" max="2" step="0.25" value="{{Auth::user()->settings()->speech}}" id="speech-audio">
                </div>
                <div class="number-speech">2</div>
            </div>
            <div class="d-flex align-items-center justify-content-end gap-1 w-100 mt-2">
                <button class="btn btn-dark" id="close-setting-speech">Hủy</button>
                <button class="btn btn-primary" id="change-speech">Xác nhận</button>
            </div>
        </div>
    </div>

    <div class="box-controls position-fixed bottom-0 w-100 p-3 d-flex flex-column align-self-center justify-content-center" id="controlls-box">
        <div class="d-flex justify-content-center align-items-center gap-1">
            <div class="number-range" id="currentProgress">1</div>
            <div class="col-10 col-lg-6">
                <input type="range" class="form-range col-6" min="0" max="100" step="1" value="1" id="progress">
            </div>
            <div class="number-range" id="maxProgress">100</div>
        </div>
        <div class="row justify-content-center align-items-center gap-2">
            <button id="btn-speed" class="btn-controll"><i class="fa-solid fa-bolt-lightning"></i></button>
            <button id="btn-prev" class="btn-controll disabled"><i class="fa-solid fa-backward-step"></i></button>
            <button id="btn-play" class="btn-controll"></button>
            <button id="btn-next" class="btn-controll disabled"><i class="fa-solid fa-forward-step"></i></button>
            <button id="btn-settings" class="btn-controll"><i class="fa-solid fa-gear"></i></button>
        </div>
        <button id="btn-list-chapters" class="btn-controll"><i class="fa-solid fa-list"></i></button>
        <audio id="audio" src=""></audio>
    </div>

    <div class="box-list-chapters d-flex">
        <div class="col-2 col-lg-8 col-md-7 col-sm-6 h-100" id="bg-box-list"></div>
        <div class="col-10 col-lg-4 col-md-5 col-sm-6" style=" background: rgba(0, 0, 0, 0.877);">
            <button class="btn-close"><i class="fa-solid fa-xmark"></i></button>
            <ul id="list-chapters"></ul>
        </div>
    </div>
</main>
@endsection

@section('js')
<script src="assets/users/js/listen.js"></script>
<script src="assets/admins/plugins/sweetalert2/sweetalert2.all.min.js"></script>
@endsection