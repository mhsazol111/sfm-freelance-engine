<div id="fre-post-project-2 step-post" class="step-wrapper">
    <div class="fre-post-project-boxx">
        <form class="employee-edit-form validation-enabled" id="post-project-form" role="form">
            <div id="fre-post-project">
                <h3><?php _e( 'Add Project Details', ET_DOMAIN ); ?></h3>
                <div class="fre-input-field">
                    <label class="fre-field-title"
                           for="project_category"><?php _e( 'What categories do your project work in?', ET_DOMAIN ); ?></label>
                    <select name="project_category[]" id="project_category" class="input-item sfm-select2" style="width: 100%" multiple="multiple" required>
						<?php
						$user_profile_id = get_user_meta( get_current_user_id(), 'user_profile_id', true );
						$cats            = get_the_terms( $user_profile_id, 'project_category' );
						foreach ( $cats as $cat ) {
							printf( '<option value="%s">%s</option>', $cat->term_id, $cat->name );
						}
						?>
                    </select>
					<?php
//					ae_tax_dropdown( 'project_category',
//						array(
//							'attr'            => 'data-chosen-width="100%" data-chosen-disable-search="" multiple data-placeholder="' . sprintf( __( "Choose maximum %s categories", ET_DOMAIN ), ae_get_option( 'max_cat', 5 ) ) . '"',
//							'class'           => 'fre-chosen-category required',
//							'class'           => 'fre-chosen-multi',
//							'hide_empty'      => false,
//							'hierarchical'    => true,
//							'id'              => 'project_category',
//							'show_option_all' => false,
//							'selected'        => [],
//							'name'            => 'project_category[]'
//						)
//					);
					?>
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
                    <label class="fre-field-title"
                           for="skill"><?php _e( 'What skills do you require for your project?', ET_DOMAIN ); ?></label>
					<?php
					ae_tax_dropdown( 'skill', array(
							'attr'            => 'data-chosen-width="100%" data-chosen-disable-search="" multiple data-placeholder="' . sprintf( __( "Choose maximum %s skills", ET_DOMAIN ), ae_get_option( 'fre_max_skill', 5 ) ) . '"',
							'class'           => ' fre-chosen-skill required',
							//'class' => ' fre-chosen-multi required',
							'hide_empty'      => false,
							'hierarchical'    => true,
							'id'              => 'skill',
							'show_option_all' => false,
							'selected'        => [],
							'name'            => 'skill[]'
						)
					);
					?>
                </div>
                <div class="bid-location-details three-column-row">
                    <div class="fre-input-field">
                        <label class="fre-field-title"
                               for="et_budget"><?php _e( 'Budget for your project (CHF)', ET_DOMAIN ); ?><span><?php _e( '(fill without currency)', ET_DOMAIN ); ?></span></label>
                        <div class="fre-project-budget">
                            <!-- <input type="number" id="et_budget" class="input-item text-field is_number numberVal"
                                   name="et_budget" required> -->
                            <select name="et_budget" id="et_budget" class="budget-select2" required>
                                <option></option>
                                <option><?php _e( 'To be determined', ET_DOMAIN ); ?></option>
                                <option><?php _e( 'Negotiable', ET_DOMAIN ); ?></option>
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
                        <label class="fre-field-title"
                               for="project-location"><?php _e( 'Preferred location (Optional)', ET_DOMAIN ); ?></label>
						<?php
						ae_tax_dropdown( 'country', array(
								'attr'            => 'data-chosen-width="100%" data-chosen-disable-search="" data-placeholder="' . __( "Choose country", ET_DOMAIN ) . '"',
								'class'           => 'fre-chosen-single',
								'hide_empty'      => false,
								'hierarchical'    => true,
								'id'              => 'country',
								'show_option_all' => __( "Choose country", ET_DOMAIN ),
								'selected'        => [],
								'country'         => 'country'
							)
						);
						?>
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
                        <h3 class="upload-title">File Attached</h3>
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