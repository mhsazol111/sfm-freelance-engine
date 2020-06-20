jQuery(document).ready(function ($) {
    var liveChatting;
    var activeItem = $('.la_message_inn').find('.laSidebarMessage.active');
    if (activeItem.length) {
        var project_id = activeItem.data('project');
        var author = activeItem.data('author');
        if ('' !== project_id && '' !== author) {
            // Un-bold text
            activeItem.removeClass('strong');
            la_get_message_item(project_id, author);
            liveChatting = setInterval(function () {
                la_get_unread_item(project_id, author);
            }, 10000);
        }
    }
    $('.laSidebarMessage').on('click', function (e) {
        e.preventDefault();
        $('.laSidebarMessage').removeClass('active');
        $('.laSidebarMessage').parent().removeClass('active');
        $(this).addClass('active');
        $(this).parent().addClass('active');
        var project_id = $(this).data('project');
        var author = $(this).data('author');
        la_get_message_item(project_id, author);
        // Un-bold text
        $(this).removeClass('strong');
        clearInterval(liveChatting);
        liveChatting = setInterval(function () {
            la_get_unread_item(project_id, author);
        }, 10000);
    });
    $('#la_message_reply_form').on('submit', function (e) {
        e.preventDefault();
        var form = document.getElementById('la_message_reply_form');
        la_submit_message_form(form);
        $('[name="reply_message"]').val('');
    });
    // Reload window in mobile<>desktop if this is message page
    var currentWidth = $(window).width();
    $(window).resize(function (e) {
        var isMessagePage = $('body').hasClass('private-messages');
        if (isMessagePage) {
            if (currentWidth <= 600 && $(window).width() >= 600) {
                window.location.reload();
            }
            if (currentWidth >= 600 && $(window).width() <= 600) {
                window.location.reload();
            }
        }
    });
});

// Get message item
function la_get_message_item(project_id, author) {
    if ('' == project_id || '' == author) {
        return false;
    } else {
        jQuery('input[name="project_id"]').val(project_id);
        jQuery('input[name="author_id"]').val(author);

        var formData = new FormData();
        formData.append('action', 'get_inquiry_message_items');
        formData.append('project_id', project_id);
        formData.append('author_id', author);
        formData.append('reply_nonce', jQuery('#reply_nonce').val());
        jQuery.ajax({
            url: pmObj.ajax_url,
            type: 'post',
            dataType: 'html',
            data: formData,
            contentType: false,
            processData: false,
            success: function (res) {
                var ajaxContainer = jQuery('#la_message_ajax_container');
                ajaxContainer.html(res);
                ajaxContainer.removeClass('la_is_loading');
                // Append to that item only on mobile
                if (jQuery(window).width() <= 600) {
                    //console.log("Mobile click");
                    var target_li = jQuery('.laSidebarMessage.active').parent();
                    jQuery('.la_author_messages').appendTo(target_li);
                    var msg_cont = jQuery('.la_messages_container');
                    jQuery('#la_message_ajax_container').animate({scrollTop: msg_cont[0].scrollHeight}, 1000);
                }
                la_scroll_message_container_to_bottom();

            },
            error: function (er) {
                console.log('Something is going wrong!');
            }
        });
    }
}

// Get Unread Message
function la_get_unread_item(project_id, author) {
    if ('' == project_id || '' == author) {
        return false;
    } else {
        jQuery('input[name="project_id"]').val(project_id);
        jQuery('input[name="author_id"]').val(author);

        var formData = new FormData();
        formData.append('action', 'get_live_messages');
        formData.append('project_id', project_id);
        formData.append('author_id', author);
        formData.append('reply_nonce', jQuery('#reply_nonce').val());
        jQuery.ajax({
            url: pmObj.ajax_url,
            type: 'post',
            dataType: 'html',
            data: formData,
            contentType: false,
            processData: false,
            success: function (res) {
                if (res) {
                    var cont = jQuery('#la_project_' + project_id + '_' + author);
                    if (cont.length) {
                        cont.append(res);
                        la_scroll_message_container_to_bottom();
                    }
                }
            },
            error: function (er) {
                console.log('Something is going wrong!');
            }
        });
    }
}

// Submit message reply form
function la_submit_message_form(form) {
    var formData = new FormData(form);
    formData.append('action', 'la_submit_reply_message');
    if ('' == formData.getAll('reply_message')) {
        alert('Please type a message!');
    } else {
        jQuery('.reply_button').attr('disabled', true);
        jQuery.ajax({
            url: pmObj.ajax_url,
            method: 'post',
            dataType: 'json',
            data: formData,
            contentType: false,
            processData: false,
            success: function (res) {
                jQuery('#la_reply_msg').val('');
                la_get_message_item(res.project_id, res.author);
                la_scroll_message_container_to_bottom();
                jQuery('.reply_button').attr('disabled', false);
            },
            error: function (er) {
                console.log('Something is going wrong!');
            }
        });
    }
}

// Scroll Message container to bottom
function la_scroll_message_container_to_bottom() {
    var msg_container = jQuery('.la_messages_container');
    msg_container.scrollTop(msg_container[0].scrollHeight);
}