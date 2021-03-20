<?php
$current_lang      = get_locale();
$current_user_id   = get_current_user_id();
$user_profile_id   = get_user_meta( $current_user_id, 'user_profile_id', true );
$user_categories   = wp_get_post_terms( $user_profile_id, 'project_category' );
$user_category_ids = wp_list_pluck( $user_categories, 'term_id' );
$skills            = get_terms( array(
	'taxonomy'   => 'skill',
	'hide_empty' => false
) );

$current_settings = get_user_meta( $current_user_id, 'notification_settings', true );
$current_settings = unserialize( $current_settings );
?>

<form action="" id="notification-settings-form" style="width: 100%">
    <div class="sfm-ntfs-input input-field">
        <p><strong><?php _e( 'Enable email notification', ET_DOMAIN ); ?></strong></p>
        <label class="switch" for="checkbox">
            <input type="checkbox" id="checkbox"
                   name="notification-toggle" <?php echo $current_settings['status'] ? 'checked' : ''; ?>/>
            <div class="slider round"></div>
        </label>
    </div>
    <div class="sfm-ntfs-sh-wrap fields-disabled">
        <div class="sfm-ntfs-input input-field fre-input-field single-select2-field">
            <label for="notification-frequency"><?php _e( 'Notification frequency', ET_DOMAIN ); ?></label>
            <select id="notification-frequency" name="notification-frequency" style="width: 100%">
                <option value="daily" <?php echo $current_settings['frequency'] == 'daily' ? 'selected' : ''; ?>><?php _e( 'Daily', ET_DOMAIN ); ?></option>
                <option value="weekly" <?php echo $current_settings['frequency'] == 'weekly' ? 'selected' : ''; ?>><?php _e( 'Weekly', ET_DOMAIN ); ?></option>
                <option value="fortnightly" <?php echo $current_settings['frequency'] == 'fortnightly' ? 'selected' : ''; ?>><?php _e( 'Fortnightly', ET_DOMAIN ); ?></option>
                <option value="once_monthly" <?php echo $current_settings['frequency'] == 'once_monthly' ? 'selected' : ''; ?>><?php _e( 'Monthly', ET_DOMAIN ); ?></option>
            </select>
        </div>
        <div class="sfm-ntfs-input input-field fre-input-field">
            <label for="quantity">
				<?php
				if ( USER_ROLE == 'freelancer' ) :
					_e( 'How many projects you want to receive per notification?', ET_DOMAIN );
				else:
					_e( 'How many freelancer profiles you want to receive per notification?', ET_DOMAIN );
				endif;
				?>
            </label>
            <input type="number" id="quantity" name="quantity" min="3" max="25"
                   value="<?php echo $current_settings['quantity'] ? $current_settings['quantity'] : 10; ?>"
            />
        </div>

		<?php if ( USER_ROLE == 'freelancer' ) : ?>

            <div class="sfm-ntfs-input input-field fre-input-field">
                <p>
                    <strong><?php _e( 'Select the category required for the projects', ET_DOMAIN ); ?></strong>
                </p>

				<?php
				$selected_cats = $current_settings['project_cat_ids'];
				foreach ( $user_categories as $key => $category ) :
					?>
                    <div class="freelancer-category-row">
                        <label class="container-checkbox">
							<?php if ( isset( $selected_cats ) && $selected_cats ) : ?>
                                <input type="checkbox" name="project-cat-ids[]" class="freelancer-cat-switch"
                                       value="<?php echo $category->term_id; ?>" <?php echo in_array( $category->term_id, $selected_cats ) ? 'checked' : ''; ?>/>
							<?php else : ?>
                                <input type="checkbox" name="project-cat-ids[]" class="freelancer-cat-switch"
                                       value="<?php echo $category->term_id; ?>"
                                       checked/>
							<?php endif; ?>
                            <span class="checkmark"></span>
                        </label>
                        <div class="freelancer-category-name">
							<?php
							$la_opt_cat = get_field( $current_lang . '_label', $category );
							if ( get_locale() == 'en_US' ) :
								_e( $category->name, ET_DOMAIN );
							else:
								echo $la_opt_cat;
							endif;
							?>
                        </div>
                    </div>
				<?php endforeach; ?>
            </div>

		<?php else: ?>

            <div class="sfm-ntfs-input input-field fre-input-field">
                <p>
                    <strong><?php _e( 'Select the category required for the freelancers to have', ET_DOMAIN ); ?></strong>
                </p>

				<?php
				$selected_cats   = $current_settings['freelancer_cat_ids'];
				$selected_skills = $current_settings['freelancer_skill_ids'];
				foreach ( $user_categories as $key => $category ) :
					?>
                    <div class="freelancer-category-row">

                        <label class="container-checkbox">
							<?php if ( isset( $selected_cats ) && $selected_cats ) : ?>
                                <input type="checkbox" name="freelancer-cat-ids[]" class="freelancer-cat-switch"
                                       value="<?php echo $category->term_id; ?>" <?php echo array_key_exists( $category->term_id, $selected_cats ) ? 'checked' : ''; ?>/>
							<?php else : ?>
                                <input type="checkbox" name="freelancer-cat-ids[]" class="freelancer-cat-switch"
                                       value="<?php echo $category->term_id; ?>"
                                       checked/>
							<?php endif; ?>
                            <span class="checkmark"></span>
                        </label>

                        <div class="freelancer-category-name">
							<?php
							$la_opt_cat = get_field( $current_lang . '_label', $category );
							if ( get_locale() == 'en_US' ) :
								_e( $category->name, ET_DOMAIN );
							else:
								echo $la_opt_cat;
							endif;
							?>
                        </div>

                        <div class="freelancer-skill-switch-row <?php echo ! $current_settings || ( $selected_cats && array_key_exists( $category->term_id, $selected_cats ) ) ? '' : 'fields-disabled'; ?>">
                            <p><?php _e( 'Must have skills', ET_DOMAIN ); ?></p>
                            <label class="switch" for="checkbox-<?php echo $category->term_id; ?>">
                                <input type="checkbox" id="checkbox-<?php echo $category->term_id; ?>"
                                       class="freelancer-skill-switch"
                                       value="<?php echo $category->term_id; ?>"
                                       name="freelancer-skill-switch[<?php echo $category->term_id; ?>]" <?php echo ( $current_settings['freelancer_skill_switch'] && $current_settings['freelancer_skill_switch'][ $category->term_id ] == $category->term_id ) ? 'checked' : ''; ?>/>
                                <div class="slider round"></div>
                            </label>
                        </div>

                        <div class="freelancer-skills-row <?php echo $selected_cats && $selected_cats[ $category->term_id ] ? '' : 'display-none'; ?>">
                            <select name="freelancer-skill-ids[<?php echo $category->term_id; ?>][]"
                                    class="form-control skill-select2" multiple
                                    required <?php echo ( $selected_cats && $selected_cats[ $category->term_id ] ) ? '' : 'disabled'; ?>
                                    style="width: 100%">
								<?php
								foreach ( $skills as $skill ) :
									$la_opt_cat = get_field( $current_lang . '_label', $skill );

									if ( get_locale() == 'en_US' ) :
										if ( $selected_cats[ $category->term_id ] && in_array( $skill->term_id, $selected_cats[ $category->term_id ] ) ) {
											echo '<option value="' . $skill->term_id . '" selected>' . $skill->name . '</option>';
										} else {
											echo '<option value="' . $skill->term_id . '">' . $skill->name . '</option>';
										}
									else:
										if ( $selected_cats[ $category->term_id ] && in_array( $skill->term_id, $selected_cats[ $category->term_id ] ) ) {
											echo '<option class="la-option" value="' . $skill->term_id . '" selected>' . $la_opt_cat . '</option>';
										} else {
											echo '<option class="la-option" value="' . $skill->term_id . '">' . $la_opt_cat . '</option>';
										}
									endif;
								endforeach;
								?>
                            </select>
                        </div>

                    </div>
				<?php endforeach; ?>
            </div>

		<?php endif; ?>

    </div>

    <div class="sfm-ntfs-input input-field fre-input-field">
        <button class="btn-all ie_btn submit" type="submit" name="submit">Save</button>
    </div>

