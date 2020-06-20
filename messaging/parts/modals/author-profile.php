<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( "You can't access this file directly" );
}
$job_title = get_author_tag_name( $author );
$a_rating  = Fre_Review::freelancer_rating_score( $author->ID );
?>
<div class="modal fade text-left" id="la_modal_container" tabindex="-1" role="dialog" aria-labelledby="profileModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">Close <i>×</i></span></button>
            </div>
            <div class="modal-body">
                <div class="fre-profile-box" id="my_author_profile_view">
                    <div class="my-author-header">
                        <div class="la_profile_img">
				            <?php echo get_avatar( $author->ID, 100 ); ?>
                        </div>
                        <div class="my-author-title">
                            <h4 id="profileModalLabel"><?= get_short_username( $author ); ?></h4>
                            <p><?php if ( $job_title && 'Freelancer' != $job_title ) { ?>
                                    <span><?php echo $job_title ?></span>
					            <?php } else { ?>
                                    <span><?php _e( 'Author', ET_DOMAIN ) ?></span>
					            <?php } ?>
                            </p>
				            <?php
				            $average_from = 'Avg. from ' . $a_rating['review_count'] . ' ratings';
				            // $average_from .= $a_rating['review_count'] <= 1 ? ' rating' : ' ratings';
				            ?>
                            <p class="green"><?php echo generate_ratings( $a_rating['rating_score'] ); ?>
                                - <?= get_rating_title( $a_rating['rating_score'] ); ?> (<?= $average_from; ?>)
                            </p>
                        </div>
                    </div>

                    <div class="my-author-bio">
                        <span class="bold btn-block"><?php esc_html_e( 'Author bio:', 'link-able' ); ?></span>
			            <?php
                        $author_bio = $author->description;
                        if ( ! empty( $author_bio ) ) {
			                echo '<p>' . $author_bio . '</p>';
                        } else {
	                        echo '<p>' . esc_html__( 'This author is new and has not yet added their author bio.', 'linkable' ) . '</p>';
                        } ?>
                    </div>
                    <div class="my-author-feedbacks">
			            <?php $feedback = get_latest_feedback( $author->ID );
			            if ( count( $feedback ) > 0 ) { ?>
                            <span class="bold btn-block"><?php esc_html_e( 'Feedback & ratings from others who have worked with this author:', 'link-able' ); ?></span>
				            <?php foreach ( $feedback as $k => $fb ) {
					            $r_score   = isset( $fb['rating_score'] ) ? $fb['rating_score'] : 0;
					            $r_feed    = isset( $fb['rating_feedback'] ) ? $fb['rating_feedback'] : 'No feedback given!';
					            $r_project = isset( $fb['project_id'] ) ? $fb['project_id'] : '';
					            ?>
                                <div class="la_latest_review la_feedback_<?= $k; ?>">
                                    <span class="black-rating"><?php echo generate_ratings( $r_score ); ?></span>
                                    <i class="btn-block"><?= empty( $r_feed ) ? 'No feedback given!' : $r_feed; ?></i>
						            <?php if ( ! empty( $r_project ) ) { ?>
                                        <a href="#"><?php esc_html_e( 'View Application' ); ?></a><?php } ?>
                                </div>
				            <?php }
			            } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>