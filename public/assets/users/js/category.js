$(document).ready(function () {
    $('#not-stories').addClass('d-none');
    $.ajax({
        type: "get",
        url: "/searchStories",
        data: {
            categories_id: [$('.section-stories-hot__list:not(.wrapper-skeleton)').attr('data-category')], max: 40,
        },
        success: function (data) {
            // console.log(data);
            if (data.success) {
                var html = '';
                data.stories.forEach(story =>{
                    html += `<div class="story-item" title="${story.name}">
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
                $('.section-stories-hot__list:not(.wrapper-skeleton)').html(html);
                $('.section-stories-hot__list').removeClass('d-none')
                $('.section-stories-hot__list.wrapper-skeleton').addClass('d-none');
            }else{
                $('.section-stories-hot__list.wrapper-skeleton').addClass('d-none');
                $('#not-stories').removeClass('d-none');
            }
        }
    });
})