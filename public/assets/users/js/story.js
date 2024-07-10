$(document).ready(function () {
    // if (route().current('story')) {
        var getUrlParameter = function getUrlParameter(sParam) {
            var sPageURL = window.location.search.substring(1),
                sURLVariables = sPageURL.split('&'),
                sParameterName,
                i;

            for (i = 0; i < sURLVariables.length; i++) {
                sParameterName = sURLVariables[i].split('=');

                if (sParameterName[0] === sParam) {
                    return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
                }
            }
            return false;
        // };

        var page = getUrlParameter('page');
    }

});

var default_params = {
    page: 1, tab: 'top-day'
};
var params = {
    page: 1, tab: 'top-day'
};

if(window.location.hash) {
    let str_hash = window.location.hash.slice(1);
    let arr_params = str_hash.split('&');
    for(let i = 0; i < arr_params.length; i++) arr_params[i] = arr_params[i].split('=');
    let ob =  Object.fromEntries(arr_params);
    params = Object.assign(params, ob)
    if(params.page < 1 || params.page >  $('#pagination').attr('data-pages')) params.page = 1;
}

function click_tab_pane(tab = 'top-day'){
    let ___defaultTab = ['top-day', 'top-month', 'top-all-time'];
    if(!___defaultTab.includes(tab)){
        tab = ___defaultTab[0];
    }
    $('.tab-pane.fade').removeClass(['active', 'show']);
    $('#'+tab).addClass(['active', 'show']);
    $('.list-group-item.list-group-item-action').removeClass('active');
    $('#'+tab+'-list').addClass('active');
    params.tab = tab;
    buildhash();
}

function buildhash(){
    let first = false, hash = '';
    Object.keys(params).forEach(key => {
        if(params[key] != default_params[key]){
            if(first) hash += '&';  
            first = true; hash += key+'='+params[key];
        }
    });
    if(first) window.location.hash = hash;
    else history.replaceState(null, document.title, location.pathname + location.search)
}

function addCategory(categories) {
    let index = 0, html = '';
    categories.forEach(category => {
        html += `<a href="/category/${category.slug}" class="text-decoration-none text-dark hover-title  me-1">
                    ${ ((index > 0)? ', ':'') + category.name}
                </a>`;
        index++;
    });
    return html;
}

function loadStoryTop(id){
    $.ajax({
        type: "get",
        url: "/searchStories",
        data: {
            list: $('#'+id).attr('data-list'), max: 10,
        },
        success: function (data) {
            let top = ['bg-danger', 'bg-success', 'bg-info'];
            if (data.success) {
                let index = 0;
                data.stories.forEach(story =>{
                    var html = `<li>
                                    <div class="rating-item d-flex align-items-center">
                                        <div class="rating-item__number ${(index < 3)?top[index]:'bg-light'} rounded-circle">
                                            <span class="text-light">${index+1}</span>
                                        </div>
                                        <div class="rating-item__story">
                                            <a href="/story/${story.slug}"
                                                class="text-decoration-none hover-title rating-item__story--name text-one-row">${story.name}</a>
                                            <div class="d-flex flex-wrap rating-item__story--categories">
                                                ${addCategory(story.categories)}
                                            </div>
                                        </div>
                                    </div>
                                </li>`;
                    $('#'+id +' ul').append(html);
                    index++;
                });
            }
        }
    });
}

function loadChapters(page = 1) {
    page = Number(page);
    $.ajax({
        type: "get",
        url: "/loadChap",
        data: {
            story: $('#story_slug').val(),
            show: $('#pagination').attr('data-limit'),
            page: page,
        },
        success: function (data) {
            let html = '<div class="col-12 col-sm-12 col-lg-12 story-detail__list-chapter--list__item" id="list-chap-left"><ul></ul></div>';
            if(data.length > 0){
                if(data.length > 25){
                    html = `<div class="col-6 col-sm-6 col-lg-6 story-detail__list-chapter--list__item" id="list-chap-left"><ul></ul></div>
                            <div class="col-6 col-sm-6 col-lg-6 story-detail__list-chapter--list__item" id="list-chap-right"><ul></ul></div>`;
                }
                $('#chapter-full').html(html);
    
                for(let i = 0; i < data.length; i++){
                    let lateDay = (new Date().getTime() - new Date(data[i].updated_at).getTime())/86400000;
                    let item = `<li>
                                    <a href="/listen/${$('#story_slug').val()}/${data[i].index_chap}"
                                        class="text-decoration-none text-dark hover-title">Chương ${data[i].index_chap}: ${data[i].name}(${renderTime(lateDay)})</a>
                                </li>`;
                    if(i < 25){
                        $('#list-chap-left ul').append(item);
                    }else{
                        $('#list-chap-right ul').append(item);
                    }
                }
            }else{
                $('#chapter-full').html(html);
                $('#list-chap-left ul').append(`<li>
                        <a class="text-decoration-none text-dark hover-title">Không có chương truyện</a>
                    </li>`);
            }
        }
    });
}

loadStoryTop('top-day');
loadStoryTop('top-month');
loadStoryTop('top-all-time');
$('#pagination').buildPagination({
    pages: $('#pagination').attr('data-pages'), active: params.page
}, function(page){
    params.page = page;
    if(params.page < 1 || params.page >  $('#pagination').attr('data-pages')) params.page = 1;
    buildhash();
    loadChapters(params.page);
});
loadChapters(params.page);
click_tab_pane(params.tab);
