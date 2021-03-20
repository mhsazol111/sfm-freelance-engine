<?php
/**
 * Template Name: Notification Settings
 */

get_header();

// Redirects an user back to their edit profile to update the profile first
if ( ! get_user_meta( get_current_user_id(), 'user_profile_id', true ) ) {
	wp_redirect( home_url() . '/edit-profile' );
}

if ( sfm_is_translating() ) {
	get_template_part( 'translations/notification-settings', 'form' );
} else { ?>

    <div class="fre-page-wrapper list-profile-wrapper">
        <div class="profile_dashboard" id="<?php echo USER_ROLE; ?>-dashboard">

			<?php get_template_part( 'template-parts/sidebar', 'profile' ); // Dashboard Sidebar ?>

            <section id="dashboard_content">
                <div class="dashboard_inn">
					<?php
					if ( ! get_user_meta( get_current_user_id(), 'user_profile_id', true ) ) {
						echo '<h4 class="complete-profile-notice">You have to update the profile first to access anything!</h4>';
					}
					?>

                    <div class="dashboard_title">
                        <h2><?php _e( 'Notification Settings', ET_DOMAIN ); ?></h2>
                        <hr>
                    </div>

                    <div class="project_info">
						<?php get_template_part( 'template-parts/notification-settings', 'form' ); ?>
                    </div><!-- End .project_info -->
                </div>
            </section><!-- End #dashboard_content -->

        </div>
    </div>

	<?php
}
get_footer();