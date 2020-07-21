<?php
global $wp_query, $ae_post_factory, $post, $user_ID;
$post_object     = $ae_post_factory->get( PROJECT );
$convert         = $project = $post_object->convert( $post );
$project_status  = $project->post_status;
$user_role       = ae_user_role( $user_ID );
$et_expired_date = $convert->et_expired_date;
$bid_accepted    = $convert->accepted;
$project_status  = $convert->post_status;
$profile_id      = get_user_meta( $post->post_author, 'user_profile_id', true );
$project_link    = get_permalink( $post->ID );
$currency        = ae_get_option( 'currency', array( 'align' => 'left', 'code' => 'USD', 'icon' => '$' ) );
$avg             = 0;
if ( is_user_logged_in() && ( ( fre_share_role() || $user_role == FREELANCER ) ) ) {
	$bidding_id  = 0;
	$child_posts = get_children(
		array(
			'post_parent' => $project->ID,
			'post_type'   => BID,
			'post_status' => 'publish',
			'author'      => $user_ID,
		)
	);
	if ( ! empty( $child_posts ) ) {
		foreach ( $child_posts as $key => $value ) {
			$bidding_id = $value->ID;
		}
	}
}

$role                = ae_user_role();
$bid_accepted_author = get_post_field( 'post_author', $bid_accepted );
$bid_accepted_author = get_post_field( 'post_author', $bid_accepted );
$profile_id          = $post->post_author;
if ( ( fre_share_role() || $role != FREELANCER ) ) {
	$profile_id = $bid_accepted_author;
}
$currency               = ae_get_option( 'currency', array( 'align' => 'left', 'code' => 'USD', 'icon' => '$' ) );
$comment_for_freelancer = get_comments( array(
	'type'    => 'em_review',
	'status'  => 'approve',
	'post_id' => $bid_accepted
) );

$comment_for_employer = get_comments( array(
	'type'    => 'fre_review',
	'status'  => 'approve',
	'post_id' => get_the_ID()
) );

$freelancer_info = get_userdata( $bid_accepted_author );
$ae_users        = AE_Users::get_instance();
$freelancer_data = $ae_users->convert( $freelancer_info->data );

$is_bid_cancelled = false;
if ( USER_ROLE == 'freelancer' ) {
	$cancelled_bids = new WP_Query( array(
		'post_type'       => BID,
		'author'          => get_current_user_id(),
		'post_parent__in' => array( get_the_ID() ),
		'post_status'     => 'unaccept',
	) );
	if ( $cancelled_bids->posts ) {
		$is_bid_cancelled = true;
	}
}

if ( ( fre_share_role() || $role == FREELANCER ) && $project_status == 'complete' && ! empty( $comment_for_freelancer ) ) { ?>
    <div class="project-detail-box">
        <div class="project-employer-review">
            <span class="employer-avatar-review"><?php echo $convert->et_avatar; ?></span>
            <h2><a href="<?php echo $convert->author_url; ?>" target="_blank"><?php echo $convert->author_name; ?></a>
            </h2>
            <p><?php echo '"' . $comment_for_freelancer[0]->comment_content . '"'; ?></p>
            <div class="rate-it"
                 data-score="<?php echo get_comment_meta( $comment_for_freelancer[0]->comment_ID, 'et_rate', true ); ?>"></div>
			<?php if ( empty( $comment_for_employer ) ) { ?>
                <a href="#" id="<?php the_ID(); ?>"
                   class="fre-normal-btn btn-complete-project"> <?php _e( 'Review for Company', ET_DOMAIN ); ?></a>
			<?php } ?>
        </div>
    </div>
<?php } else if ( ( fre_share_role() || $role == EMPLOYER ) && $project_status == 'complete' && ! empty( $comment_for_employer ) ) { ?>
    <div class="project-detail-box">
        <div class="project-employer-review">
            <span class="employer-avatar-review"><?php echo $freelancer_data->avatar; ?></span>
            <h2>
                <a href="<?php echo $freelancer_data->author_url; ?>"
                   target="_blank"><?php echo $freelancer_data->display_name; ?></a>
            </h2>
            <p><?php echo '"' . $comment_for_employer[0]->comment_content . '"'; ?></p>
            <div class="rate-it"
                 data-score="<?php echo get_comment_meta( $comment_for_employer[0]->comment_ID, 'et_rate', true ); ?>"></div>
        </div>
    </div>
<?php } ?>

