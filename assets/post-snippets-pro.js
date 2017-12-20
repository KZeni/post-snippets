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
            var order = $('.post-snippets').sortable("toArray",{option:"sort", attribute:"data-order"});
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
        var key = $('.post-snippets-item').length + 1;
        var title = item.find('input.post-snippet-title').val();
        var duplicate = item.clone(true);
        duplicate.data('order', key);
        duplicate.attr('id', 'key-'+key);
        duplicate.find('input.post-snippet-title').attr('title', key + '_title');
        duplicate.find('input.post-snippet-title').val(title + '-duplicate-' + key);
        duplicate.find('span.post-snippet-title').text(title + '-duplicate-' + key);
        duplicate.appendTo('.post-snippets');
        var offset = $('.post-snippets-item:last-child').offset().top;
        $('html, body').animate({scrollTop: offset}, 500);

        return false;
    });


});
