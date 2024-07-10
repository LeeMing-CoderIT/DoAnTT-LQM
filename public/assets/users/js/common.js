$(document).ready(function () {
    const searchStory = $('.search-story')
    if (searchStory) {
        searchStory.on('keyup', function (e) {
            $('.search-story').val($(this).val());
            const searchResult = $('.search-result')
            const list = searchResult.find('.list-group')

            if ($(this).val().length == 0) {
                if (searchResult) {
                    searchResult.addClass('d-none')
                    searchResult.addClass('no-result')
                    list.addClass('d-none')
                }
            } else {
                $.ajax({
                    type: "get",
                    url: "/searchStories",
                    data: {
                        keywords: $(this).val(), max: 20,
                    },
                    success: function (data) {
                        console.log(data);
                        if (data.success) {
                            if (searchResult) {
                                searchResult.removeClass('d-none')
                                list.empty()
    
                                searchResult.removeClass('no-result')
                                list.removeClass('d-none')

                                if (data.stories.length > 0 && list) {
                                    list.html('');
                                    data.stories.forEach(story => {
                                        list.append(`
                                                <li class="list-group-item">
                                                <a href="/story/${story.slug}" class="text-dark hover-title">${story.name}</a>
                                                </li>
                                            `);
                                    });
                                } else {
                                    list.html(`
                                        <li class="list-group-item border-0">
                                            Không tìm thấy truyện nào 
                                        </li>
                                    `);
                                }
                            }
                        }
                    }
                });
            }
        });
        searchStory.on('change', function (e) {
            $('.search-story').val($(this).val());
            const searchResult = $('.search-result')
            const list = searchResult.find('.list-group')

            if ($(this).val().length == 0) {
                if (searchResult) {
                    searchResult.addClass('d-none')
                    searchResult.addClass('no-result')
                    list.addClass('d-none')
                }
            } else {
                $.ajax({
                    type: "get",
                    url: "/searchStories",
                    data: {
                        'keywords': $(this).val(), max: 8,
                    },
                    success: function (data) {
                        if (data.success) {
                            if (searchResult) {
                                searchResult.removeClass('d-none')
                                list.empty()
    
                                searchResult.removeClass('no-result')
                                list.removeClass('d-none')

                                if (data.stories.length > 0 && list) {
                                    list.html('');
                                    data.stories.forEach(story => {
                                        list.append(`
                                                <li class="list-group-item">
                                                    <a href="/story/${story.slug}" class="text-dark hover-title">${story.name}</a>
                                                </li>
                                            `);
                                    });
                                } else {
                                    list.html(`
                                        <li class="list-group-item border-0">
                                            Không tìm thấy truyện nào 
                                        </li>
                                    `);
                                }
                            }
                        }
                    }
                });
            }
        });
    }
})