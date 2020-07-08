<?php

global $wp_query, $ae_post_factory, $post, $user_ID, $show_bid_info;
$post_object = $ae_post_factory->get( PROJECT );
$convert = $project = $post_object->current_post;
$project = $post_object->convert( $post );
$author_id = $project->post_author;
$rating = Fre_Review::employer_rating_score( $author_id );
$user_data = get_userdata( $author_id );
$profile_id = get_user_meta( $author_id, 'user_profile_id', true );
$profile = array();
if ( $profile_id ) {
	$profile_post = get_post( $profile_id );
	if ( $profile_post && ! is_wp_error( $profile_post ) ) {
		$profile = $post_object->convert( $profile_post );
	}
}
$hire_freelancer = fre_count_hire_freelancer( $author_id );
$attachment = get_children( array(
	'numberposts' => - 1,
	'order' => 'ASC',
	'post_parent' => $post->ID,
	'post_type' => 'attachment',
), OBJECT );
$bid_object = $ae_post_factory->get( BID );
$bid_convert = $bid_object->convert( $post );
$sfm_user_access = ae_user_role( $user_ID );

$project    = Employer::get_project( get_the_ID() );
$employer   = Employer::get_employer( $project->employer_id );
$country 	= get_the_terms($employer->user_profile_id, 'country');
//pri_dump($country);
?>

<div class="project_content">
    <h3><?php _e( 'Project Brief', ET_DOMAIN ); ?></h3>
    <p><?php the_content(); ?></p>
</div>
<hr>

<div class="project_info">
    <div class="<?php echo ( $sfm_user_access == "employer" ) ? "employer" : "default"; ?> info_left">
        <div class="skill_req">
			<?php
			if ( ! empty( $convert->skill ) ) {
				list_tax_of_project( get_the_ID(), __( 'Skills Required', ET_DOMAIN ), 'skill' );

				echo "<hr>";
			}
			?>
            <h4><?php _e( 'Project Category', ET_DOMAIN ); ?></h4>
			<?php echo Employer::get_project_terms( get_the_ID(), 'project_category', true ); ?>
            <hr>
        </div>


		<?php if ( ! empty( $attachment ) ): ?>
            <h4><?php _e( 'File Attached', ET_DOMAIN ); ?></h4>
            <div class="file_attached">
				<?php
				foreach ( $attachment as $key => $att ) {

					$file_type = wp_check_filetype( $att->post_title, array(

							'jpg' => 'image/jpeg',

							'jpeg' => 'image/jpeg',

							'gif' => 'image/gif',

							'png' => 'image/png',

							'bmp' => 'image/bmp',

						)

					);

					echo '<a href="' . $att->guid . '" download><i class="fas fa-paperclip"></i><span>' . $att->post_title . '</span> <i
                    class="fas fa-download"></i></a>';

				}

				?>
            </div>
		<?php endif; ?>
        <?php if( 'employer' == USER_ROLE ) {
            $invitations = sfmInvitations::getInvitations( $project->id );
            if ( ! empty( $invitations ) ) { ?>
                <h4><?php _e( 'Invitation Sent', ET_DOMAIN ); ?></h4>
                <p><?php _e('Total invitations sent', ET_DOMAIN ); ?>: <strong><?php echo count( $invitations ); ?></strong>
                    <a href="javascript:void(0)" onclick="jQuery('#sfm_invitations_items').slideToggle();"><i><?php _e( 'Expand details', ET_DOMAIN ); ?></i></a></p>
                <div id="sfm_invitations_items" style="display: none;">
                    <?php foreach ( $invitations as $invitation ) {
                        if( empty( $invitation) ) continue;
	                    $freelancer = Freelancer::get_freelancer( $invitation ); ?>
                        <p>
                            <a href="<?php echo $freelancer->slug; ?>"><?php echo $freelancer->display_name; ?> <?php echo '(<i>' .get_the_author_meta('email') . '</i> )'; ?></a>
                        </p>
                    <?php } ?>
                </div>
            <?php
            } // If any invitation found    
        } //if employer ?>
    </div>

    <div class="<?php echo ( $sfm_user_access == "employer" ) ? "employer" : "default"; ?> info_right">

        <div class="proposals_row">
            <div class="thumb_content">
                <div class="thumb background_position">
                    <a class="" href="<?php echo $employer->slug; ?>">
                        <div class="thumb background_position">
							<img src="<?php echo $employer->et_avatar_url; ?>" alt="<?php echo $employer->display_name; ?>">
                        </div>
                    </a>
                    <div class="fpp-rating freelancer">
                        <div class="rate-it" data-score="<?php echo $employer->rating_score; ?>"></div>
                    </div>
                </div>
            </div>

            <div class="person_info">
                <h4>
					<a href="<?php echo $employer->slug; ?>"><?php echo $employer->company_name; ?></a>
				</h4>
                <!-- <p><?php //echo $employer->company_name; ?></p> -->
				<p><?php foreach($country as $a ) { echo $a->name; } ?>, <?php echo $employer->city_name; ?></p>
            </div>
            <hr>

            <div class="proposals_info">

                <p><?php printf( __( '<span>%s</span> Total posted projects so far', ET_DOMAIN ), fre_count_user_posts_by_type( $author_id, 'project', '"publish","complete","close","disputing","disputed", "archive" ', true ) ); ?></p>
                <p><?php printf( __( '<span>%s</span> Completed Projects so far.', ET_DOMAIN ), fre_count_user_posts_by_type( $author_id, 'project', '"complete"', true ) ); ?></p>
                <p><?php printf( __( '<span>%s</span> Declined Project so far.', ET_DOMAIN ), $hire_freelancer ); ?>
                </p>
            </div>
            <hr class="bottom_hr">

            <div class="open_projects">
                <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php _e( 'Open Projects by this
                    Client', ET_DOMAIN ) ?></a>
            </div>
        </div><!-- End .proposals_row -->

    </div>
</div>


<div class="project-detail-box-01 no-padding-01">

    <div class="project-detail-extend-01">

		<?php
		//milestone

		$args = array(

			'post_type' => 'ae_milestone',

			'posts_per_page' => - 1,

			'post_status' => 'any',

			'post_parent' => $project->id,

			'orderby' => 'meta_value',

			'order' => 'ASC',

			'meta_key' => 'position_order',

		);

		$query = new WP_Query( $args );

		if ( function_exists( 'ae_query_milestone' ) && $query->have_posts() ) { ?>


            <div class="project-detail-milestone">

                <h4><?php echo __( "Milestones", ET_DOMAIN ); ?></h4>

				<?php do_action( 'after_sidebar_single_project', $project ); ?>

            </div>


		<?php } ?>



		<?php

		//Customfields

		if ( function_exists( 'et_render_custom_field' ) ) {

			et_render_custom_field( $project );

		}

		?>


    </div>

</div>