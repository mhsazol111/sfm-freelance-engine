<?php
/**
 * Template Name: Edit Profile
 */

get_header();
?>

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
                        <h2><?php _e( 'Edit Profile', ET_DOMAIN ); ?></h2>
                        <hr>
                    </div>

                    <div class="project_info">
						<?php
						if ( USER_ROLE == 'freelancer' ) {
							get_template_part( 'template-parts/profile-edit-form', 'freelancer' );
						} else {
							get_template_part( 'template-parts/profile-edit-form', 'employer' );
						}
						?>
                    </div><!-- End .project_info -->
                </div>
            </section><!-- End #dashboard_content -->

        </div>
    </div>

    <script type="text/javascript">
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    jQuery('.profile-image img')
                        .attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>

<?php get_footer(); ?>