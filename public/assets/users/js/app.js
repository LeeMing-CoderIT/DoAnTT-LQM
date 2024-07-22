window.setCookie = function (name, value, days) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "") + expires + "; path=/";
}
window.getCookie = function (name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
    }
    return null;
}
window.loadingFullPage = function () {
    let elementLoading = $('#loadingPage');
    let status = elementLoading.css('display');
    if (status == 'none') {
        elementLoading.css('display', 'flex');
        $('body').css('overflow', 'hidden');
    } else {
        elementLoading.css('display', 'none');
        $('body').css('overflow', 'unset');
    }
}
window.objConfigFont = [
    {
        name: 'roboto', 
        value: "'Roboto Condensed', sans-serif",
    },
    {
        name: 'mooli',
        value: "'Mooli', sans-serif",
    },
    {
        name: 'patrick_hand',
        value: "'Patrick Hand', cursive"
    }
];

function eraseCookie(name) {
    document.cookie = name + '=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
}

var prevScrollPos = window.pageYOffset;
var scrollThreshold = 500;

window.enableScroll = function () {
    window.onscroll = function () {
        if (window.innerWidth < 992) {
            var currentScrollPos = window.pageYOffset;
            const headerMobile = document.querySelector('.header-mobile');

            if (prevScrollPos > currentScrollPos) {
                headerMobile.classList.add('show-scroll');
                headerMobile.classList.remove('hide-scroll');
            } else {
                if (currentScrollPos > scrollThreshold) {
                    headerMobile.classList.add('hide-scroll');
                    headerMobile.classList.remove('show-scroll');
                }
            }

            prevScrollPos = currentScrollPos;
        }
    }
}

window.enableScroll();

function showFullTabContent() {
    const productDetailInfo = document.querySelector('.story-detail__top--desc');
    if (productDetailInfo) {
        productDetailInfo.classList.add('show-full');

        const productDetailInfoMore = document.querySelector('.info-more');
        if (productDetailInfoMore) {
            const more = productDetailInfoMore.querySelector('.info-more--more');
            more && more.classList.remove('active');

            const collapse = productDetailInfoMore.querySelector('.info-more--collapse');
            collapse && collapse.classList.add('active');
        }
    }
}

function collapseDescription() {
    const productDetailInfoTabContent = document.querySelector('.story-detail__top--desc');
    if (productDetailInfoTabContent) {
        productDetailInfoTabContent.classList.remove('show-full');

        const productDetailInfoMore = document.querySelector('.info-more');
        if (productDetailInfoMore) {
            const more = productDetailInfoMore.querySelector('.info-more--more');
            more && more.classList.add('active');

            const collapse = productDetailInfoMore.querySelector('.info-more--collapse');
            collapse && collapse.classList.remove('active');
        }
    }
}

const storyDetailTopImage = document.querySelector('.story-detail__top--image');
if (storyDetailTopImage) {
    const img = storyDetailTopImage.querySelector('img');
    if (img) {
        const storyDesc = document.querySelector('.story-detail__top--desc');
        if (storyDesc) {
            storyDesc.style.maxHeight = img.clientHeight + 'px';
        }
    }
}

document.addEventListener('click', function (e) {
    if (e.target.classList.contains('info-more--more') || e.target.closest('.info-more--more')) {
        showFullTabContent();
    }

    if (e.target.classList.contains('info-more--collapse') || e.target.closest('.info-more--collapse')) {
        collapseDescription();
    }
});

function LightOrDark(mode = true){
    $(".theme_mode").prop('checked', mode);
    if(mode){
        $("body").addClass('dark-theme');
    }else{
        $("body").removeClass('dark-theme');
    }
}

$(".theme_mode").change(function (e) { 
    e.preventDefault();
    let valueThemeMode = $(this).is(":checked") ? 1 : 0;
    let user = $('#id-authencation').val();
    if(user != '-1'){
        $.ajax({
            type: "get",
            url: "/change-background/"+user+"/"+valueThemeMode,
            data: {},
            success: function (response) {
                // console.log('oke',response);
            }
        });
    }
    if ($(this).is(":checked")) {
        $("body").addClass('dark-theme');
    } else {
        $("body").removeClass('dark-theme');
    }
});

