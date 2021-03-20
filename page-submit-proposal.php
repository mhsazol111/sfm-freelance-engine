<?php
/**
 * Template Name: Submit Proposal
 */

// Redirects an user back to their edit profile to update the profile first


get_header();

if ( sfm_translating_as( 'employer' ) ) {
	echo 'translating';
} else {

	if ( ! get_user_meta( get_current_user_id(), 'user_profile_id', true ) ) {
		wp_redirect( home_url() . '/edit-profile' );
	}
	if ( isset( $_REQUEST['id'] ) && $_REQUEST['id'] != '' && ( USER_ROLE == 'freelancer' || current_user_can( 'administrator' ) ) ) {
		// Check if the given id is not a project
		$project = get_post( $_REQUEST['id'] );
		if ( PROJECT != $project->post_type ) {
			wp_redirect( home_url() . '/projects' );
		}

		// Check freelancer already bid on the project
		$children = get_children( array(
			'post_parent' => $_REQUEST['id'],
			'post_type'   => 'bid'
		) );

		if ( ! empty( $children ) ) {
			$author_ids = [];
			foreach ( $children as $child ) {
				$author_ids[] = $child->post_author;
			}
			if ( in_array( get_current_user_id(), $author_ids ) ) {
				wp_redirect( get_permalink( $_REQUEST['id'] ) );
			}
		}

	} else {
		wp_redirect( home_url() . '/projects' );
	}
	?>

    <div class="fre-page-wrapper submit-proposal-wrapper">
        <div class="profile_dashboard" id="<?php echo USER_ROLE; ?>-dashboard">

			<?php get_template_part( 'template-parts/sidebar', 'profile' ); // Dashboard Sidebar ?>

            <section id="dashboard_content">
                <div class="dashboard_inn" id="modal_bid">

                    <div class="dashboard_title">
                        <h2><?php _e( 'Submit your proposal', ET_DOMAIN ); ?></h2>
                        <hr>
                    </div>

                    <div class="fre-page-section">
                        <div class="page-submit-proposal-wrap">
							<?php $project = get_post( $_REQUEST['id'] ); ?>
                            <div class="proposal-short-description">
                                <h3><?php echo $project->post_title; ?></h3>
                                <div class="e_nav">
                                    <p><?php _e( 'Posted on:', ET_DOMAIN ); ?>
                                        <span><?php echo date( 'F j, Y', strtotime( $project->post_date ) ); ?></p> |
                                    <p> <?php _e( 'Categories:', ET_DOMAIN ); ?>:
										<?php echo Employer::get_project_terms( $project->ID, 'project_category', true, 'span', true ); ?>
                                    </p> |
                                    <p> <?php _e( 'Budget:', ET_DOMAIN ); ?>
                                        <span><?php
											$budgets = $project->et_budget;
											if ( is_numeric( $budgets ) ) { ?>
                                                CHF <?php echo $budgets;
											} else {
												echo $budgets;
											}
											?>
                                    </p> |
                                    <p><?php _e( 'Deadline:', ET_DOMAIN ); ?>
                                        <span><?php echo date( 'F j, Y', strtotime( $project->project_deadline ) ); ?>
                                    </p>
                                </div>
                                <div class="content">
									<?php
									$str = strip_tags( $project->post_content );
									if ( strlen( $str ) > 400 ) {
										$str = substr( $str, 0, 400 ) . ' ...';
									}
									echo $str;
									?>
                                </div>
                                <div class="read-more">
                                    <a href="<?php echo get_permalink( $project->ID ); ?>" target="_blank"><?php _e( 'View full
                                        project', ET_DOMAIN ); ?></a>
                                </div>
                            </div>
                            <div class="proposal-meta-description">
                                <div class="proposal-skill">
                                    <h5><?php _e( 'Required Skills', ET_DOMAIN ); ?></h5>
                                    <div class="skills">
										<?php echo Employer::get_project_terms( $project->ID, 'skill', 'true' ); ?>
                                    </div>
                                </div>
								<?php
								$preferred_location = get_the_terms( $_REQUEST['id'], 'country' );
								if ( $preferred_location ) :
									?>
                                    <div class="locations">
                                        <h5><?php _e( 'Preferred Location', ET_DOMAIN ); ?></h5>
                                        <p><?php echo $preferred_location[0]->name; ?></p>
                                    </div>
								<?php endif; ?>
                            </div>

                            <form method="POST" class="proposal-form validation-enabled" id="submit-proposal-form"
                                  enctype="multipart/form-data" role="form">
                                <h3 class="profile-title"><?php _e( 'Project Terms', ET_DOMAIN ); ?></h3>
                                <div class="project-terms">
                                    <div class="input-field">
                                        <label for="bid_daily_wage"><?php _e( 'Daily wage (CHF)', ET_DOMAIN ); ?>
                                            <span><?php _e( '(fill without currency)', ET_DOMAIN ); ?></span></label>
                                        <input type="number" name="bid_daily_wage" id="bid_daily_wage"
                                               class="form-control number numberVal" min="0"
                                               placeholder="Amount of daily wage" required/>
                                    </div>
                                    <div class="input-field">
                                        <label for="bid_work_days"><?php _e( 'Number of days you’ll work', ET_DOMAIN ); ?></label>
                                        <input type="number" name="bid_work_days" id="bid_work_days"
                                               class="form-control number numberVal" min="1" required/>
                                    </div>
                                    <div class="input-field">
                                        <label for="bid_deadline"><?php _e( 'How long will this project take?', ET_DOMAIN ); ?></label>
                                        <input type="text" id="bid_deadline" name="bid_deadline"
                                               class="input-item text-field calendar" required/>
                                    </div>
                                    <div class="input-field full">
                                        <label for="bid_content"><?php _e( 'Message to client', ET_DOMAIN ); ?></label>
                                        <textarea id="bid_content" name="bid_content" rows="20" cols="20"
                                                  placeholder="Add detail message for client" required></textarea>
                                    </div>
                                </div>

                                <div class="fre-input-field" id="gallery_place">
                                    <label class="fre-field-title"
                                           for=""><?php _e( 'Add attachment (Optional)', ET_DOMAIN ); ?></label>
                                    <div class="edit-gallery-image" id="sfm_file_upload_container">
                                        <div id="carousel_container">
                                            <a href="javascript:void(0)" style="display: block"
                                               class="img-gallery fre-project-upload-file secondary-color"
                                               id="sfm_file_uploader">
												<?php _e( "Upload Files", ET_DOMAIN ); ?>
                                            </a>
                                            <span class="et_ajaxnonce hidden"
                                                  id="<?php echo wp_create_nonce( 'submit_proposal_nonce' ); ?>"></span>
                                        </div>
                                        <p class="fre-allow-upload">
											<?php _e( 'Upload maximum 5 files with extensions including png, jpg, pdf, xls, and doc format', ET_DOMAIN ); ?>
                                        </p>
                                        <h3 class="upload-title"><?php _e( "File Attached", ET_DOMAIN ); ?></h3>
                                        <ul class="fre-attached-list gallery-image carousel-list" id="image-list"></ul>
                                    </div>
                                </div>

                                <input type="hidden" name="project_id" value="<?php echo $_REQUEST['id']; ?>"/>
                                <button class="btn-all ie_btn" type="submit"
                                        name="submit"><?php _e( 'Submit Proposal', ET_DOMAIN ); ?></button>
                            </form>

                        </div>
                    </div>
                </div>
            </section>

        </div>
    </div>
	<?php
}
get_footer();