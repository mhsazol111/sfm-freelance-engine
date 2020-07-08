<?php
if( ! defined('ABSPATH') ) die( 'No direct access!' );

// Some dummy data
$role_template = 'employer';
?>
 <div class="fre-page-wrapper list-profile-wrapper">
    <div class="profile_dashboard"
         id="employer-dashboard">

		<?php get_template_part( 'template-parts/sidebar', 'profile' ); // Dashboard Sidebar ?>

        <section
                id="dashboard_content">
            <!--Dashboard Content Start-->
            <div class="dashboard_inn">

                <div class="dashboard_title">
                    <h2><?php _e( 'My Dashboard', ET_DOMAIN ); ?></h2>
                    <hr>
                </div>

				<?php include( locate_template( 'template-parts/components/dashboard-cards.php' ) ); ?>


                <div class="others_info">


                    <div class="latest_messages">
                        <h4><?php _e( 'Latest Messages', ET_DOMAIN ) ?></h4>


						<?php // Employer::get_messages( get_current_user_id() ); ?>

	                    <h5><?php _e( 'No new message found!', ET_DOMAIN ); ?></h5>

                        <div class="view_all_nfo">
                            <a href="<?php echo get_site_url() . '/messages'; ?>"><?php _e( 'View All Messages', ET_DOMAIN ) ?></a>
                        </div>
                    </div>
                    <!-- End .latest_messages -->


                    <div class="recent_proposals">
                        <h4><?php _e( 'New bids on the projects', ET_DOMAIN ); ?></h4>


	                    <div class="proposals_row sfm-dashboard-bids">
		                    <div class="thumb_content">
			                    <div class="thumb background_position">
				                    <?php echo get_avatar(get_current_user_id(), '50'); ?>
			                    </div>
		                    </div>
		                    <div class="p_info">
			                    <div class="p-info-wraper">
				                    <div class="info-left">
					                    <h4><?php echo get_the_author_meta('display_name'); ?></h4>
					                    <p><?php _e( "Completed Project:", ET_DOMAIN ); ?> <span>0</span></p>
				                    </div>
				                    <div class="info-right">
					                    <p class="info-price"><?php _e('CHF', ET_DOMAIN); ?> 000<?php _e( "/day", ET_DOMAIN ); ?></p>
					                    <p class="info-week"><?php _e( "in", ET_DOMAIN ); ?> 00 <?php _e( "days", ET_DOMAIN ); ?></p>
				                    </div>
			                    </div>

			                    <p class="link-title"><?php _e( "Project:", ET_DOMAIN ); ?> 000000000</p>
			                    <a class="ie_btn" href="#"><?php _e( "View Bid", ET_DOMAIN ); ?></a>
		                    </div>
	                    </div><!-- End .proposals_row -->

						<?php
							_e( 'No New Bids Found!', ET_DOMAIN );
						?>

                        <div class="view_all_nfo">
                            <a href="<?php echo esc_url( home_url( 'my-projects' ) ); ?>"><?php _e( 'View All Projects', ET_DOMAIN ) ?></a>
                        </div>
                    </div>
                    <!-- End .recent_proposals -->


                </div>
                <!-- End .others_info -->
            </div>

        </section>
        <!-- End #dashboard_content -->

    </div>

</div>