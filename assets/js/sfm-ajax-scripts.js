(function ($) {
    $(document).ready(function () {

        if ($('.sfm-select2').length) {
            $('.sfm-select2').select2({
                width: '100%',
                // allowClear: true
            });

            $('.sfm-select2').on("select2:select", function (e) {
                let data = e.params.data.text;
                if (data == 'Select All') {
                    console.log($(this).children('option'));
                    $(this).children('option').prop("selected", "selected");
                    $(this).children('option:first').prop("selected", false);
                    $(this).trigger("change");
                }
            });
        }

        if ($('.budget-select2').length) {
            $('.budget-select2').select2({
                tags: true
            });
        }


        // Employer my projects + Freelancer my projects
        $("body")
            .on("submit", "#my-project-search-form", function (e) {
                e.preventDefault();
                let formData = new FormData(this);
                formData.append("page", 1);
                formData.append("currentUserId", ajaxObject.currentUserId);

                let actionType = $("#filter-items-row").data("project-holder");
                if (actionType === "freelancer") {
                    formData.append("action", "sfm_get_freelancer_own_projects");
                } else {
                    formData.append("action", "sfm_get_employer_own_projects");
                }

                // Ajax Callback
                getFilteredItems(formData);
            })
            .on("click", "#filter-items-row li.project-filter", function (e) {
                e.preventDefault();

                if ($(this).hasClass("active")) return false;

                let status = $(this).data("status");
                $("#project-status").val(status);

                $("#filter-items-row li.project-filter").removeClass("active");
                $(this).addClass("active");

                $("#my-project-search-form").submit();
            })
            .on(
                "click", ".my-projects-wrapper .sfm-pagination ul li .page-numbers", function (e) {
                    e.preventDefault();

                    let formData = new FormData($("#my-project-search-form")[0]);
                    formData.append("currentUserId", ajaxObject.currentUserId);

                    let actionType = $("#filter-items-row").data("project-holder");
                    if (actionType === "freelancer") {
                        formData.append("action", "sfm_get_freelancer_own_projects");
                    } else {
                        formData.append("action", "sfm_get_employer_own_projects");
                    }

                    // Ajax Callback
                    filteredAjaxPagination($(this), formData);
                }
            );

        // Browse Project Ajax
        $("body")
            .on("submit", "#browse-project-form", function (e) {
                e.preventDefault();

                let formData = new FormData(this);
                formData.append("action", "sfm_browse_all_projects");
                formData.append("page", 1);

                getFilteredItems(formData);
            })
            .on("change", "#browse-project-form .custom-select", function (e) {
                $("#browse-project-form").submit();
            })
            .on("click", "#clear-browse-form", function (e) {
                e.preventDefault();
                $("#browse-project-form")[0].reset();
                $('#project-skill').val($('#project-skill option:eq(0)').val()).trigger('change');
                $('#project-category').val($('#project-category option:eq(0)').val()).trigger('change');
                $('#project-country').val($('#project-country option:eq(0)').val()).trigger('change');

                $("#browse-project-form").submit();
            })
            .on( "click", ".browse-project-wrapper .sfm-pagination ul li .page-numbers", function (e) {
                    e.preventDefault();

                    let formData = new FormData($("#browse-project-form")[0]);
                    formData.append("action", "sfm_browse_all_projects");

                    // Ajax Callback
                    filteredAjaxPagination($(this), formData);
                }
            );

        // Browse Freelancer Ajax Start
        $("body")
            .on("submit", "#browse-freelancer-form", function (e) {
                e.preventDefault();

                let formData = new FormData(this);
                formData.append("action", "sfm_browse_freelancer");
                formData.append("page", 1);

                getFilteredItems(formData);
            })
            .on("change", "#browse-freelancer-form .custom-select", function (e) {
                $("#browse-freelancer-form").submit();
            })
            .on("click", "#clear-freelancer-form", function (e) {
                e.preventDefault();
                $("#browse-freelancer-form")[0].reset();
                $('#freelancer-skill').val($('#freelancer-skill option:eq(0)').val()).trigger('change');
                $('#freelancer-country').val($('#freelancer-country option:eq(0)').val()).trigger('change');

                $("#browse-freelancer-form").submit();
            }).on("click", ".browse-freelancer-wrapper .sfm-pagination ul li .page-numbers", function (e) {
                e.preventDefault();

                let formData = new FormData($("#browse-freelancer-form")[0]);
                formData.append("action", "sfm_browse_freelancer");

                // Ajax Callback
                filteredAjaxPagination($(this), formData);
            }
        );


        /**
         * Returns html of filtered projects
         * @param formData
         */
        function getFilteredItems(formData) {
            let wrapper = $("#projects-wrapper");

            $.ajax({
                method: "POST",
                url: ajaxObject.ajaxUrl,
                contentType: false,
                processData: false,
                data: formData,
                beforeSend: function () {
                    $("body").append(
                        '<div id="loader-wrapper"><div class="loader"></div></div>'
                    );
                },
                success: function (res) {
                    wrapper.html(res);
                    $("#loader-wrapper").remove();
                },
                error: function (err) {
                    $("#loader-wrapper").remove();
                    new Noty({
                        theme: "nest",
                        type: "error",
                        timeout: 3000,
                        progressBar: true,
                        text: "Something went wrong!",
                    }).show();
                },
            });
        }

        /**
         * Pagination Ajax Callback
         * @param item
         * @param formData
         * @returns {boolean}
         */
        function filteredAjaxPagination(item, formData) {
            let intendedPage = item;

            // If this is not an actual page, then quit
            if (intendedPage.hasClass("current") || intendedPage.hasClass("dots"))
                return false;

            let intendedPageNumber = intendedPage.text();
            let currentPage = $(".sfm-pagination")
                .find(".page-numbers.current")
                .text();

            if (intendedPage.hasClass("prev")) {
                // prev page number
                intendedPageNumber = parseInt(currentPage) - 1;
            }
            if (intendedPage.hasClass("next")) {
                // next page number
                intendedPageNumber = parseInt(currentPage) + 1;
            }

            //Call Ajax
            formData.append("page", intendedPageNumber);
            getFilteredItems(formData);
        }

        // Fix rating star after ajax
        $(document).on('ajaxComplete', function (e) {
            $('body .rate-it').raty({
                readOnly: true,
                half: true,
                score: function () {
                    return $(this).attr('data-score');
                },
                hints: raty.hint
            });
        })

        // Check form validation with jquery validate
        $(".validation-enabled").validate({
            rules: {
                user_email: {
                    required: true,
                    email: true,
                },
                post_content: {
                    required: true,
                },
            },
            // showErrors: function(errorMap, errorList) {
            //     return $.each(errorList, function(index, value) {
            //         new Noty({
            //             theme: 'nest',
            //             type: 'error',
            //             timeout: 2000,
            //             progressBar: true,
            //             text: value.message,
            //         }).show();
            //     });
            // }
        });

        // Employer edit profile submit
        $(document).on("submit", "#freelancer-profile-edit-form", function (e) {
            e.preventDefault();

            let formData = new FormData(this);
            formData.append(
                "profile_image",
                $('input[name="profile_image"]')[0].files[0]
            );
            formData.append("action", "sfm_update_freelancer_profile");
            formData.append("currentUserId", ajaxObject.currentUserId);

            sfmAjaxFormSubmit(formData);
        });

        // Freelancer edit profile submit
        $(document).on("submit", "#employer-profile-edit-form", function (e) {
            e.preventDefault();

            let formData = new FormData(this);
            formData.append(
                "profile_image",
                $('input[name="profile_image"]')[0].files[0]
            );
            formData.append("action", "sfm_update_employer_profile");
            formData.append("currentUserId", ajaxObject.currentUserId);

            sfmAjaxFormSubmit(formData);
        });

        // Sign up modal
        $(document).on("submit", "#sfm_sign_up_form", function (e) {
            e.preventDefault();
            if ($(this).valid()) {
                $("#signup_modal").modal("show");
            }
        });

        // sign up ajax
        $("#accept_signup_modal").on("click", function (e) {
            e.preventDefault();
            $("#signup_modal").modal("hide");
            let formData = new FormData($("#sfm_sign_up_form")[0]);
            formData.append("action", "sfm_handle_custom_register");

            sfmAjaxFormSubmit(formData);
        });


        /** ======================
         * Project Post and Update
         =======================*/
        if ($(".calendar").length) {
            let date = new Date();
            $(".calendar").pignoseCalendar({
                theme: "blue",
                format: "YYYY-MM-DD",
                minDate: date.setDate(date.getDate() - 1),
                select: function (date, context) {
                    $(context.element).next(".error").remove();
                },
            });
        }

        // Post a project popup
        $(document).on("submit", "#post-project-form", function (e) {
            e.preventDefault();
            if ($(this).valid()) {
                $("#modal_post_project").modal("show");
            }
        });

        // Post a Project Popup Accept & Publish project
        $("#accept-post-project-pop").on("click", function (e) {
            e.preventDefault();
            $("#modal_post_project").modal("hide");

            let imageIds = [];
            if ($(".fre-attached-list li").length) {
                $("li.image-item").each(function () {
                    imageIds.push($(this).attr("id"));
                });
            }

            let formData = new FormData($("#post-project-form")[0]);
            formData.append("project_images", imageIds);
            formData.append("action", "sfm_project_post_and_update");
            formData.append("currentUserId", ajaxObject.currentUserId);

            sfmAjaxFormSubmit(formData);
        });

        /** =========================
         * Project archive and delete
         ==========================*/
        $("body")
            .on("click", ".custom-project-action", function (e) {
                e.preventDefault();
                let actionType = $(this).data("action"),
                    projectId = $(this).data("project-id");
                if (actionType === "delete") {
                    $("#modal_delete_project").modal("show");
                    $("#modal_delete_project .input-error").remove();
                    $("#form_delete_project #project_id").val(projectId);
                } else if (actionType === "archive") {
                    $("#modal_archive_project").modal("show");
                    $("#modal_delete_project .input-error").remove();
                    $("#form_archive_project #project_id").val(projectId);
                }
            })
            .on("submit", "#form_delete_project", function (e) {
                e.preventDefault();

                let formData = new FormData(this);
                formData.append("action", "sfm_project_action");
                formData.append("project_action", "delete");
                sfmAjaxFormSubmit(formData);
            })
            .on("submit", "#form_archive_project", function (e) {
                e.preventDefault();

                let formData = new FormData(this);
                formData.append("action", "sfm_project_action");
                formData.append("project_action", "archive");
                sfmAjaxFormSubmit(formData);
            });

        /** =========================
         * ==== Submit Proposal =====
         ==========================*/
        $("body").on("submit", "#submit-proposal-form", function (e) {
            e.preventDefault();

            let fileIds = [];
            if ($(".fre-attached-list li").length) {
                $("li.image-item").each(function () {
                    fileIds.push($(this).attr("id"));
                });
            }

            let formData = new FormData(this);
            formData.append("proposal_files", fileIds);
            formData.append("action", "sfm_submit_proposal");
            sfmAjaxFormSubmit(formData);
        });

        /** =========================
         * ==== Accept Proposal =====
         ==========================*/
        $('body').on('click', '.btn-accept-bid-no-escrow', function (e) {
            let bidId = $(this).attr('id');
            console.log(bidId);
            $('#accept_bid_no_escrow #bid_id').val(bidId);
        }).on('submit', '#accept_bid_no_escrow', function (e) {
            e.preventDefault();

            let formData = new FormData(this);
            formData.append("action", "sfm_accept_proposal");
            sfmAjaxFormSubmit(formData);
        });


        // Form submission with validation ajax callback
        function sfmAjaxFormSubmit(formData) {
            $.ajax({
                url: ajaxObject.ajaxUrl,
                method: "POST",
                contentType: false,
                processData: false,
                data: formData,
                beforeSend: function () {
                    $("p.input-error").remove();
                    $("body").append(
                        '<div id="loader-wrapper"><div class="loader"></div></div>'
                    );
                },
                success: function (res) {
                    if (res.status === false) {
                        $(res.errors).each(function (index, item) {
                            let input = $('[name="' + item.name + '"]');
                            input.after('<p class="input-error">' + item.message + "</p>");
                            new Noty({
                                theme: "nest",
                                type: "error",
                                timeout: 3000,
                                progressBar: true,
                                text: item.message,
                            }).show();
                        });

                        $([document.documentElement, document.body]).animate(
                            {
                                scrollTop: $("p.input-error").first().offset().top - 200,
                            },
                            500
                        );

                        $("#loader-wrapper").remove();
                    }
                    if (res.status === true) {
                        $("#loader-wrapper").remove();

                        new Noty({
                            theme: "nest",
                            type: "success",
                            timeout: 3000,
                            progressBar: true,
                            text: res.message ? res.message : "Success!",
                        }).show();

                        if (res.redirect) {
                            location.reload(true);
                            window.location.replace(res.redirect);
                        }
                    }
                },
                error: function (err) {
                    $("#loader-wrapper").remove();
                    new Noty({
                        theme: "nest",
                        type: "error",
                        timeout: 3000,
                        progressBar: true,
                        text: err,
                    }).show();
                    console.log(err, "error");
                },
            });
        }


        // Custom File Upload
        if ($('#sfm_file_upload_container').length) {
            let uploader = new plupload.Uploader({
                browse_button: 'sfm_file_uploader', // this can be an id of a DOM element or the DOM element itself
                drop_element: 'sfm_file_uploader',
                container: 'sfm_file_upload_container',
                url: ajaxObject.upload,
                runtimes: 'html5,gears,flash,silverlight,browserplus,html4',
                multiple_queues: true,
                multipart: true,
                urlstream_upload: true,
                upload_later: false,
                filters: {
                    mime_types: [
                        {title: "Image files", extensions: "jpg,gif,png,jpgeg"},
                        {title: "Zip files", extensions: "zip"},
                        {title: "Doc files", extensions: "docx,xlsx,xls,doc,pdf"}
                    ],
                    max_file_size: "200mb",
                    prevent_duplicates: true
                }
            });
            uploader.init();

            uploader.bind('FilesAdded', function (up, files) {
                uploader.start();
            });

            uploader.bind('BeforeUpload', function (e) {
                $('button[type="submit"]').attr('disabled', true);
                $('#sfm_file_uploader').addClass('uploader-overlay').append('<div class="fre-loading-wrap"><div class="fre-loading"></div></div>');
            });

            uploader.bind('FileUploaded', function (up, file, result) {
                console.log(file, result);
                $('#image-list').append(`
                <li class="image-item" id="${result.response}">
                    <div class="attached-name"><p>${file.name}</p></div>
                    <div class="attached-size">${file.size / 100}kb</div>
                    <div class="attached-remove"><span class="delete-img delete" id="${result.response}"><i class="fa fa-times" aria-hidden="true"></i></span></div>
                </li>`);
            });

            uploader.bind('UploadComplete', function (up, files) {
                $('button[type="submit"]').attr('disabled', false);
                $('#sfm_file_uploader').removeClass('uploader-overlay')
                $('.fre-loading-wrap').remove();
            });

            uploader.bind('Error', function (up, err) {
                alert("Error #" + err.code + ": " + err.message);
                $('.fre-loading-wrap').remove();
            });

            // Delete uploaded image
            $('body').on('click', '.delete-img', function (e) {
                e.preventDefault();

                let fileId = $(this).attr('id');
                $.ajax({
                    method: 'POST',
                    url: ajaxObject.ajaxUrl,
                    data: {
                        action: 'sfm_file_delete',
                        id: fileId
                    },
                    success: function (res) {
                        if (res.success) {
                            $('.image-item#' + fileId).remove();
                        }
                    },
                    error: function (err) {
                        alert(err);
                    }
                })
            });
        }


    });
})(jQuery);
