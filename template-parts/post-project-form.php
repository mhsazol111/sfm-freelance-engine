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
						foreach ( $cats as $cat ) {
							echo '<option value="' . $cat->term_id . '">' . __( $cat->name, ET_DOMAIN ) . '</option>';
						}
						?>
                    </select>
                </div>
                <div class="fre-input-field">
                    <label class="fre-field-title"
                           for="post_title"><?php _e( 'Write a nice title for your project', ET_DOMAIN ); ?></label>
                    <input class="input-item text-field" id="post_title" type="text" name="post_title" required
                           autocomplete="off">
                </div>

                <div class="fre-input-field">
                    <label class="fre-field-title"
                           for="post_content"><?php _e( 'Describe more details about your project', ET_DOMAIN ); ?></label>
					<?php wp_editor( '', 'post_content', ae_editor_settings() ); ?>
                </div>

                <div class="fre-input-field">
                    <label class="fre-field-title" for="skill"><?php _e( 'What skills do you require for your project?', ET_DOMAIN ); ?></label>
                    <select name="skill[]" id="skill" class="input-item sfm-select2" style="width: 100%" multiple="multiple" data-placeholder="<?php _e('Choose maximum 10 skills', ET_DOMAIN); ?>" data-allow-clear="true" required>
			            <?php
			            $skills            = get_terms( array(
			                'taxonomy'   => 'skill',
                            'hide_empty' => false,
                        ) );
			            foreach ( $skills as $skill ) {
				            echo '<option value="' . $skill->term_id . '">' . __( $skill->name, ET_DOMAIN ) . '</option>';
			            }
			            ?>
                    </select>
                </div>

                <div class="bid-location-details">
                    <div class="fre-input-field">
                        <label class="fre-field-title" for="et_budget"><?php _e( 'Budget (CHF)', ET_DOMAIN ); ?></label>
                        <div class="fre-project-budget">
                            <select name="et_budget" id="et_budget" class="budget-select2" required>
                                <option value=""><?php _e( 'Input your budget or Select from dropdown', ET_DOMAIN ); ?></option>
                                <option value="To be determined"><?php _e( 'To be determined', ET_DOMAIN ); ?></option>
                                <option value="Negotiable"><?php _e( 'Negotiable', ET_DOMAIN ); ?></option>
                            </select>
                        </div>
                    </div>

                    <div class="fre-input-field">
                        <label class="fre-field-title"
                               for="project_deadline"><?php _e( 'Deadline', ET_DOMAIN ); ?></label>
                        <div class="fre-project-budget">
                            <input type="text" id="project_deadline" name="project_deadline"
                                   class="input-item text-field calendar" required/>
                        </div>
                    </div>

                    <div class="fre-input-field">
                        <label class="fre-field-title" for="language"><?php _e( 'Select Preferred Language', ET_DOMAIN ) ?></label>
                        <select name="language[]" id="language" class="sfm-select2" multiple required>
                            <option value=""><?php _e( 'Select All', ET_DOMAIN ) ?></option>
			                <?php
			                $languages = get_terms( array(
				                'taxonomy'   => 'language',
				                'hide_empty' => false,
			                ) );

			                foreach ( $languages as $language ) {
				                echo '<option value="' . $language->term_id . '">' . $language->name . '</option>';
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
			                foreach ( $countries as $country ) {
				                echo '<option value="' . $country->term_id . '">' . __( $country->name, ET_DOMAIN ) . '</option>';
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
                        <h3 class="upload-title"><?php _e( "File Attached", ET_DOMAIN ); ?></h3>
                        <ul class="fre-attached-list gallery-image carousel-list" id="image-list"></ul>
                    </div>
                </div>

                <div class="fre-post-project-btn">
                    <button class="fre-btn submit" type="submit"
                            name="submit"><?php _e( "Post a project", ET_DOMAIN ); ?></button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- Step 3 / End -->