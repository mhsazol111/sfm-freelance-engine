<?php
/**
 * The template for displaying a bid info item,
 * this template is used to display bid info in a project details,
 * and called at template/list-bids.php
 * @since 1.0
 * @author Dakachi
 */
global $wp_query, $ae_post_factory, $post, $user_ID, $show_bid_info;
$project_object = $ae_post_factory->get( PROJECT );
$project        = $project_object->current_post;
$post_object    = $ae_post_factory->get( BID );
$convert        = $post_object->convert( $post );
$project_status = $project->post_status;
$user_role      = ae_user_role( $user_ID );
if ( isset( $_POST[ 'submit_' . $convert->post_author ] ) ) {
	if ( $user_role == employer ) {
		$wpdb->insert( $wpdb->prefix . 'la_private_messages', array(
			'project_id' => $convert->project_id,
			'author_id'  => $convert->post_author,
			'sender_id'  => $convert->project_author,
			'message'    => 'Hello ' . $convert->profile_display,
		) );
		wp_redirect( get_site_url() . '/messages/' );
	}
}
$bid            = Freelancer::get_bid( get_the_ID() );
$bid_freelancer = Freelancer::get_freelancer( $bid->freelancer_id );
?>
<div class="proposal_rows">
    <div class="thumb_content">
        <a class="" href="<?php echo get_author_posts_url( $convert->post_author ); ?>">
            <div class="thumb background_position" style="background-image: url('');">
				<?php echo $convert->et_avatar; ?>
            </div>
        </a>
    </div>

    <div class="proposal_inn">
        <div class="d_head">
            <div class="head_left">
                <h3>
                    <a href="<?php echo get_author_posts_url( $convert->post_author ); ?>"><?php echo $convert->profile_display; ?>
                    </a>
                </h3>
                <p><?php

					echo $convert->et_professional_title ?></p>

                <div class="fpp-rating">
                    <div class="rate-it" data-score="<?php echo $convert->rating_score; ?>"></div>
                </div>
				<?php
				if ( $convert->flag == 2 ) {
					echo '<div class="free-ribbon"><span class="ribbon"><i class="fa fa-trophy"></i></span></div>';
				}
				?>
            </div>

			<?php //if ( $show_bid_info ) {?>
            <div class="head_mid">
				<?php
				//printf( __( '<p>Experience: <span>%s Years</span></p>', ET_DOMAIN ), $convert->experience );
				printf( __( '<p>Completed Projects: <span>%s</span></p>', ET_DOMAIN ), $convert->total_projects_worked );
				?>
            </div>
			<?php
			//     } else {
			//         echo '<span class="msg-secret-bid">';
			//         _e( 'Only project owner can view this information.', ET_DOMAIN );
			//         echo '</span>';
			// }?>

            <div class="head_right">
				<?php //if ( $show_bid_info ) {?>
                <p class="hidden-lg hidden-md hidden-sm"><?php _e( 'Bid', ET_DOMAIN ); ?></p>
                <h3>CHF <?php echo $bid->bid_daily_wage ?> Per Day</h3>
                <span>For <?php echo $bid->bid_work_days; ?> <?php echo $bid->bid_work_days > 1 ? 'days' : 'day'; ?></span>
                <p>Accomplished by: <span><?php echo date( "d-M-Y", strtotime( $bid->bid_deadline ) ); ?></span></p>
				<p>Company budget: <span><?php echo $project->budget; ?></span></p>
				<p>Company Deadline: <span><?php echo date_i18n( "F j, Y", strtotime( $project->project_deadline ) );; ?></span></p>
				<?php 
				// echo "<pre>";
				// pri_dump($project);
				// echo "</pre>";
				?>
				<?php //} ?>
            </div>
        </div>
        <div class="content">
            <div class="col-content-bid-<?php echo $convert->ID ?>">

				<?php
				if ( $bid->content ) {
					$link = '<a href="/bid/' . $bid->slug . '">Read More</a>';
					echo wp_trim_words( $bid->content, 20, '... ' );
					echo $link;
				}

				// if ( $user_ID == $project->post_author ) {

				// if ( $convert->flag == 1 ) {

				//     if ( ae_get_option( 'use_escrow' ) ) {

				//         echo '<a id="' . get_the_ID() . '" rel="' . $project->ID . '" class="fre-normal-btn btn-accept-bid">' .
				//         __( 'Accept Bid', ET_DOMAIN ) . '</a>';

				//     } else {

				//         echo '<a class="fre-normal-btn btn-accept-bid btn-accept-bid-no-escrow" id="' . get_the_ID() . '">' .
				//         __( 'Accept Bid', ET_DOMAIN ) . '</a>';

				//     }

				// }

				//     if ( in_array( $project_status, array( 'publish' ) ) ) {

				//         do_action( 'ae_bid_item_template', $convert, $project );

				//     }

				// }

				?>

            </div>
        </div>
		<?php if ( $user_ID == $project->post_author ): ?>
            <div class="d_footer">
                <div class="footer_left">
                    <!-- <a class="ie_btn send_message" href="#"><i class="far fa-envelope"></i> Send Message</a> -->
                    <form action="" method="POST" class="edit-form" enctype="multipart/form-data">
                        <button type="submit" name="submit_<?php echo $convert->post_author; ?>"
                                class="ie_btn send_message"><i class="far fa-envelope"></i> Send Message
                        </button>
                    </form>
                </div>

                <div class="footer_right">
					<?php
					if ( $convert->flag == 1 ) {

						if ( ae_get_option( 'use_escrow' ) ) {

							echo '<a id="' . get_the_ID() . '" rel="' . $project->ID . '" class="ie_btn hire_now fre-normal-btn btn-accept-bid"><i class="far fa-check-circle"></i>' .
							     __( 'Hire Now', ET_DOMAIN ) . '</a>';

						} else {

							echo '<a class="ie_btn hire_now fre-normal-btn btn-accept-bid btn-accept-bid-no-escrow" id="' . get_the_ID() . '"><i class="far fa-check-circle"></i>' .
							     __( 'Hire Now', ET_DOMAIN ) . '</a>';

						}
						echo '<a class="bid-action ie_btn decline" data-action="cancel" data-bid-id="' . $convert->ID . '"><i class="far fa-times-circle"></i> ' . __( 'Decline', ET_DOMAIN ) . '</a>';

					}
					?>
                    <!-- <a class="ie_btn hire_now" href="#"><i class="far fa-check-circle"></i> Hire Now</a> -->
                    <!-- <a class="ie_btn decline" href="#"><i class="far fa-times-circle"></i> Decline</a> -->
                </div>
            </div>
		<?php endif; ?>
    </div>

</div><!-- End .proposal_rows -->
