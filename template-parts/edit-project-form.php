<?php 
$current_lang = get_locale();
$project = get_post( $_REQUEST['id'] ); 
?>
<div id="fre-post-project-2 step-post" class="step-wrapper">
    <div class="fre-post-project-boxx">
        <form class="employee-edit-form validation-enabled" id="post-project-form" role="form">
            <div id="fre-post-project">
                <h3><?php _e( 'Add Project Details', ET_DOMAIN ); ?></h3>
                <div class="fre-input-field">
                    <label class="fre-field-title"
                           for="project_category"><?php _e( 'What categories do your project work in?', ET_DOMAIN ); ?></label>
                    <select name="project_category[]" id="project_category" class="input-item sfm-select2"
                            style="width: 100%" multiple="multiple" required>
						<?php
						$user_profile_id = get_user_meta( get_current_user_id(), 'user_profile_id', true );
						$cats            = get_the_terms( $user_profile_id, 'project_category' );

						$selected_cats = get_the_terms( $_REQUEST['id'], 'project_category' );
						$cate_arr      = array();
						if ( ! empty( $selected_cats ) ) {
							foreach ( $selected_cats as $cat ) {
								$cate_arr[] = $cat->term_id;
							}
						}

						foreach ( $cats as $cat ) {
                            $la_opt_cat = get_field( $current_lang . '_label', $cat );

                            if ( get_locale() == 'en_US' ) :
                                if ( in_array( $cat->term_id, $cate_arr ) ) {
                                    echo '<option value="' . $cat->term_id . '" selected>' . __( $cat->name, ET_DOMAIN ) . '</option>';
                                } else {
                                    echo '<option value="' . $cat->term_id . '">' . __( $cat->name, ET_DOMAIN ) . '</option>';
                                }
                            else:
                                if ( in_array( $cat->term_id, $cate_arr ) ) {
                                    echo '<option class="la-option" value="' . $cat->term_id . '" selected>' . __( $la_opt_cat, ET_DOMAIN ) . '</option>';
                                } else {
                                    echo '<option class="la-option" value="' . $cat->term_id . '">' . __( $la_opt_cat, ET_DOMAIN ) . '</option>';
                                }
                            endif;
						}
						?>
                    </select>

                </div>
                <div class="fre-input-field">
                    <label class="fre-field-title"
                           for="post_title"><?php _e( 'Write a nice title for your project', ET_DOMAIN ); ?></label>
                    <input class="input-item text-field" id="post_title" type="text" name="post_title"
                           value="<?php echo $project->post_title; ?>" required
                           autocomplete="off">
                </div>

                <div class="fre-input-field">
                    <label class="fre-field-title"
                           for="post_content"><?php _e( 'Describe more details about your project', ET_DOMAIN ); ?></label>
					<?php wp_editor( $project->post_content, 'post_content', ae_editor_settings() ); ?>
                </div>


                <div class="fre-input-field">
                    <label class="fre-field-title" for="skill"><?php _e( 'What skills do you require for your project?', ET_DOMAIN ); ?></label>
                    <select name="skill[]" id="skill" class="input-item sfm-select2" style="width: 100%" multiple="multiple" data-placeholder="<?php _e('Choose maximum 10 skills', ET_DOMAIN); ?>" data-allow-clear="true" required>
			            <?php
			            $skills            = get_terms( array(
				            'taxonomy'   => 'skill',
				            'hide_empty' => false,
			            ) );

			            $selected_skills = get_the_terms( $_REQUEST['id'], 'skill' );
			            $c_skills      = array();
			            if ( ! empty( $selected_skills ) ) {
				            foreach ( $selected_skills as $skill ) {
					            $c_skills[] = $skill->term_id;
				            }
			            }

			            foreach ( $skills as $skill ) {
                            $la_opt_skill = get_field( $current_lang . '_label', $skill );

                            if ( get_locale() == 'en_US' ) :
                                if ( in_array( $skill->term_id, $c_skills ) ) {
                                    echo '<option value="' . $skill->term_id . '" selected>' . __( $skill->name, ET_DOMAIN ) . '</option>';
                                } else {
                                    echo '<option value="' . $skill->term_id . '">' . __( $skill->name, ET_DOMAIN ) . '</option>';
                                }
                            else:
                                if ( in_array( $skill->term_id, $c_skills ) ) {
                                    echo '<option class="la-option" value="' . $skill->term_id . '" selected>' . __( $la_opt_skill, ET_DOMAIN ) . '</option>';
                                } else {
                                    echo '<option class="la-option" value="' . $skill->term_id . '">' . __( $la_opt_skill, ET_DOMAIN ) . '</option>';
                                }
                            endif;
			            }
			            ?>
                    </select>
                </div>

                <div class="bid-location-details">
                    <div class="fre-input-field">
                        <label class="fre-field-title"
                               for="project-budget"><?php _e( 'Budget', ET_DOMAIN ); ?></label>
                        <div class="fre-project-budget">
                            <select name="et_budget" id="et_budget" class="budget-select2" required>
								<?php
								$e_budget = get_post_meta( $_REQUEST['id'], 'et_budget', true );
								if ( $e_budget == 'To be determined' ): ?>
                                    <option value=""><?php _e( 'Input your budget or Select from dropdown', ET_DOMAIN ); ?></option>
                                    <option value="To be determined" selected><?php _e( 'To be determined', ET_DOMAIN ); ?></option>
                                    <option value="Negotiable"><?php _e( 'Negotiable', ET_DOMAIN ); ?></option>
								<?php elseif ( $e_budget == 'Negotiable' ): ?>
                                    <option value=""><?php _e( 'Input your budget or Select from dropdown', ET_DOMAIN ); ?></option>
                                    <option value="To be determined"><?php _e( 'To be determined', ET_DOMAIN ); ?></option>
                                    <option value="Negotiable" selected><?php _e( 'Negotiable', ET_DOMAIN ); ?></option>
								<?php else : ?>
                                    <option value="<?php echo $e_budget ?>" selected><?php echo $e_budget ?></option>
                                    <option value="To be determined"><?php _e( 'To be determined', ET_DOMAIN ); ?></option>
                                    <option value="Negotiable"><?php _e( 'Negotiable', ET_DOMAIN ); ?></option>
								<?php endif
								?>
                            </select>
                        </div>
                    </div>

                    <div class="fre-input-field">
                        <label class="fre-field-title"
                               for="project_deadline"><?php _e( 'Deadline', ET_DOMAIN ); ?></label>
                        <div class="fre-project-budget">
                            <input type="text" id="project_deadline" name="project_deadline"
                                   class="input-item text-field calendar"
                                   value="<?php echo get_post_meta( $_REQUEST['id'], 'project_deadline', true ); ?>"
                                   required/>
                        </div>
                    </div>

                    <div class="fre-input-field">
                        <label class="fre-field-title" for="language"><?php _e( 'Select Preferred Language', ET_DOMAIN ) ?></label>
                        <select name="language[]" id="language" class="sfm-select2" multiple required>
			                <?php
			                $languages = get_terms( array(
				                'taxonomy'   => 'language',
				                'hide_empty' => false,
			                ) );

			                $selected_languages = get_the_terms( $_REQUEST['id'], 'language' );
			                $c_languages      = array();
			                if ( ! empty( $selected_languages ) ) {
				                foreach ( $selected_languages as $language ) {
					                $c_languages[] = $language->term_id;
				                }
			                }

			                foreach ( $languages as $language ) {
                                $la_opt_language = get_field( $current_lang . '_label', $language );

                                if ( get_locale() == 'en_US' ) :
                                    if ( in_array( $language->term_id, $c_languages ) ) {
                                        echo '<option value="' . $language->term_id . '" selected>' . __( $language->name, ET_DOMAIN ) . '</option>';
                                    } else {
                                        echo '<option value="' . $language->term_id . '">' . __( $language->name, ET_DOMAIN ) . '</option>';
                                    }
                                else:
                                    if ( in_array( $language->term_id, $c_languages ) ) {
                                        echo '<option class="la-option" value="' . $language->term_id . '" selected>' . __( $la_opt_language, ET_DOMAIN ) . '</option>';
                                    } else {
                                        echo '<option class="la-option" value="' . $language->term_id . '">' . __( $la_opt_language, ET_DOMAIN ) . '</option>';
                                    }
                                endif;
			                }
			                ?>
                        </select>
                    </div>

                    <div class="fre-input-field">
                        <label class="fre-field-title" for="country"><?php _e( 'Project location', ET_DOMAIN ); ?></label>
                        <select name="country" id="country" class="input-item sfm-select2" style="width: 100%" required>
                            <option value=""><?php _e('Choose a country', ET_DOMAIN); ?></option>
			                <?php
			                $countries = get_terms( array(
				                'taxonomy'   => 'country',
				                'hide_empty' => false,
			                ) );

			                $selected_country = get_the_terms( $_REQUEST['id'], 'country' );
			                if ( ! empty( $selected_country ) ) {
				                $c_country        = $selected_country[0]->term_id;
			                }

			                foreach ( $countries as $country ) {
                                $la_opt_country = get_field( $current_lang . '_label', $country );

                                if ( get_locale() == 'en_US' ) :
                                    $selected = $c_country == $country->term_id ? 'selected' : '';
                                    echo '<option value="' . $country->term_id . '" '. $selected . '>' . __( $country->name, ET_DOMAIN ) . '</option>';
                                else:
                                    $selected = $c_country == $country->term_id ? 'selected' : '';
                                    echo '<option class="la-option" value="' . $country->term_id . '" '. $selected . '>' . __( $la_opt_country, ET_DOMAIN ) . '</option>';
                                endif;
			                }
			                ?>
                        </select>
                    </div>
                </div>

                <div class="fre-input-field" id="gallery_place">
                    <label class="fre-field-title" for=""><?php _e( 'Add attachment (Optional)', ET_DOMAIN ); ?></label>
                    <div class="edit-gallery-image" id="gallery_container">
                        <div id="carousel_container">
                            <a href="javascript:void(0)" style="display: block"
                               class="img-gallery fre-project-upload-file secondary-color" id="carousel_browse_button">
								<?php _e( "Upload Files", ET_DOMAIN ); ?>
                            </a>
                            <span class="et_ajaxnonce hidden"
                                  id="<?php echo wp_create_nonce( 'ad_carousels_et_uploader' ); ?>"></span>
                        </div>
                        <p class="fre-allow-upload">
							<?php _e( 'Upload maximum 5 files with extensions including png, jpg, pdf, xls, and doc format', ET_DOMAIN ); ?>
                        </p>
                        <h3 class="upload-title"><?php _e( 'File Attached', ET_DOMAIN ); ?></h3>
                        <ul class="fre-attached-list gallery-image carousel-list" id="image-list"></ul>
                        <ul class="fre-attached-list gallery-image carousel-list">
							<?php
							$attachments = get_posts(
								array(
									'post_type'     => 'attachment',
									'post_parent'   => $_REQUEST['id'],
									'post_per_page' => - 1
								)
							);

							if ( $attachments ) :
								foreach ( $attachments as $att ) :
									$att_meta = wp_get_attachment_metadata( $att->ID );
									?>
                                    <li class="image-item" id="<?php echo $att->ID; ?>">
                                        <div class="attached-name"><p><?php echo $att->post_title; ?></p></div>
                                        <!--  <div class="attached-size">65.51 Kb</div>-->
                                        <div class="attached-remove">
                                            <span class=" delete-img delete">
                                                <i class="fa fa-times" aria-hidden="true"></i>
                                            </span>
                                        </div>
                                    </li>
								<?php
								endforeach;
							endif;
							?>
                        </ul>
                    </div>
                </div>
                <input type="hidden" name="project_id" id="project_id" class="project_id"
                       value="<?php echo $_REQUEST['id']; ?>">
                <div class="fre-post-project-btn">
                    <button class="fre-btn submit" type="submit"
                            name="submit"><?php _e( "Update project", ET_DOMAIN ); ?></button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- Step 3 / End -->