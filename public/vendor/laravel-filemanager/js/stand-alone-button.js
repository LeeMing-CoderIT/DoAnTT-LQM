(function( $ ){

  $.fn.filemanager = function(type, options) {
    type = type || 'file';

    this.on('click', function(e) {
      var route_prefix = (options && options.prefix) ? options.prefix : '/filemanager';
      var target_input = $('#' + $(this).data('input'));
      var target_preview = $('#' + $(this).data('preview'));
      window.open(route_prefix + '?type=' + type, 'FileManager', 'width=900,height=600');
      window.SetUrl = function (items) {
        var file_path = items.map(function (item) {
          return item.url;
        }).join(',');

        // set the value of the desired input to image url
        target_input.val('').val(file_path).trigger('change');

        // clear previous preview
        target_preview.html('');
        pixel_avatar = {};
        if(target_preview[0].dataset.width){
          pixel_avatar.width = target_preview[0].dataset.width;
        }
        if(target_preview[0].dataset.height){
          pixel_avatar.height = target_preview[0].dataset.height;
        }
        if(target_preview[0].dataset.circle){
          pixel_avatar['border-radius'] = target_preview[0].dataset.circle;
        }
        // console.log(pixel_avatar);
        // set or change the preview image src
        items.forEach(function (item) {
          target_preview.append(
            $('<img>').css(pixel_avatar).attr('src', item.thumb_url)
          );
        });

        // trigger change event
        target_preview.trigger('change');
      };
      return false;
    });
  }

})(jQuery);
