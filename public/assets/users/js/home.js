$('#list-new-update').buildListStory({
    notImg: true,
    params: {
        max: 16, list: 'new-update', status: '*'
    },
});

$('#list-full').buildListStory({
    lazy_load: true,
    params: {
        max: 16,list: '*', status: 0
    },
});

$('#list-new').buildListStory({
    lazy_load: true,
    params: {
        max: 16, list: 'new', status: '*'
    },
});

$('#list-hot').buildListStory({
    form_select: true, lazy_load: true,
    option_select: function (list_option) {
        $.ajax({
            type: "get",
            url: "/loadCategories",
            data: {},
            success: function (data) {
                let html = '<option value="*" selected>Tất cả</option>';
                data.forEach(category =>{
                    html += `<option value="${category.id}">${category.name}</option>`;
                });
                list_option.innerHTML = html;
            }
        });
    },
    params: {
        max: 16, list: 'hot', status: '*'
    },
});