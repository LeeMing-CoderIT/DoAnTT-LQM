var default_params = {
    list: 'new-update', status: '*', keywords: '', categories_id: [], chaps: [], max: 40, page: 1
};
var params = {
    list: 'new-update', status: '*', keywords: '', categories_id: [], chaps: [], max: 40, page: 1
};


if(window.location.search){
    let str_hash = window.location.search.slice(1);
    let arr_params = str_hash.split('&');
    for(let i = 0; i < arr_params.length; i++) arr_params[i] = arr_params[i].split('=');
    let ob =  Object.fromEntries(arr_params);
    params = Object.assign(params, ob)
    $('#text-search').val(params.keywords);
}

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
    params.keywords = decodeURIComponent(params.keywords);
    $('#list-filter').val(params.list);
    $('#status-filter').val(params.status);
    $('#text-search').val(params.keywords);
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

function loadStories(params) {
    $('#loading-stories').show();
    $('#not-stories').addClass('d-none');
    $('#list-item').addClass('d-none')
    $('#lazy-load').removeClass('d-none');
    $.ajax({
        type: "get",
        url: "/searchStories",
        data: params,
        success: function (data) {
            if (data.success) {
                $('#pagination').attr('data-pages', data.pages)
                var html = '';
                if(data.stories.length > 0){
                    data.stories.forEach(story =>{
                        html += `<div class="story-item" title="${story.name}(${story.author})">
                                        <a href="/story/${story.slug}" class="d-block text-decoration-none">
                                            <div class="story-item__image">
                                                <img src="${story.image}" alt="${story.name}"
                                                    class="img-fluid" width="150" height="230" loading="lazy">
                                            </div>
                                            <h3 class="story-item__name text-one-row story-name">${story.name}</h3>
                                            <div class="list-badge">
                                            ${(story.status == 0)?'<span class="story-item__badge story-item__badge-new badge text-bg-success text-light">Full</span>':''}
                                            ${(story.isHot)?'<span class="story-item__badge story-item__badge-new badge text-bg-danger text-light">Hot</span>':''}
                                            ${(story.isNew)?'<span class="story-item__badge story-item__badge-new badge text-bg-info text-light">New</span>':''}
                                            </div>
                                        </a>
                                    </div>`;
                    });
                }else{
                    $('#not-stories').show();
                }
                $('#list-item').html(html);
                $('#list-item').removeClass('d-none')
                $('#lazy-load').addClass('d-none');
                $('#loading-stories').hide();
                buildhash();

                $('#pagination').buildPagination({
                    pages: $('#pagination').attr('data-pages'), active: params.page
                }, function(page){
                    params.page = page;
                    if(params.page < 1 || params.page > Number($('#pagination').attr('data-pages'))) params.page = 1;
                    loadStories(params);
                });
            }else{
                $('#lazy-load').addClass('d-none');
                $('#loading-stories').hide();
                buildhash();
                $('#not-stories').removeClass('d-none');
            }
        }
    });
}

$('#list-filter').change(function (e) { 
    e.preventDefault();
    params.list = $(this).val();
    let keywords = $('#text-search').val();
    params.keywords = keywords;
    params.page = default_params.page;
    loadStories(params);
});

$('#status-filter').change(function (e) { 
    e.preventDefault();
    params.status = $(this).val();
    let keywords = $('#text-search').val();
    params.keywords = keywords;
    params.page = default_params.page;
    loadStories(params);
});

$('#btn-load-search').click(function (e) { 
    e.preventDefault();
    let keywords = $('#text-search').val();
    params.keywords = keywords;
    params.page = default_params.page;
    loadStories(params);
});

$('#text-search').keydown(function (e) { 
    if(e.originalEvent.key == 'Enter'){
        $('#btn-load-search').click();
    }
});


const listCategory = document.querySelectorAll('.category-item');
function activeCategory(){
    let arr = [];
    listCategory.forEach((btn)=>{
        if(btn.classList.contains('active')) arr.push(Number(btn.getAttribute('data-id')));
    });
    return arr;
}
listCategory.forEach((item) =>{
    if(params.categories_id.includes(Number(item.getAttribute('data-id')))) item.classList.add('active');
    item.addEventListener('click', (e) =>{
        if(item.classList.contains('active')) item.classList.remove('active');
        else {
            if(activeCategory().length < 4) item.classList.add('active');
        }
        params.categories_id = activeCategory();
        params.page = default_params.page;
        loadStories(params);
    });
});

const listChaps = document.querySelectorAll('.chaps-item');
listChaps.forEach((item) =>{
    if(item.getAttribute('data-at') == params.chaps.join('-')) item.classList.add('active');
    item.addEventListener('click', (e) =>{
        let to_from = item.getAttribute('data-at');
        if(item.classList.contains('active')){
            item.classList.remove('active');
            params.chaps = [];
        }
        else {
            $('.chaps-item').removeClass('active');
            item.classList.add('active');
            params.chaps = to_from.split('-').map(x=>Number(x));
        }
        params.page = default_params.page;
        loadStories(params);
    });
});

const listChapsHeader = document.querySelectorAll('.chaps-item-header');
listChapsHeader.forEach((item) =>{
    item.addEventListener('click', (e) =>{
        let to_from = item.getAttribute('data-at');
        params.chaps = to_from.split('-').map(x=>Number(x));
        loadStories(params);
    });
});

loadStories(params);