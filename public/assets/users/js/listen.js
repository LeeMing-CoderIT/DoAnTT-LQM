const textContents = document.getElementById('contents');
const nameChapter = document.getElementById('name-chapter');
const audio = document.getElementById('audio');
const progress = document.getElementById('progress');
const speechAudio = document.getElementById('speech-audio');
const currentProgress = document.getElementById('currentProgress');
const maxProgress = document.getElementById('maxProgress');
const allContent = textContents.querySelectorAll('.item-content');
const screenApp = document.getElementsByTagName('main');
var loadStart;
var story_slug = $('#name-story').attr('data-slug');
var chapter_id = $('#name-chapter').attr('data-id');
var __token = Math.random(10);
const app = {
    loadingxSpeech: 1,
    currentIndex: 0,
    currentSpeech: $('#speech-audio').val(),
    isPlaying: false, loading: true, continue: true,
    isFirst: true,
    mp3: [], notMP3Loanging: [],
    loadMP3: function(index){
        const _this = this;
        if(_this.continue){
            if(index < textContents.children.length){
                if( _this.notMP3Loanging.indexOf(index) >= 0){
                    $.ajax({
                        type: "get",
                        url: "/tranlateToMP3",
                        data: {
                            text: textContents.children[index].innerText,
                            token: __token,
                            index: index,
                        },
                        success: function (response) {
                            if (response.success) {
                                if(response.token == __token){
                                    if(_this.loading === false){
                                        _this.continue = false
                                        console.log('dừng');
                                    }else{
                                        _this.notMP3Loanging.splice(_this.notMP3Loanging.indexOf(index), 1);
                                        _this.mp3[index] = response.data;
                                        index = Number(index) + _this.loadingxSpeech;
                                        _this.loadMP3(index);
                                    }
                                }
                            } else {
                                $('#controlls-box').hide();
                                Swal.fire(response.text, "", 'warning');
                            }
                        }
                    });
                }else{
                    index = Number(index) + _this.loadingxSpeech;
                    _this.loadMP3(index);
                }
            }else{
                if(_this.notMP3Loanging.length > 0){
                    index = _this.notMP3Loanging[0];
                    _this.loadMP3(index);
                }
            }
        }
    },
    contents: function() {
        $('#loading-content').removeClass('d-none');
        $('#error-chapter').addClass('d-none');
        $('#contents').addClass('d-none');
        $('#btn-next').addClass('disabled');
        $('#btn-prev').addClass('disabled');
        const _this = this;
        $.ajax({
            type: "get",
            url: "/show-chapter",
            data: {
                story: story_slug, 
                chapter: chapter_id,
                token: __token,
            },
            success: function (response) {
                if(response.token == __token){
                    if(response.nextChap){
                        $('#btn-next').removeClass('disabled');
                        $('#btn-next').attr('data-chapter', response.nextChap.index_chap);
                        $('#btn-next').attr('title', `Chương ${response.nextChap.index_chap}: ${response.nextChap.name}`);
                    }
                    if(response.prevChap){
                        $('#btn-prev').removeClass('disabled');
                        $('#btn-prev').attr('data-chapter', response.prevChap.index_chap);
                        $('#btn-prev').attr('title', `Chương ${response.prevChap.index_chap}: ${response.prevChap.name}`);
                    }
                    if(response.chapter) {
                        $('#contents').html(response.chapter.content);
                        $('#name-chapter').html(`Chương ${response.chapter.index_chap}: ${response.chapter.name}`);
                        $('#list-chapters li').removeClass('playing');
                        $(`#list-chapters li[data-chapter="${response.chapter.index_chap}"]`).addClass('playing');
                        $('#loading-content').addClass('d-none');
                        $('#contents').removeClass('d-none');
                        setTimeout(function(){
                            $('#contents div').addClass('item-content');
                            const allContent = textContents.querySelectorAll('.item-content');
                            _this.notMP3Loanging = [];
                            allContent.forEach((contentItem, index)=>{
                                _this.notMP3Loanging.push(index);
                                contentItem.addEventListener('contextmenu', (e)=>{
                                    e.preventDefault();
                                    let topContext = e.pageY;
                                    let leftContext = (e.pageX+150 > $('main').width())?($('main').width()-200):e.pageX;
                                    $('#contents .item-content').removeClass('context-menu');
                                    contentItem.classList.add('context-menu');
                                    $('#options-contextmenu').css({top: topContext, left: leftContext});
                                    $('#options-contextmenu').attr('data-current', index);
                                    $('#options-contextmenu').removeClass('d-none');
                                });
                            });
                            progress.max = textContents.children.length;
                            maxProgress.innerText = textContents.children.length;
                            _this.loadMP3(_this.currentIndex);
                        },100);
                    }else{
                        $('#loading-content').addClass('d-none');
                        $('#error-chapter').removeClass('d-none');
                    }
                }
            }
        });
    },
    chapters: function() {
        const _this = this;
        $.ajax({
            type: "get",
            url: `/loadChap`,
            data: {
                story: story_slug, show: '*',
            },
            success: function (response) {
                $('#list-chapters').html('');
                response.forEach(chapter => {
                    let html = `<li data-chapter="${chapter.index_chap}" title="Chương ${chapter.index_chap}: ${chapter.name}">Chương ${chapter.index_chap}: ${chapter.name}</li>`;
                    $('#list-chapters').append(html);
                });
                const listChapters = document.querySelectorAll('#list-chapters li');
                listChapters.forEach((chapter, index) => {
                    chapter.addEventListener('click', (e) => {
                        chapter_id = Number(chapter.getAttribute('data-chapter'));
                        __token = _this.ramdomToken();
                        $('#name-chapter').html(chapter.title);
                        _this.start();
                    });
                });
            }
        });
    },
    handleEvents: function(){
        const _this = this;
        //mở danh sách chương
        $('#btn-list-chapters').click(function (e) { 
            e.preventDefault();
            $('.box-list-chapters').css({right: 0});
        });
        //đóng danh sách chương
        $('.box-list-chapters .btn-close').click(function (e) { 
            e.preventDefault();
            $('.box-list-chapters').css({right: '-100%'});
        });
        //click phát-tạm dừng audio 
        $('#btn-play').click(function (e) { 
            e.preventDefault();
            if(_this.isPlaying){
                audio.pause();
            }else{
                audio.play();
            }
        });
        //click phát context menu
        $('#context-play').click(function (e) { 
            e.preventDefault();
            audio.pause();
            _this.currentIndex = Number($('#options-contextmenu').attr('data-current'));
            _this.loading = false;
            var loadContinue = setInterval(()=>{
                if(_this.continue === false) {
                    clearInterval(loadContinue);
                    _this.loading = true;
                    _this.continue = true;
                    _this.loadMP3(_this.currentIndex);
                }
            }, 10);
            currentProgress.innerText = this.currentIndex+1;
            _this.loadCurrentMP3();
        });
        //next chương truyện
        $('#btn-next').click(function (e) { 
            e.preventDefault();
            if($(this).attr('data-chapter') && Number($(this).attr('data-chapter'))){
                chapter_id = Number($(this).attr('data-chapter'));
                __token = _this.ramdomToken();
                $('#name-chapter').html($(this).attr('title'));
                _this.start();
            }
        });
        //prev chương truyện
        $('#btn-prev').click(function (e) { 
            e.preventDefault();
            if($(this).attr('data-chapter') && Number($(this).attr('data-chapter'))){
                chapter_id = Number($(this).attr('data-chapter'));
                __token = _this.ramdomToken();
                $('#name-chapter').html($(this).attr('title'));
                _this.start();
            }
        });
        $('#btn-speed').click(function (e) { 
            e.preventDefault();
            $('#setting-speech').removeClass('d-none');
        });
        // đóng setting tốc độ phát và thay đổi
        $('#change-speech').click(function (e) { 
            e.preventDefault();
            let value = Number(speechAudio.value);
            if(value <= 2 && value >= 0.5 && value != _this.currentSpeech){
                $.ajax({
                    type: "get",
                    url: "/change-speech",
                    data: {
                        speech: value,
                    },
                    success: function (response) {
                        console.log(response);
                        _this.currentSpeech = value;
                        audio.defaultPlaybackRate = _this.currentSpeech;
                        _this.loadCurrentMP3();
                    }
                });
            }
            $('#currentSpeed').html(_this.currentSpeech);
            speechAudio.value = _this.currentSpeech;
            $('#setting-speech').addClass('d-none');
        });
        // đóng setting tốc độ phát và hủy thay đổi
        $('#close-setting-speech').click(function (e) { 
            e.preventDefault();
            $('#currentSpeed').html(_this.currentSpeech);
            speechAudio.value = _this.currentSpeech;
            $('#setting-speech').addClass('d-none');
        });
        //audio phát
        audio.onplay = function () {
            _this.isPlaying = true;
            $('#btn-play').addClass('playing');
        };
        //audio tạm dừng
        audio.onpause = function () {
            _this.isPlaying = false;
            $('#btn-play').removeClass('playing');
        };
        //chỉnh tốc độ
        speechAudio.onchange = function (e) {
            let value = Number(e.target.value);
            if(value <= 2 && value >= 0.5){
                $('#currentSpeed').html(value);
                speechAudio.value = value;
            }
        };
        //audio tua
        progress.onchange = function (e) {
            audio.pause();
            let value = Number(e.target.value) - 1;
            if(value < 0) value = 0;
            _this.currentIndex = value;
            _this.loading = false;
            var loadContinue = setInterval(()=>{
                if(_this.continue === false) {
                    clearInterval(loadContinue);
                    _this.loading = true;
                    _this.continue = true;
                    _this.loadMP3(_this.currentIndex);
                }
            }, 10);
            currentProgress.innerText = this.currentIndex+1;
            _this.loadCurrentMP3();
        };
        //kết thúc mp3 chuyển tiếp
        audio.onended = function () {
            _this.currentIndex += 1;
            if(_this.currentIndex < textContents.children.length){
                _this.loadCurrentMP3();
            }
            else{
                $('#btn-next').click();
            }
        };
        //click vào app
        screenApp[0].onclick = function(e){
            $('#options-contextmenu').addClass('d-none');
            $('#contents .item-content').removeClass('context-menu');
        }
        $('#bg-box-list').click(function (e) { 
            e.preventDefault();
            $('.box-list-chapters .btn-close').click();
        });
    },
    ramdomToken: function(){
        this.isFirst = false;
        audio.pause();
        let newtoken;
        do{
            newtoken = Math.random(10);
        }
        while(newtoken === __token);
        return newtoken;
    },
    loadScroll: function(){
        let headerHeight = $('header.header').height() + $('.header-mobile').height();
        $('html, body').animate({
            scrollTop: $(textContents.children[this.currentIndex]).offset().top - headerHeight - 30,
        }, 500, 'linear');
    },
    loadCurrentMP3: function(){
        params.paragraph = this.currentIndex+1;
        buildhash();
        $.ajax({
            type: "get",
            url: "/save-history-paragraph",
            data: {
                story: story_slug, 
                chapter: chapter_id,
                token: __token,
                paragraph: params.paragraph,
            },
            success: function (response) {
                
            }
        });
        $('#btn-play').addClass('disabled');
        clearInterval(loadStart);
        loadStart = setInterval(()=>{
            if(this.mp3[this.currentIndex]){
                clearInterval(loadStart);
                $('#btn-play').removeClass('disabled');
                this.loadScroll();
                currentProgress.innerText = this.currentIndex+1;
                progress.value = this.currentIndex+1;
                audio.src = 'data:audio/mpeg;base64,'+this.mp3[this.currentIndex];
                $('#contents .item-content').removeClass('active');
                $(`#contents .item-content:eq(${this.currentIndex})`).addClass('active');
                audio.defaultPlaybackRate = this.currentSpeech;
                audio.load();
                if(!this.isFirst) audio.play();
                this.isFirst = false;
            }
        }, 10);
    },
    start: function(currentIndex = 0){
        if(currentIndex<0) currentIndex=0;
        this.currentIndex = currentIndex;
        this.mp3 = [];
        //load ra nội dung của chương truyện
        this.contents();
        currentProgress.innerText = '0';
        //chạy lần đầu
        this.loadCurrentMP3();
    }
}

var default_params = {
    paragraph: 1
};
var params = {
    paragraph: 1
};

if(window.location.hash) {
    let str_hash = window.location.hash.slice(1);
    let arr_params = str_hash.split('&');
    for(let i = 0; i < arr_params.length; i++) arr_params[i] = arr_params[i].split('=');
    arr_params.forEach(item =>{
        if(Array.isArray(default_params[item[0]])){
            item[1] = item[1].split('+').map(x => Number(x));
        }
    });
    let ob =  Object.fromEntries(arr_params);
    params = Object.assign(params, ob)
}

function buildhash(){
    let first = false, hash = '';
    Object.keys(params).forEach(key => {
        if((!Array.isArray(params[key]) && params[key] != default_params[key]) || (Array.isArray(params[key]) && params[key].length >0)){
            if(first) hash += '&';  
            first = true; hash += key+'='+(Array.isArray(params[key])?params[key].join('+'):params[key]);
        }
    });
    history.replaceState(null, document.title, location.pathname);
    if(first) window.location.hash = hash;
}

//load ra các chương của bộ truyện
app.chapters();
//Load các sự kiện của app
app.handleEvents();
//chạy app
app.start(params.paragraph-1);