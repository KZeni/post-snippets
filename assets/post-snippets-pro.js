jQuery(document).ready(function ($) {
    /**
     * Make sortable list
     */
    $(".post-snippets").sortable({
        handle: ".handle",
        items: ".post-snippets-item",
        placeholder: "dashed-placeholder",
        forcePlaceholderSize: true,
        update: function () {
            var order = $('.post-snippets-wrap .post-snippets').sortable("toArray",{option:"sort", attribute:"data-order"});
            var data = {
                'action': 'update_post_snippets_order',
                'order': order
            };
            $.post(ajaxurl,data,function (res) {
            });
        },
        start: function( event, ui ) {
            ui.placeholder.height(ui.item.height());
        }
    });
    $(".post-snippets").disableSelection();

    /**
     * Duplicate snippet
     */
    $('.snippet-duplicate').on('click', function () {
        var item = $(this).closest('.post-snippets-item');
        var newKey = Math.floor(Math.random() * (1000 - 900 + 1) + 900);

        var title = item.find('input.post-snippet-title').val();
        var duplicate = item.clone(true);
        duplicate.attr('data-order', newKey);
        duplicate.attr('id', 'key-'+newKey);
        duplicate.find('input.post-snippet-title').attr('title', newKey + '_title');
        duplicate.find('input.post-snippet-title').val(title + '-duplicate-' + newKey);
        duplicate.find('span.post-snippet-title').text(title + '-duplicate-' + newKey);
        duplicate.appendTo('.post-snippets-wrap .post-snippets-list');
        var offset = $('.post-snippets-item:last-child').offset().top;
        duplicate.find('input,textarea').each(function () {
           var name = $(this).attr('name').replace(/^snippets\[[0-9]\]/gm, 'snippets['+newKey+']');
           $(this).attr('name', name);
           $(this).attr('id', name);
        });

        $('html, body').animate({scrollTop: offset}, 500);

        return false;
    });


});
