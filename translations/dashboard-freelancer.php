<?php
if( ! defined('ABSPATH') ) die( 'No direct access!' );

// Some dummy data
$role_template = 'freelance';
?>
<div class="fre-page-wrapper list-profile-wrapper">
    <div class="profile_dashboard"
         id="freelancer-dashboard">

		<?php get_template_part( 'template-parts/sidebar', 'profile' ); // Dashboard Sidebar ?>

        <section
                id="dashboard_content">
            <!--Dashboard Content Start-->
            <div class="dashboard_inn">

                <div class="dashboard_title">
                    <h2><?php _e( 'My Dashboard', ET_DOMAIN ); ?></h2>
                    <hr>
                </div>

                <div class="notice-first-login">
                    <p>
                        <i class="fa fa-warning"></i><?php _e( 'You must complete your profile to do any activities on site', ET_DOMAIN ) ?>
                    </p>
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
                        <h4><?php _e( 'Recent Proposals', ET_DOMAIN ); ?></h4>

                        <div class="proposals_row sfm-dashboard-bids">
                            <div class="thumb_content">
                                <div class="thumb background_position">
			                        <?php echo get_avatar(get_current_user_id(), '50'); ?>
                                </div>
                            </div>
                            <div class="p_info">
                                <div class="p-info-wraper">
                                    <div class="info-left">
                                        <h4><?php _e( 'Project:', ET_DOMAIN ) ?> 00000000</h4>
                                        <p class="degination"><?php _e( 'Client:', ET_DOMAIN ) ?> <?php echo get_the_author_meta('display_name'); ?></p>
                                    </div>
                                </div>
                                <p><?php _e( 'Bids on:', ET_DOMAIN ) ?> <span>000000</span> | <?php _e( 'Total Bids:', ET_DOMAIN ) ?>
                                    <span>0</span></p>
                                <a class="ie_btn" href="#"><?php _e( 'View Bid', ET_DOMAIN ) ?></a>
                            </div>
                        </div><!-- End .proposals_row -->

                        <?php
                            _e( 'No New Proposals Found!', ET_DOMAIN );
                        ?>
                        <div class="view_all_nfo">
                            <a href="<?php echo esc_url( home_url( 'projects' ) ); ?>"><?php _e( 'View All Projects', ET_DOMAIN ) ?></a>
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