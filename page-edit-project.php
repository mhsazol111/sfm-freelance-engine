<?php

/**
 * Template Name: Edit Project
 */

// Redirects an user back to their edit profile to update the profile first
if ( ! get_user_meta( get_current_user_id(), 'user_profile_id', true ) ) {
	wp_redirect( home_url() . '/edit-profile' );
}

get_header();
?>
    <div class="fre-page-wrapper post-project-wrapper">
        <div class="profile_dashboard" id="<?php echo USER_ROLE; ?>-dashboard">

	        <?php get_template_part( 'template-parts/sidebar', 'profile' ); // Dashboard Sidebar ?>

            <section id="dashboard_content">
                <div class="dashboard_inn">
                    <div class="dashboard_title">
                        <h2><?php _e( 'Post a project', ET_DOMAIN ); ?></h2>
                        <hr>
                    </div>

                    <div class="fre-page-section">
                        <div class="page-post-project-wrap" id="post-place">

							<?php
							if ( isset( $_REQUEST['id'] ) && $_REQUEST['id'] != '' ) {
								$project = get_post( $_REQUEST['id'] );
								if ( $project && ( $project->post_author == get_current_user_id() ) ) {
									get_template_part( 'template-parts/edit-project', 'form' );
								} else {
									wp_redirect( home_url() . '/my-projects' );
								}
							} else {
								wp_redirect( home_url() . '/my-projects' );
							}
							?>

                        </div>
                    </div>

                </div>
            </section>

        </div>
    </div>

<?php

get_footer();