<div class="dashboard_title single-project-top-meta-desc">
    <div class="d_t_info">
        <h2 class="project-detail-title"><?php the_title(); ?></h2>
        <div class="e_nav">
			<?php if ( $project->total_bids > 0 ) {
				echo '<i class="fas fa-user-friends"></i>' . __( ' Number of Bids:', ET_DOMAIN ) . '<span class="secondary-color"> ' . $project->total_bids . '</span> |';
			} else {
				echo '<i class="fas fa-user-friends"></i>' . __( ' Number of Bids:', ET_DOMAIN ) . '<span class="secondary-color"> 0</span> |';
			} ?>
            <i class="far fa-check-circle"></i><?php _e( 'Project Status: ', ET_DOMAIN ); ?>
            <span>
                <?php
                $status_arr = array(
	                'close'     => __( "Ongoing", ET_DOMAIN ),
	                'complete'  => __( "Completed", ET_DOMAIN ),
	                'disputing' => __( "Disputed", ET_DOMAIN ),
	                'disputed'  => __( "Resolved", ET_DOMAIN ),
	                'publish'   => __( "Active", ET_DOMAIN ),
	                'pending'   => __( "Pending", ET_DOMAIN ),
	                'draft'     => __( "Pending", ET_DOMAIN ),
	                'reject'    => __( "Rejected", ET_DOMAIN ),
	                'archive'   => __( "Archived", ET_DOMAIN ),
                );
                if ( $is_bid_cancelled ) {
	                _e( 'Proposal Declined', ET_DOMAIN );
                } else {
	                echo $status_arr[ $post->post_status ];
                }
                ?></span> |
            <i class="far fa-clock"></i><?php _e( 'Posted on: ', ET_DOMAIN ); ?>
            <span class="secondary-color"><?php echo $project->post_date; ?></span> |
			<?php if ( $post->post_status == 'close' || $post->post_status == 'disputing' ) { ?>
                <i class="fas fa-trophy"></i>
				<?php _e( 'Winning Bid: ', ET_DOMAIN ); ?>
                <span><?php echo $project->bid_budget_text; ?></span> |
			<?php } ?>
            <i class="fas fa-trophy"></i>
			<?php _e( 'Budget: ', ET_DOMAIN ); ?>
            <span>
                <?php
                if ( is_numeric( $project->et_budget ) ) { ?>
                    CHF <?php echo $project->et_budget;
                } else {
	                echo $project->et_budget;
                } ?>
            </span> |
            <i class="fas fa-hourglass-half"></i>
			<?php _e( 'Deadline: ', ET_DOMAIN ); ?>
            <span><?php echo date_i18n( "F j, Y", strtotime( $project->project_deadline ) );; ?></span>
        </div>

    </div>
    <div class="b_t_right">
        <div class="project-detail-action">
			<?php
			if ( is_user_logged_in() ) {
				if ( $project_status == 'publish' ) {
					if ( ( fre_share_role() || $user_role == FREELANCER ) && $user_ID != $project->post_author ) {
						$has_bid = fre_has_bid( get_the_ID() );
						if ( $has_bid ) {
						    if (!$is_bid_cancelled) {
							    echo '<a class="fre-normal-btn primary-bg-color bid-action" data-action="cancel" data-bid-id="' . $bidding_id . '"><i class="fa fa-check-circle-o" aria-hidden="true"></i> ' . __( 'Cancel', ET_DOMAIN ) . '</a>';
						    }
						} else {
							echo '<a class="fre-action-btn" href="' . et_get_page_link( 'submit-proposal', array( 'id' => $project->ID ) ) . '"><i class="fa fa-check-circle-o" aria-hidden="true"></i> ' . __( 'Send Proposal', ET_DOMAIN ) . '</a>';
						}
					} else if ( ( ( fre_share_role() || $user_role == EMPLOYER ) || current_user_can( 'manage_options' ) ) && $user_ID == $project->post_author ) {
						echo '<a class="custom-project-action" data-action="archive" data-project-id="' . $project->ID . '"> ' . __( 'Archive This Project', ET_DOMAIN ) . '</a>';
					} else {
						echo '<a href="' . et_get_page_link( 'submit-project' ) . '" class="fre-normal-btn primary-bg-color"><i class="fa fa-check-circle-o" aria-hidden="true"></i> ' . __( 'Post Project Like This', ET_DOMAIN ) . '</a>';
					}
				} else if ( $project_status == 'disputing' || $project_status == 'disputed' ) {
					$bid_accepted_author = get_post_field( 'post_author', $bid_accepted );
					if ( (int) $project->post_author == $user_ID || $bid_accepted_author == $user_ID || current_user_can( 'manage_options' ) ) {
						echo '<a class="fre-normal-btn" href="' . add_query_arg( array( 'dispute' => 1 ), $project_link ) . '"><i class="fa fa-check-circle-o" aria-hidden="true"></i> ' . __( 'Dispute Page', ET_DOMAIN ) . '</a>';
					}
				} else if ( $project_status == 'complete' ) {
					$bid_accepted_author = get_post_field( 'post_author', $bid_accepted );
					if ( (int) $project->post_author == $user_ID || $bid_accepted_author == $user_ID ) {
					} else if ( current_user_can( 'manage_options' ) && ae_get_option( 'use_escrow' ) ) {
						$bid_id_accepted = get_post_meta( $post->ID, 'accepted', true );
						$order           = get_post_meta( $bid_id_accepted, 'fre_bid_order', true );
						$order_status    = get_post_field( 'post_status', $order );
						$commission      = get_post_meta( $bid_id_accepted, 'commission_fee', true );
						if ( $commission ) {
							if ( $order_status != 'finish' ) {
								echo '<a class="fre-normal-btn primary-bg-color manual-transfer" data-project-id="' . $project->ID . '"><i class="fa fa-check-circle-o" aria-hidden="true"></i> ' . __( "Transfer Money", ET_DOMAIN ) . '</a>';
							} else {
								if ( ae_get_option( 'manual_transfer', false ) ) {
									echo '<span class="fre-money-transfered">';
									_e( "Already Transferred", ET_DOMAIN );
									echo '</span>';
								}
							}
						}
					}
				} else if ( $project_status == 'pending' ) {
					if ( ( fre_share_role() || $user_role == EMPLOYER ) && $user_ID == $project->post_author ) {
						echo '<a class="fre-action-btn" style="margin-right: 10px;" href="' . et_get_page_link( 'edit-project', array( 'id' => $project->ID ) ) . '">' . __( 'Edit', ET_DOMAIN ) . '</a>';
					} else if ( current_user_can( 'manage_options' ) ) {
						echo '<a class="fre-normal-btn primary-bg-color project-action" data-action="approve" data-project-id="' . $project->ID . '"><i class="fa fa-check-circle-o" aria-hidden="true"></i> ' . __( 'Approve', ET_DOMAIN ) . '</a>';
						echo '<a class="fre-normal-btn primary-bg-color project-action" data-action="reject" data-project-id="' . $project->ID . '"><i class="fa fa-check-circle-o" aria-hidden="true"></i> ' . __( 'Reject', ET_DOMAIN ) . '</a>';
					}
				} else if ( $project_status == 'reject' ) {
					if ( ( fre_share_role() || $user_role == EMPLOYER ) && $user_ID == $project->post_author ) {
						echo '<a class="fre-action-btn 1" style="margin-right: 10px;" href="' . et_get_page_link( 'edit-project', array( 'id' => $project->ID ) ) . '">' . __( 'Edit', ET_DOMAIN ) . '</a>';
					}
				} else if ( $project_status == 'draft' ) {
					if ( ( fre_share_role() || $user_role == EMPLOYER ) && $user_ID == $project->post_author ) {
						echo '<a class="fre-action-btn 2" style="margin-right: 10px;" href="' . et_get_page_link( 'edit-project', array( 'id' => $project->ID ) ) . '">' . __( 'Edit', ET_DOMAIN ) . '</a>';
						echo '<a class="custom-project-action" data-action="delete" data-project-id="' . $project->ID . '">' . __( 'Delete', ET_DOMAIN ) . '</a>';
					} else if ( current_user_can( 'manage_options' ) ) {
						echo '<a class="custom-project-action" data-action="delete" data-project-id="' . $project->ID . '">' . __( 'Delete', ET_DOMAIN ) . '</a>';
					}
				} else if ( $project_status == 'archive' ) {
					if ( ( fre_share_role() || $user_role == EMPLOYER ) && $user_ID == $project->post_author ) {
//                            echo '<a class="fre-action-btn" href="' . et_get_page_link( 'submit-project', array( 'id' => $project->ID ) ) . '">' . __( 'Renew', ET_DOMAIN ) . '</a>';
						echo '<a class="custom-project-action" data-action="delete" data-project-id="' . $project->ID . '">' . __( 'Delete', ET_DOMAIN ) . '</a>';
					} else if ( current_user_can( 'manage_options' ) ) {
						echo '<a class="custom-project-action" data-action="delete" data-project-id="' . $project->ID . '">' . __( 'Delete', ET_DOMAIN ) . '</a>';
					}
				}
			} else {
				if ( $project_status == 'publish' ) {
					echo '<a class="fre-normal-btn primary-bg-color" href="' . et_get_page_link( 'login', array( 'ae_redirect_url' => $project->permalink ) ) . '"><i class="fa fa-check-circle-o" aria-hidden="true"></i>' . __( 'Send Proposal', ET_DOMAIN ) . '</a>';
				}
			}
			?>
			<?php
			if ( $post->post_status == 'close' ) {
				if ( (int) $project->post_author == $user_ID ) { ?>
                    <a title="<?php _e( 'Finish', ET_DOMAIN ); ?>" href="#" id="<?php the_ID(); ?>"
                       class="fre-action-btn btn-complete-project"> <?php _e( 'Finish', ET_DOMAIN ); ?></a>
					<?php if ( ae_get_option( 'use_escrow' ) ) { ?>
                        <a title="<?php _e( 'Close', ET_DOMAIN ); ?>" href="#" id="<?php the_ID(); ?>"
                           class="fre-action-btn btn-close-project"><?php _e( 'Close', ET_DOMAIN ); ?></a>
					<?php }
				} else {
					if ( $bid_accepted_author == $user_ID && ae_get_option( 'use_escrow' ) ) { ?>
                        <a title="<?php _e( 'Discontinue', ET_DOMAIN ); ?>" href="#" id="<?php the_ID(); ?>"
                           class="fre-action-btn btn-quit-project"><?php _e( 'Discontinue', ET_DOMAIN ); ?></a>
					<?php }
				}
			} else if ( $post->post_status == 'disputing' ) { ?>
                <a href="<?php echo add_query_arg( array( 'dispute' => 1 ), $project_link ) ?>"
                   class="fre-normal-btn"><?php _e( 'Dispute Page', ET_DOMAIN ) ?></a>
			<?php } ?>
        </div>
    </div>
</div>
<hr>