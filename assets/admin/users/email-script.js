;(function ($) {
    $(document).ready(function () {

        var $elm = $('.sfm-admin-ea-body .check-column input');
        $('body').on('change', $elm, function (e) {
            if ($('.sfm-admin-ea-body .check-column input:checked').length > 0) {
                $('.send-button-wrap').fadeIn();
            } else {
                $('.send-button-wrap').fadeOut();
            }
        })
            .on('click', '.sfm-admin-ea-nav li a', function (e) {
                e.preventDefault();
                $('.sfm-admin-ea-nav li a').removeClass('current');
                $(this).addClass('current');
                $('.send-button-wrap').fadeOut();
                var type = $(this).data('type');
                user_table_ajax_render({role: type});
            })
            .on('submit', '#sfm-admin-user-search', function (e) {
                e.preventDefault();
                $('.sfm-admin-ea-nav li a').removeClass('current');
                $('.sfm-admin-ea-nav li a').first().addClass('current');
                var search = $('#sfm_user_search').val();
                $('.send-button-wrap').fadeOut();
                user_table_ajax_render({search: search});
            })
            .on('submit', '#sfm-admin-mail-form', function (e) {
                e.preventDefault();
                var userIds = [];
                $(':checkbox:checked').each(function (i) {
                    userIds[i] = $(this).val();
                });

                $('#selected_user_ids').val(userIds);
                $('#email-popup-wrap').addClass('active');
            })
            .on('submit', '#sfm-user-mail-form', function (e) {
                e.preventDefault();

                // Fix content not changing issue when in html mode
                if ($('#wp-user_email_message-wrap').hasClass('html-active')) {
                    $('#user_email_message-tmce').click();
                    $('#user_email_message-html').click();
                }

                // var content = tinyMCE.activeEditor.getContent();
                var userIds = $('#selected_user_ids').val(),
                    mailFrom = $('#from_email').val(),
                    mailSubject = $('#email_subject').val(),
                    mailContent = tinyMCE.get('user_email_message').getContent();

                if (!userIds || !mailFrom || !mailSubject || !mailContent) {
                    alert('Please fill everything first!')
                    return;
                }

                $.ajax({
                    method: 'POST',
                    url: ajaxObject.ajaxUrl,
                    data: {
                        action: 'handle_multiple_user_email',
                        nonce: $('#email_user_nonce_field').val(),
                        email: {mailFrom, mailSubject, mailContent, userIds}
                    },
                    beforeSend: function () {
                        $("body").append('<div id="loader-wrapper"><div class="loader"></div></div>');
                    },
                    success: function (res) {
                        $("#loader-wrapper").remove();
                        if (res.success === false) {
                            alert('Something went wrong! Please, try again.');
                        }
                        window.location.reload();
                    },
                    error: function (err) {
                        console.log(err);
                    }
                });

            })
            .on('click', '#email-popup-close', function (e) {
                e.preventDefault();
                $('#email-popup-wrap').removeClass('active');
                $('#sfm-user-mail-form')[0].reset();
            })
            .on('click', '.custom-screen-option #screen-meta-links', function (e) {
                $('.custom-screen-option').toggleClass('active');
            })
            .on('submit', '#cso-save-form', function (e) {
                e.preventDefault();
                var checkboxValues = $('.cso-input input:checked').map(function () {
                    return $(this).val();
                }).get();

                $.ajax({
                    method: 'POST',
                    url: ajaxObject.ajaxUrl,
                    data: {
                        action: 'handle_cso_column',
                        values: checkboxValues,
                    },
                    beforeSend: function () {
                        $("body").append('<div id="loader-wrapper"><div class="loader"></div></div>');
                    },
                    success: function (res) {
                        $("#loader-wrapper").remove();
                        if (res.success === false) {
                            alert('Something went wrong! Please, try again.');
                        }
                        window.location.reload();
                    },
                    error: function (err) {
                        console.log(err);
                    }
                });
            });

        function user_table_ajax_render(inputData) {
            $.ajax({
                method: 'POST',
                url: ajaxObject.ajaxUrl,
                data: {
                    action: 'handle_render_user_list_type',
                    inputData,
                },
                beforeSend: function () {
                    $("body").append('<div id="loader-wrapper"><div class="loader"></div></div>');
                },
                success: function (res) {
                    $('#sfm-admin-mail-form #the-list').html(res);
                    $("#loader-wrapper").remove();
                    // window.history.pushState({}, "", 'users.php?page=mass_email_to_users&role=' + type);
                },
                error: function (err) {
                    console.log(err);
                }
            });
        }

    });
})(jQuery);