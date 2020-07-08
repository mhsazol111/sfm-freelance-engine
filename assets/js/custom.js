;(function ($) {
    $(document).ready(function () {


        /** OLD JS ======== */

        let mainHeader = $(".smf-header-wrapper");

        $(document).on("scroll", function (e) {
            stickyHeader();
        });

        function stickyHeader() {
            let top = $(document).scrollTop();
            if (top > 50) {
                mainHeader.addClass("sticky-header");
            } else {
                mainHeader.removeClass("sticky-header");
            }
        }

        // darkheader end
        $(".faq_section .angel_content").click(function () {
            $(".faq_section .a_content").slideUp("2000", "swing", function () {
                // Animation complete.
            });

            $(".faq_section .q_head .sub_q").css("opacity", "1");
            $(".faq_section .q_head .icon i.fa-plus").css("display", "block");
            $(".faq_section .q_head .icon i.fa-minus").css("display", "none");
        });

        $(".faq_section .q_head").click(function () {
            $(".faq_section .a_content").slideUp("2000", "swing", function () {
                // Animation complete.
            });

            $(".faq_section .q_head .sub_q").css("opacity", "1");
            $(".faq_section .q_head .icon i.fa-plus").css("display", "block");
            $(".faq_section .q_head .icon i.fa-minus").css("display", "none");

            if ($(this).parent().find(".a_content").css("display") == "none") {
                $(this)
                    .parent()
                    .find(".a_content")
                    .slideDown("2000", "swing", function () {
                        $(this).css({
                            display: "inline-block",
                        });
                    });
                $(this).parent().find("i.fa-plus").css("display", "none");
                $(this).parent().find("i.fa-minus").css("display", "block");

                $(this).find(".sub_q").css("opacity", "0");
            }
        });

        $("#post-control.block-posts #commentform #author").attr(
            "placeholder",
            "Name"
        );
        $("#post-control.block-posts #commentform #email").attr(
            "placeholder",
            "Enter your valid email"
        );
        $("#post-control.block-posts #commentform #url").attr(
            "placeholder",
            "Website"
        );
        $("#post-control.block-posts #commentform #comment").attr(
            "placeholder",
            "Your Comment.."
        );

        $("#post-control.block-posts #commentform .comment-form-author").append(
            '<i class="fa fa-user"></i>'
        );
        $("#post-control.block-posts #commentform .comment-form-email").append(
            '<i class="fa fa-envelope"></i>'
        );
        $("#post-control.block-posts #commentform .comment-form-url").append(
            '<i class="fa fa-globe"></i>'
        );
        $("#post-control.block-posts #commentform .form-submit").append(
            '<i class="fa fa-send"></i>'
        );
        //$("#post-control.block-posts #commentform #submit").val("");

        $("#post-control.block-posts #commentform input").on(
            "focusin",
            function () {
                $(this).parent().find("i").css("color", "#2f9bca");
            }
        );
        $("#post-control.block-posts #commentform input").on(
            "focusout",
            function () {
                $(this).parent().find("i").css("color", "#999999");
            }
        );

        $(".registration_shortcode .right_area .terms_conditions input").click(
            function () {
                if ($(this).is(":checked")) {
                    $(
                        ".registration_shortcode .right_area .terms_conditions .checkmark"
                    ).addClass("check_y");
                } else {
                    $(
                        ".registration_shortcode .right_area .terms_conditions .checkmark"
                    ).removeClass("check_y");
                }
            }
        );

        $(".registration_shortcode .right_area #confirm_user_password-340").attr(
            "placeholder",
            "Confirm your password"
        );

        // owl carousel start
        $("#news-slider").owlCarousel({
            loop: true,
            margin: 30,
            items: 3,
            nav: true,
            navText: [
                '<img src="'+ajaxObject.site_root+'/wp-content/themes/sfm-child/inc/images/slider_arrow_left.svg" alt="arrow left">',
                '<img src="'+ajaxObject.site_root+'/wp-content/themes/sfm-child/inc/images/slider_arrow_right.svg" alt="arrow right">',
            ],
            dots: false,
            responsive: {
                0: {
                    items: 1,
                },
                500: {
                    items: 2,
                },
                767: {
                    items: 3,
                },
                1000: {
                    items: 3,
                },
            },
        });

        // owl carousel end

        // Smooth Scroll to Div
        $(function () {
            $("a[href*=\\#]:not([href=\\#])").on("click", function () {
                var target = $(this.hash);
                target = target.length
                    ? target
                    : $("[name=" + this.hash.substr(1) + "]");
                if (target.length) {
                    $("html,body").animate(
                        {
                            scrollTop: target.offset().top,
                        },
                        1000
                    );
                    return false;
                }
            });
        });


        // tinyMCE.init({
        //     mode: "specific_textareas",
        //     theme: "freelanceengine-child",
        //     /*plugins : "autolink, lists, spellchecker, style, layer, table, advhr, advimage, advlink, emotions, iespell, inlinepopups, insertdatetime, preview, media, searchreplace, print, contextmenu, paste, directionality, fullscreen, noneditable, visualchars, nonbreaking, xhtmlxtras, template",*/
        //     editor_selector: "tinymce-enabled",
        // });
        /** OLD JS ======== */


        // Portfolio Magnific Images
        let popupContainer = $(".fpp-portfolio-wrap");
        if (popupContainer.length > 0) {
            popupContainer.magnificPopup({
                delegate: ".fpp-lightbox-image",
                type: "image",
                gallery: {enabled: true},
                image: {
                    verticalFit: false
                },
                zoom: {
                    enabled: true,
                    duration: 400,
                    easing: "ease-in-out",
                    opener: function (openerElement) {
                        return openerElement;
                    }
                }
            });
        }

        // Dashboard Sidebar
        $(".hamburger-menu-dashbord").click(function () {
            $(".profile_dashboard").toggleClass("sidebar-close");
        });

        // Archive Project
        $('#employer-archive').on('click', function (e) {
            e.preventDefault();
            $( 'body' ).addClass( 'modal-open' );
            $('#modal_archive_project').modal('show');
        });
        
        // Delete Project
        $('#employer-delete').on('click', function (e) {
            e.preventDefault();
            $( 'body' ).addClass( 'modal-open' );
            $('#modal_delete_project').modal('show');
        });

        // Single Bid Hire Modal
        $('.btn-accept-bid-no-escrow').on('click', function (e) {
            e.preventDefault();
            $( 'body' ).addClass( 'modal-open' );
            $('#accept-bid-no-escrow').modal('show');
        });


    }); // Document Ready
})(jQuery);