function renderTime(miliseconds) {
    let full_text_time = '';
    if(miliseconds > 1){
        full_text_time = Math.round(miliseconds)+' ngày';
    }else{
        if(miliseconds * 24 > 1){
            full_text_time = Math.round(miliseconds * 24)+' giờ';
        }else{
            if(miliseconds * 24 * 60 > 1){
                full_text_time = Math.round(miliseconds * 24 *60)+' phút';
            }else{
                full_text_time = (Math.round(miliseconds * 24 *60 * 60)<0?Math.round(miliseconds * 24 *60 * 60):1)+' giây';
            }
        }
    }
    return full_text_time+' trước';
}



(function(factory) {
    'use strict';
    if (typeof define === 'function' && define.amd) {
        define(['jquery'], factory);
    } else if (typeof exports !== 'undefined') {
        module.exports = factory(require('jquery'));
    } else {
        factory(jQuery);
    }

}(function($) {
    var ___default = {
        list: '*', status: '*', keywords: '', categories_id: [], chaps: [], max: 40
    };
    function buildFrame(form_select = false, notImg = false, lazy_load = false) {
        let select = `<div class="col-4 col-md-3 col-lg-2">
                            <select class="form-select select-stories-hot" id="form-select"></select>
                        </div>`;

        return `
        <div class="container">
            <div class="row">
                <div class="head-title-global d-flex justify-content-between mb-2">
                    <div class="${form_select?'col-6 align-items-center':'col-12'} col-md-4 col-lg-4 head-title-global__left d-flex">
                        <h2 class="me-2 mb-0 border-bottom border-secondary pb-1">
                            <a href="#" class="d-block text-decoration-none text-dark fs-4 story-name" id="stories-name"></a>
                        </h2>
                    </div>
                    ${form_select?select:''}
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="${(notImg)?'section-stories-new_update_list':'section-stories-hot__list'} ${(lazy_load)?'d-none':''}" id="list-item"></div>
                    ${(lazy_load)?'<div class="section-stories-hot__list wrapper-skeleton" id="lazy-load"></div>':''}
                </div>
            </div>
        </div>
        `;
    }
    function buildLazy() {
        let html = '';
        for (let i = 0; i < 8; i++) {
            html += `<div class="skeleton" style="max-width: 150px; width: 100%; height: 230px;"></div>`;
        }
        return html;
    }
    function addCategory(categories) {
        let index = 0, html = '';
        categories.forEach(category => {
            html += `<a href="/category/${category.slug}" class="hover-title text-decoration-none text-dark category-name" title="${category.name}">${ (index>0?', ':'')+category.name}</a>`;
            index++;
        });
        return html;
    }
    function addItem(list_item, params, notImg = false) {
        $.ajax({
            type: "get",
            url: "/searchStories",
            data: params,
            success: function (data) {
                if (data.success) {
                    var html = '';
                    data.stories.forEach(story =>{
                        if(story.new_chapter){
                            let lateDay = (new Date().getTime() - new Date(story.new_chapter.updated_at).getTime())/86400000;
                            if(!notImg){
                                html+= `<div class="story-item" title="${story.name}">
                                        <a href="story/${story.slug}" class="d-block text-decoration-none">
                                            <div class="story-item__image">
                                                <img src="${story.image}" alt="${story.name}" class="img-fluid" width="150" height="230" loading="lazy">
                                            </div>
                                            <h3 class="story-item__name text-one-row story-name">${story.name}</h3>
                                            <div class="list-badge">
                                                ${(story.status == 0)?'<span class="story-item__badge badge text-bg-success">Full</span>':''}
                                                ${(story.isHot)?'<span class="story-item__badge story-item__badge-hot badge text-bg-danger">Hot</span>':''}
                                                ${(story.isNew)?'<span class="story-item__badge story-item__badge-new badge text-bg-info text-light">New</span>':''}
                                            </div>
                                        </a>
                                    </div>`;
                            }else{
                                html += `
                                    <div class="story-item-no-image" title="${story.name}">
                                        <div class="story-item-no-image__name d-flex align-items-center">
                                            <h3 class="me-1 mb-0 d-flex align-items-center">
                                                <svg style="width: 10px; margin-right: 5px;"
                                                    xmlns="http://www.w3.org/2000/svg" height="1em"
                                                    viewBox="0 0 320 512">
                                                    <path
                                                        d="M278.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L210.7 256 73.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z">
                                                    </path>
                                                </svg>
                                                <a href="/story/${story.slug}" class="text-decoration-none text-dark fs-6 hover-title text-one-row story-name">${story.name}</a>
                                            </h3>
                                            ${(story.status == 0)?'<span class="badge text-bg-success text-light me-1">Full</span>':''}
                                            ${(story.isHot)?'<span class="badge text-bg-danger text-light me-1">Hot</span>':''}
                                            ${(story.isNew)?'<span class="badge text-bg-info text-light me-1">New</span>':''}
                                        </div>

                                        <div class="story-item-no-image__categories ms-2 d-none d-lg-block">
                                            <p class="mb-0">${addCategory(story.categories)}</p>
                                        </div>

                                        <div class="story-item-no-image__chapters ms-2">
                                            <a href="/listen/${story.slug}/${story.new_chapter.index_chap}" class="hover-title text-decoration-none text-info" title="Chương ${story.new_chapter.index_chap+': '+story.new_chapter.name}(${renderTime(lateDay)})">Chương ${story.new_chapter.index_chap}</a>
                                        </div>
                                    </div>
                                `;
                            }
                        }
                    });
                    list_item.querySelector('#list-item').innerHTML = html;
                    if(!notImg){
                        list_item.querySelector('#list-item').classList.remove('d-none');
                        list_item.querySelector('#lazy-load').classList.add('d-none')
                    }
                }
            }
        });
    }

    $.fn.buildListStory = function() {
        let arg = arguments[0], params = Object.assign(___default, arg.params);
        console.log(params);
        for(let i=0; i<this.length; i++){
            this[i].innerHTML = buildFrame(
                (arg.form_select)?arg.form_select:false,
                (arg.notImg)?arg.notImg:false,
                (arg.lazy_load)?arg.lazy_load:false
            );

            if(this[i].getAttribute('data-list')){
                params.list = this[i].getAttribute('data-list');
            }

            if(arg.notImg){
                addItem(this[i], params, true);
            }else{
                if(arg.lazy_load) this[i].querySelector('#lazy-load').innerHTML = buildLazy();
                if(arg.form_select) {
                    params.categories_id = '*';
                    arg.option_select(this[i].querySelector('#form-select'));
                    this[i].querySelector('#form-select').addEventListener('change', (e) => {
                        if(arg.lazy_load){
                            this[i].querySelector('#list-item').classList.add('d-none');
                            this[i].querySelector('#lazy-load').classList.remove('d-none');
                        }
                        let id = this[i].querySelector('#form-select').value;
                        params.categories_id = (id=='*')?id:Number(id);
                        addItem(this[i],params);
                    });
                }
                addItem(this[i],params);
            }

            this[i].querySelector('#stories-name').innerHTML = this[i].getAttribute('title');
        }
    }

    var ___defaultPagination = {
        pages: 1, active : 1
    };
    function buildInputPagination(box, max){
        box.querySelector('ul').innerHTML += `<div class="dropup-center dropup choose-paginate me-1">
                    <button class="btn btn-success dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">Chọn trang</button>
                    <div class="dropdown-menu">
                        <input type="number" class="form-control input-paginate me-1" value="1" min="1" max="${max}">
                        <button class="btn btn-success btn-go-paginate">Đi</button>
                    </div>
                </div>`;    
    }

    function buildPage(box, page, active = false) {
        box.querySelector('ul').innerHTML += `<li class="pagination__item ${(active)?'page-current':''}" data-page="${page}">
            <a class="page-link story-ajax-paginate">${page}</a>
        </li>`;    
    }

    $.fn.buildPagination = function(){
        let arg = arguments[0], params = Object.assign(___defaultPagination, arg);
        for(let i=0; i<this.length; i++){
            this[i].innerHTML = '<ul></ul>';
            if(params.pages > 1){
                for(let j=0; j<params.pages; j++){
                    buildPage(this[i], j+1, (j == params.active-1));
                }
                buildInputPagination(this[i], params.pages);

                const btnPagination = this[i].querySelectorAll('.pagination__item');
                btnPagination.forEach((btn) =>{
                    btn.addEventListener('click', () =>{
                        params.active = btn.getAttribute('data-page');
                        $('#'+this[i].id+' .pagination__item').removeClass('page-current');
                        btn.classList.add('page-current');
                        arguments[1](params.active);
                    });
                });
                this[i].querySelector('.btn-go-paginate').addEventListener('click', (e)=>{
                    params.active = Number($('.input-paginate').val());
                    $('#'+this[i].id+' .pagination__item').removeClass('page-current');
                    btnPagination.forEach((btn) =>{
                        if(btn.getAttribute('data-page') == params.active) btn.classList.add('page-current');
                    });
                    arguments[1](params.active);
                });
            }
        }
    }
}));