</form>


<script>
    ;(function ($) {
        $(document).ready(function () {

            let $catSwitch = $('.freelancer-cat-switch');

            $catSwitch.on('change', function (e) {
                let $catRow = $(this).closest('.freelancer-category-row'),
                    $skillSwitchRow = $catRow.find('.freelancer-skill-switch-row'),
                    $skillSwitch = $catRow.find('.freelancer-skill-switch'),
                    $skillsRow = $catRow.find('.freelancer-skills-row'),
                    $skills = $catRow.find('.skill-select2');

                if ($(this).is(':checked')) {
                    $skillSwitchRow.removeClass('fields-disabled');
                } else {
                    if (!$skillsRow.hasClass('display-none')) {
                        $skillsRow.addClass('display-none');
                    }
                    $skillSwitchRow.addClass('fields-disabled');
                    $skills.attr('disabled', true);
                    $skillSwitch.prop("checked", false);
                }
            });

            $('.freelancer-skill-switch').on('change', function (e) {
                if ($(this).is(':checked')) {
                    $(this).closest('.freelancer-category-row').find('.freelancer-skills-row').removeClass('display-none').find('.skill-select2').attr('disabled', false);
                } else {
                    $(this).closest('.freelancer-category-row').find('.freelancer-skills-row').addClass('display-none').find('.skill-select2').attr('disabled', true);
                }
            });


            if ($('input[name="notification-toggle"]').is(':checked')) {
                $('.sfm-ntfs-sh-wrap').removeClass('fields-disabled');
            }

            $('input[name="notification-toggle"]').on('change', function (e) {
                if ($(this).is(':checked')) {
                    $('.sfm-ntfs-sh-wrap').removeClass('fields-disabled');
                } else {
                    $('.sfm-ntfs-sh-wrap').addClass('fields-disabled');
                }
            });

            //Categories Select Box
            $('#notification-frequency').select2({
                minimumResultsForSearch: Infinity
            });

            $('.skill-select2').each(function (index, element) {
                $(this).select2({
                    placeholder: "Please select some skills",
                });
            });

            // $('.skill-select2').select2({
            //     placeholder: "Please select some skills",
            // });


            $('#notification-settings-form').on('submit', function (e) {
                e.preventDefault();
                let formData = new FormData(this);
                formData.append('action', 'handle_notification_settings');
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
                        $('p.input-error').remove();
                        if (res.success === false) {
                            $(res.errors).each(function (index, item) {
                                let input = $('[name="' + item.name + '"]');
                                input.before('<p class="input-error">' + item.message + "</p>");
                                new Noty({
                                    theme: "nest",
                                    type: "error",
                                    timeout: 3000,
                                    progressBar: true,
                                    text: item.message,
                                }).show();
                            });

                            $([document.documentElement, document.body]).animate({
                                scrollTop: $("p.input-error").first().offset().top - 200,
                            }, 500);

                            $("#loader-wrapper").remove();
                        }
                        if (res.success === true) {
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
                            text: 'Something went wrong!',
                        }).show();
                        console.log(err, "error");
                    },
                });
            });


            // $('.categories-select2').select2({
            //     placeholder: "Please select a Category *",
            // });
            // $('.child-categories-select2').select2({
            //     placeholder: "Please select at least one Sub-Category *",
            // });
            //
            // $('body').on('click', '.add-more-category', function (e) {
            //     e.preventDefault();
            //
            //     $('.categories-select2, .child-categories-select2').select2('destroy');
            //
            //     let rowCount = $('.category-row').last().data('count');
            //     let newCategoryRow = $(`
            //             <div class="row category-row" data-count=${rowCount + 1}>
            //                 <div class="col-lg-auto col-md-12 d-lg-block d-none">
            //                     <button type="button" class="btn btn-sm btn-danger mt-1 remove-category-row" disabled>
            //                         <i class="icofont-trash"></i>
            //                     </button>
            //                 </div>
            //                 <div class="col-lg-4 col-md-12 mb-3 parent-categories-wrap">
            //                     <div class="form-group m-0">
            //                         <select name="categories[${rowCount + 1}][]" class="form-control categories-select2" required>
            //                             <option></option>
            //                             @foreach($parentCategories as $category)
            //                                 <option value="{{ $category->id }}">{{ $category->title }}</option>
            //                             @endforeach
            //                         </select>
            //                     </div>
            //                 </div>
            //                 <div class="col-lg-7 col-md-12 mb-3 child-categories-wrap"></div>
            //                 <div class="col-lg-auto col-md-12 d-block d-lg-none">
            //                     <button type="button" class="btn btn-sm btn-danger remove-category-row" disabled>
            //                         <i class="icofont-trash"></i>
            //                     </button>
            //                 </div>
            //             </div>`);
            //
            //     $('#category-wrapper').append(newCategoryRow);
            //
            //     let newParentSelect = newCategoryRow.find('.categories-select2');
            //     let newChildSelect = newCategoryRow.find('.child-categories-select2');
            //     $('.categories-select2, .child-categories-select2').select2();
            //     newParentSelect.select2({
            //         placeholder: "Please select a category *",
            //     });
            //     newChildSelect.select2({
            //         placeholder: "Please select at least one Sub-Category *",
            //     });
            //
            //     $('.remove-category-row').removeAttr('disabled');
            // });
        });
    })(jQuery);
</script>