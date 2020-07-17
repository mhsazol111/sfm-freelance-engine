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

$bid            = Freelancer::get_bid( get_the_ID() );
$bid_freelancer = Freelancer::get_freelancer( $bid->freelancer_id );
?>
<div class="proposal_rows">
    <div class="thumb_content">
        <a class="" href="<?php echo get_author_posts_url( $convert->post_author ); ?>">
            <div class="thumb background_position">
				<?php echo $convert->et_avatar; ?>
            </div>
        </a>
    </div>

    <div class="proposal_inn">
        <div class="d_head">
            <div class="head_left">
                <h3><a href="<?php echo get_author_posts_url( $convert->post_author ); ?>"><?php echo $convert->profile_display; ?></a></h3>
                <p><?php echo $convert->et_professional_title ?></p>
                <div class="fpp-rating">
                    <div class="rate-it" data-score="<?php echo $convert->rating_score; ?>"></div>
                </div>
				<?php
				if ( $convert->flag == 2 ) {
					echo '<div class="free-ribbon"><span class="ribbon"><i class="fa fa-trophy"></i></span></div>';
				}
				?>
            </div>


            <div class="head_mid">
                <p><?php echo __( 'Completed Projects', ET_DOMAIN ) . ': <span>'. $convert->total_projects_worked . '</span>'; ?></p>
            </div>

            <div class="head_right">
                <h3>CHF <?php echo $bid->bid_daily_wage ?> /<?php _e( 'Day', ET_DOMAIN ) ?></h3>
                <span><?php _e( 'For', ET_DOMAIN ) ?> <?php echo $bid->bid_work_days; ?> <?php echo $bid->bid_work_days > 1 ? 'days' : 'day'; ?></span>
                <p><?php _e( 'Accomplished by', ET_DOMAIN ) ?>: <span><?php echo date( "d-M-Y", strtotime( $bid->bid_deadline ) ); ?></span></p>
                <p><?php _e( 'Company budget', ET_DOMAIN ) ?>: <span><?php echo $project->budget; ?></span></p>
                <p><?php _e( 'Company Deadline', ET_DOMAIN ) ?>: <span><?php echo date_i18n( "F j, Y", strtotime( $project->project_deadline ) );; ?></span></p>
            </div>
        </div>
        <div class="content">
            <div class="col-content-bid-123">
				<?php
				if ( $bid->content ) {
					$link = '<a href="'. get_permalink(get_the_ID()) .'">' . __('View Details', ET_DOMAIN) . '</a>';
					echo '<div style="display: inline-block">' . wp_trim_words( $bid->content, 80, '... ' ) . '</div>';
					echo $link;
				}
				?>
            </div>
        </div>
		<?php if ( $user_ID == $project->post_author ): ?>
            <div class="d_footer">
                <div class="footer_left">
                    <a class="ie_btn send_message" href="<?php echo esc_url( get_site_url() . '/messages?a_id=' . $bid->freelancer_id . '&p_id=' . $project->ID ) ?>">
                        <i class="far fa-envelope"></i> <?php _e( 'Send Message', ET_DOMAIN ); ?>
                    </a>
                </div>

                <div class="footer_right">
					<?php
					if ( $convert->flag == 1 ) {
						if ( ae_get_option( 'use_escrow' ) ) {
							echo '<a id="' . get_the_ID() . '" rel="' . $project->ID . '" class="ie_btn hire_now fre-normal-btn btn-accept-bid"><i class="far fa-check-circle"></i>' . __( 'Hire Now', ET_DOMAIN ) . '</a>';
						} else {
							echo '<a class="ie_btn hire_now fre-normal-btn btn-accept-bid btn-accept-bid-no-escrow" id="' . get_the_ID() . '"><i class="far fa-check-circle"></i>' . __( 'Hire Now', ET_DOMAIN ) . '</a>';
						}
						echo '<a class="bid-action ie_btn decline" data-action="cancel" data-bid-id="' . $convert->ID . '"><i class="far fa-times-circle"></i> ' . __( 'Decline', ET_DOMAIN ) . '</a>';
					}
					?>
                </div>
            </div>
		<?php endif; ?>
    </div>

</div><!-- End .proposal_rows -->
