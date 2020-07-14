<div class="proposals_freelancers">
    <div class="dashboard_inn">
        <div class="freelancer-bidding">
            <div class="dashboard_title" style="display: block">
                <?php if (sfm_translating_as('freelancer')) : ?>
                    <h2><?php _e( 'My Proposals', ET_DOMAIN ); ?></h2>
	            <?php else : ?>
                    <h2><?php _e( 'Proposals from Freelancers', ET_DOMAIN ); ?>(0)</h2>
                <?php endif; ?>
                <hr>
            </div>

            <div class="proposal_rows">
                <div class="thumb_content">
                    <a class="" href="#">
                        <div class="thumb background_position">
                            <?php echo get_avatar(get_current_user_id(), 150); ?>
                        </div>
                    </a>
                </div>

                <div class="proposal_inn">
                    <div class="d_head">
                        <div class="head_left">
                            <h3><a href="#">###### ##### #####</a></h3>
                            <p>##############</p>
                            <div class="fpp-rating">
                                <div class="rate-it" data-score="0" title="Not rated yet!"><i data-alt="1" class="fa fa-star-o off star-off-png" title="Not rated yet!" aria-hidden="true"></i><span class="sr-only">Not rated yet!</span>&nbsp;<i data-alt="2" class="fa fa-star-o off star-off-png" title="Not rated yet!" aria-hidden="true"></i><span class="sr-only">Not rated yet!</span>&nbsp;<i data-alt="3" class="fa fa-star-o off star-off-png" title="Not rated yet!" aria-hidden="true"></i><span class="sr-only">Not rated yet!</span>&nbsp;<i data-alt="4" class="fa fa-star-o off star-off-png" title="Not rated yet!" aria-hidden="true"></i><span class="sr-only">Not rated yet!</span>&nbsp;<i data-alt="5" class="fa fa-star-o off star-off-png" title="Not rated yet!" aria-hidden="true"></i><span class="sr-only">Not rated yet!</span><input name="score" type="hidden" readonly=""></div>
                            </div>
                        </div>
                        <div class="head_mid">
                            <p><?php _e( 'Completed Projects', ET_DOMAIN ); ?> <span>: 0</span></p>
                        </div>
                        <div class="head_right">
                            <h3>CHF 0000 /<?php _e( 'Day', ET_DOMAIN ) ?></h3>
                            <span><?php _e( 'For', ET_DOMAIN ) ?> 0 <?php _e( 'days', ET_DOMAIN ); ?></span>
                            <p><?php _e( 'Accomplished by', ET_DOMAIN ) ?>: <span>0</span></p>
                            <p><?php _e( 'Company budget', ET_DOMAIN ) ?>: <span>0</span></p>
                            <p><?php _e( 'Company Deadline', ET_DOMAIN ) ?>: <span>00-00-0000</span></p>
                        </div>
                    </div>
                    <div class="content">
                        <div class="col-content-bid-123">
                            <div style="display: inline-block">####### #### #####</div>
                            <a href="#"><?php _e( 'View Details', ET_DOMAIN ); ?></a>
                        </div>
                    </div>
                    <div class="d_footer">
                        <div class="footer_left">
                            <?php if ( !sfm_translating_as( 'freelancer' ) ) : ?>
                                <a class="ie_btn send_message" href="#"><i class="far fa-envelope"></i> <?php _e( 'Send Message', ET_DOMAIN ); ?></a>
                            <?php endif; ?>
                        </div>
                        <div class="footer_right">
							<?php
//                                echo '<a id="" rel="" class="ie_btn hire_now fre-normal-btn btn-accept-bid"><i class="far fa-check-circle"></i>' . __( 'Hire Now', ET_DOMAIN ) . '</a>';
							if ( sfm_translating_as( 'employer' ) ) {
								echo '<a class="ie_btn hire_now fre-normal-btn btn-accept-bid btn-accept-bid-no-escrow" id=""><i class="far fa-check-circle"></i>' . __( 'Hire Now', ET_DOMAIN ) . '</a>';
                                echo '<a class="bid-action ie_btn decline" data-action="cancel" data-bid-id=""><i class="far fa-times-circle"></i> ' . __( 'Decline', ET_DOMAIN ) . '</a>';
							} elseif ( sfm_translating_as('freelancer') ) {
                                echo '<a class="bid-action ie_btn decline" data-action="cancel" data-bid-id=""><i class="far fa-times-circle"></i> ' . __( 'Decline', ET_DOMAIN ) . '</a>';
							} else {
								echo '<a class="ie_btn hire_now fre-normal-btn btn-accept-bid btn-accept-bid-no-escrow" id=""><i class="far fa-check-circle"></i>' . __( 'Hire Now', ET_DOMAIN ) . '</a>';
								echo '<a class="bid-action ie_btn decline" data-action="cancel" data-bid-id=""><i class="far fa-times-circle"></i> ' . __( 'Decline', ET_DOMAIN ) . '</a>';
                            }
							?>
                        </div>
                    </div>
                </div>
            </div><!-- End .proposal_rows -->

			<?php get_template_part( 'template/bid', 'not-item' ); ?>
        </div>
    </div><!-- End .dashboard_inn -->
</div><!-- End .proposals_freelancers -->