<?php

/**
 * Template Name: My Project
 */

if ( ! is_user_logged_in() ) {
	wp_redirect( et_get_page_link( 'login', array( 'ae_redirect_url' => get_permalink( $post->ID ) ) ) );
}

// Redirects an user back to their edit profile to update the profile first
if ( ! get_user_meta( get_current_user_id(), 'user_profile_id', true ) ) {
	wp_redirect( home_url() . '/edit-profile' );
}

get_header();

// translation check
if( sfm_translating_as('employer') ) {

    get_template_part('translations/my-project', 'employer');

}
else if ( sfm_translating_as('freelancer') ){

    get_template_part('translations/my-project', 'freelancer');

} else { ?>

    <div class="fre-page-wrapper">

        <div class="my_projects profile_dashboard"
             id="<?php echo USER_ROLE; ?>-projects">

			<?php get_template_part( 'template-parts/sidebar', 'profile' ); // Dashboard Sidebar ?>

            <section
                    id="dashboard_content">
                <div class="dashboard_inn">

                    <div class="dashboard_title">
                        <h2><?php _e( 'My Projects', ET_DOMAIN ); ?></h2>
                        <hr>
                    </div>

                    <div class="main-dashboard-content dashboard-landing inner-dashboard">
                        <div class="emp-tab-content">

							<?php get_template_part( 'template-parts/components/my-project', 'filter' ); ?>

                            <div id="projects-wrapper"
                                 class="my-projects-wrapper">
                                <div class="projects-wrapper-content">
									<?php if ( 'employer' == USER_ROLE ) : ?>

										<?php
										$e_projects = Employer::get_projects( get_current_user_id(), 'any', 10 );

										if ( $e_projects->posts ) {
											foreach ( $e_projects->posts as $project ) {
												include( locate_template( 'template-parts/components/employer-project-item.php' ) );
											}
											echo Custom::pagination( $e_projects );
										} else {
											get_template_part( 'template-parts/components/project', 'empty' );
										}
										?>

									<?php else : ?>

										<?php
										$f_projects = Freelancer::get_projects( get_current_user_id(), 'any', 10 );

										if ( $f_projects->posts ) {
											foreach ( $f_projects->posts as $project ) {
												include( locate_template( 'template-parts/components/freelancer-project-item.php' ) );
											}
											echo Custom::pagination( $f_projects );
										} else {
											get_template_part( 'template-parts/components/project', 'empty' );
										}
										?>

									<?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

	<?php
}
get_footer( 'dashboard' );