;(function ($) {
    $(document).ready(function () {
        $('body').on('click', '.pending-user-action', function (e) {
            e.preventDefault();
            let userId = $(this).data('user_id'),
                actionType = $(this).data('action');

            $.ajax({
                method: "POST",
                url: ajaxObject.ajaxUrl,
                // contentType: false,
                // processData: false,
                data: {
                    action: 'handle_pending_user_action',
                    userId,
                    actionType,
                },
                beforeSend: function () {
                    $("body").append(
                        '<div id="loader-wrapper"><div class="loader"></div></div>'
                    );
                },
                success: function (res) {
                    console.log(res);
                    $("#loader-wrapper").remove();

                    if (res.success === false) {
                        alert(res.message);
                    }
                    if (res.success === true) {
                        console.log(res.message);
                        window.location.replace(res.redirect);
                    }
                },
                error: function (err) {
                    $("#loader-wrapper").remove();
                    console.log(err);
                },
            });

        });
    });
})(jQuery);