    <?php
/**
 * The Template for displaying all single posts
 *
 * @package WordPress
 * @subpackage FreelanceEngine
 * @since FreelanceEngine 1.0
 */

// Redirects an user back to their edit profile to update the profile first
if ( ! get_user_meta( get_current_user_id(), 'user_profile_id', true ) ) {
	wp_redirect( home_url() . '/edit-profile' );
}


get_header();
global $wp_query, $ae_post_factory, $post, $user_ID, $show_bid_info;
$post_object     = $ae_post_factory->get( PROJECT );
$convert         = $post_object->convert( $post );
$bid_object      = $ae_post_factory->get( BID );
$bid_convert     = $bid_object->convert( $post );
$sfm_user_access = ae_user_role( $user_ID );
$bid             = Freelancer::get_bid( get_the_ID() );
$project_id = $bid->project_id;
$project    = Employer::get_project( $project_id );
$employer   = Employer::get_employer( $project->employer_id );

$attachment = get_children( array(
	'numberposts' => - 1,
	'order' => 'ASC',
	'post_parent' => $bid_convert->ID,
	'post_type' => 'attachment',
), OBJECT );
// pri_dump($attachment);
if ( have_posts() ) {
	the_post(); ?>

    <div class="fre-page-wrapper single-bid-wrapper">
        <div class="profile_dashboard" id="<?php echo $role_template; ?>-dashboard">

			<?php get_template_part( 'template-parts/sidebar', 'profile' ); // Dashboard Sidebar ?>

            <section id="dashboard_content">

                <div class="dashboard_inn" id="bid-single-inner">
                    <div class="d_head">
                        <div class="head_left">
                            <div class="head-left-one">
                                <h3><?php the_title(); ?></h3>
                                <div class="e_nav">
                                    <?php _e( 'Posted on:', ET_DOMAIN ) ?> <span><?php echo $convert->post_date; ?></span> &nbsp;|&nbsp; <?php _e( 'Project
                                    Status:', ET_DOMAIN ) ?>
                                    <span><?php 
                                    $bid_stat = $convert->status_text;
                                    if('ACTIVE' == strtoupper($bid_stat)) {
                                        echo "Pending";
                                    }else{
                                        echo $bid_stat;
                                    }
                                    ?></span>
                                    &nbsp;|&nbsp; <?php _e( 'Total Bids:', ET_DOMAIN ) ?> <span><?php echo $bid_convert->total_bids; ?></span>

                                </div>
                                <div class="e_nav nav2">
                                    <?php _e( 'Posted By:', ET_DOMAIN ) ?> <span><?php echo $employer->display_name; ?></span> &nbsp;|&nbsp;
                                    <?php _e( 'Company:', ET_DOMAIN ) ?> <span><?php echo $employer->company_name; ?></span>
                                </div>
                            </div>
                            <div class="head-left-two">
                            <?php
                                // if ( $convert->flag == 1 ) {

//                                    if ( ae_get_option( 'use_escrow' ) ) {
//
//                                        echo '<a id="' . get_the_ID() . '" rel="' . $project->ID . '" class="ie_btn hire_now fre-normal-btn btn-accept-bid"><i class="far fa-check-circle"></i>' .
//                                            __( 'Hire Now', ET_DOMAIN ) . '</a>';
//
//                                    } else {
//
//                                        echo '<a class="ie_btn hire_now fre-normal-btn btn-accept-bid btn-accept-bid-no-escrow" id="' . get_the_ID() . '"><i class="far fa-check-circle"></i>' .
//                                            __( 'Hire Now', ET_DOMAIN ) . '</a>';
//
//                                    }
                                // }
                            ?>
                                <a href="<?php echo get_permalink($project_id) ?>" class="ie_btn"><?php _e( 'View Project', ET_DOMAIN ) ?></a>
                            </div>
                            <div class="divider">
                                </hr>
                            </div>
                            <div class="content">
								<?php the_content(); ?>
                            </div>
                            <div class="divider">
                                </hr>
                            </div>
                            <?php if ( ! empty( $attachment ) ): ?>
                                <div class="bid-file-attached">
                                    <h4><?php _e( 'File Attached', ET_DOMAIN ); ?></h4>
                                    <div class="file_attached">
                                        <?php
                                        foreach ( $attachment as $key => $att ) {
                                            echo '<a href="' . $att->guid . '" download><i class="fas fa-paperclip"></i><span>' . $att->post_title . '</span> <i
                                            class="fas fa-download"></i></a>';
                                        }

                                        ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class=" head_right">
                            <div class="freelancer_row">
                                <div class="freelancer-top" style="align-items: center">
                                    <div class="thumb_content">
                                        <div class="thumb" style="background-image: url()">
											<?php echo $bid_convert->et_avatar; ?>
                                        </div>
                                    </div>
                                    <div class="person_info">
                                        <h4><?php echo $bid_convert->profile_display; ?></h4>
                                        <p style="margin-bottom: 0;margin-top: 3px;"><?php echo $bid_convert->et_professional_title; ?></p>
<!--                                        <div class="fpp-rating">-->
<!--                                            <div class="rate-it"-->
<!--                                                 data-score="--><?php //echo $convert->rating_score; ?><!--"></div>-->
<!--                                        </div>-->
                                    </div>
                                </div>
                                <div class="freelancer_info">
                                    <p><i class="far fa-money-bill-alt" aria-hidden="true"></i> <?php _e( 'Proposal:', ET_DOMAIN ) ?>
                                        <span>CHF <?php echo $bid->bid_daily_wage; ?><?php _e( '/Days', ET_DOMAIN ) ?></span></p>
                                    <p><i class="far fa-clock" aria-hidden="true"></i> <?php _e( 'Work Days:', ET_DOMAIN ) ?>
                                        <span><?php _e( 'In', ET_DOMAIN ) ?> <?php echo $bid->bid_work_days; ?> <?php _e( 'Day', ET_DOMAIN ) ?></span></p>
                                    <p><i class="far fa-clock" aria-hidden="true"></i> <?php _e( 'Deadline:', ET_DOMAIN ) ?>
                                        <span><?php echo date( "d-M-Y", strtotime( $bid->bid_deadline ) ); ?></span></p>
                                    <p><i class="far fa-check-circle" aria-hidden="true"></i> <?php _e( 'Completed Project:', ET_DOMAIN ) ?>
                                        <span><?php echo $bid_convert->total_projects_worked; ?></span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </section>

        </div>
    </div>
<?php }
get_footer();