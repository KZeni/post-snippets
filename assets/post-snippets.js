jQuery(document).ready(function ($) {
    /**
     * Loops through all snippets when page has loaded.
     */
    $("input[name$='_title']").each(function (index) {
        validateTitle($(this).prop('name'));
    });

    /**
     * Listens for title text input change events.
     */
    $("input[name$='_title']").change(function (e) {
        validateTitle(e.target.name);
    });

    /**
     * Listens for shortcode checkbox change events.
     */
    $("input[name$='_shortcode']").change(function (e) {
        validateTitle(e.target.name);
    });

    /**
     * Handle title validation and managing CSS classes.
     *
     * @param  string name
     *
     * @return void
     */
    function validateTitle(name) {
        // Extract the snippet index number
        var index = name.substring(0, name.indexOf('_'));

        var element = $("input[name$='" + index + "_title']");
        var title = $("input[name$='" + index + "_title']").val();
        $(element).removeClass('post-snippets-invalid');
        $(element).next().remove('p');

        if ($('#' + index + '_shortcode').prop('checked') && !isTitleValid(title)) {
            $(element).addClass('post-snippets-invalid');
            $(element).after("<span><em><font color='red'>" + post_snippets.invalid_shortcode + "</font></em></span>");
        }
    }

    /**
     * Determine if a title is shortcode valid.
     *
     * @param  string  title
     *
     * @return boolean
     */
    function isTitleValid(title) {
        return !Boolean(title.match(/[<>&/\[\]\x00-\x20]/gi));
    }

    /**
     * Bulk check/uncheck
     */
    $('.check-column input').on('change', function () {
       if( $(this).is(":checked") ){
            $('.post-snippets-item input[name^="checked"]').each(function(){
                $(this).attr('checked', true);
            });
       }else{
           $('.post-snippets-item input[name^="checked"]').each(function(){
               $(this).attr('checked', false);
           });
       }
    });
    /**
     * Update title real time
     */
    $('input.post-snippet-title').on('keyup', function () {
        var val = $(this).val();
        $(this).closest('.post-snippets-item').find('span.post-snippet-title').text(val);
    });

    /**
     * toggle folding
     */
    $('.toggle-post-snippets-data').on('click', function () {
        var item = $(this).closest('.post-snippets-item');
        var openItems = getFromLocalStorage();
        var key = parseInt(item.data('order'));
        if( _.contains(openItems, key) ){
            setInLocalStorage(_.without(openItems, key));
        }else{
            setInLocalStorage(_.union(openItems, [key]));
        }
        $(this).closest('.post-snippets-item').toggleClass('open');

        // $(this).closest('.post-snippets-item').toggleClass('open');
        return false;
    });
    /**
     * Save title on the go
     */
    $('.save-title').on('click', function () {
        var wrap = $(this).closest('.post-snippets-item');
        var key = wrap.data('order');
        var title = wrap.find('input.post-snippet-title').val().trim();

        if (key === undefined) {
            alert('something went wrong try again');
            return false;
        }
        if ((title === undefined) || title === '') {
            alert('Invalid Title');
            return false;
        }
        var data = {
            'action': 'update_post_snippet_title',
            'key': key,
            'title': title
        };
        $.post(ajaxurl, data, function (res) {
            wrap.toggleClass('edit');
        });
        return false;
    });

    /**
     * toggle edit title mode
     */
    $('.post-snippets-toolbar .edit-title').on('click', function () {
        $(this).closest('.post-snippets-item').toggleClass('edit');
        return false;
    });
    /**
     * Make shortable list
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
     * Set value in localStorage
     * @param value
     * @param name
     */
    function setInLocalStorage(value, name) {
      var optionName = name || 'openSnippets';
      localStorage.setItem(optionName, JSON.stringify(value));
    }

    /**
     * get saved value
     * @param name
     * @returns {Array}
     */
    function getFromLocalStorage(name) {
        var optionName = name || 'openSnippets';
        var savedValue  = localStorage.getItem(optionName);
        if(savedValue !== null){
            return JSON.parse(savedValue);
        }
        return [];
    }

    /**
     * handle open close
     */
    $('.post-snippets .post-snippets-item').each(function () {
       var key = $(this).data('order');
       var openSnippets = getFromLocalStorage();
       if( _.contains(openSnippets, key) ){
           $(this).addClass('open');
       }
    });

    /**
     * Handle Expand Collapse
     */
    $('.expand-collapse a').on('click', function () {
        var isExpand = ! $('.expand-collapse').hasClass('expanded');
        if( isExpand ){
            $('.post-snippets-item').not('.open').find('.toggle-post-snippets-data').trigger('click');
        }else{
            $('.post-snippets-item.open').find('.toggle-post-snippets-data').trigger('click');
        }
        $('.expand-collapse').toggleClass('expanded');
        return false;
    });

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
