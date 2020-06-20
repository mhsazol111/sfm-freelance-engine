<?php

/**
 * Template Name: Member Profile Page
 */


// Redirects an user back to their edit profile to update the profile first
if ( ! get_user_meta( get_current_user_id(), 'user_profile_id', true ) ) {
	wp_redirect( home_url() . '/edit-profile' );
}

global $wp_query, $ae_post_factory, $post, $current_user, $user_ID;

//convert current user
$ae_users  = AE_Users::get_instance();
$user_data = $ae_users->convert( $current_user->data );
$user_role = ae_user_role( $current_user->ID );
//convert current profile
$post_object = $ae_post_factory->get( PROFILE );
$profile_id  = get_user_meta( $user_ID, 'user_profile_id', true );
$profile     = array();
if ( $profile_id ) {
	$profile_post = get_post( $profile_id );
	if ( $profile_post && ! is_wp_error( $profile_post ) ) {
		$profile = $post_object->convert( $profile_post );
	}
}


//get profile skills

$current_skills = get_the_terms( $profile, 'skill' );

//define variables:

$skills = isset( $profile->tax_input['skill'] ) ? $profile->tax_input['skill'] : array();

$job_title = isset( $profile->et_professional_title ) ? $profile->et_professional_title : '';

$hour_rate = isset( $profile->hour_rate ) ? $profile->hour_rate : '';

$currency = isset( $profile->currency ) ? $profile->currency : '';

$experience = isset( $profile->et_experience ) ? $profile->et_experience : '';

$hour_rate = isset( $profile->hour_rate ) ? $profile->hour_rate : '';

$about = isset( $profile->post_content ) ? $profile->post_content : '';

$display_name = $user_data->display_name;

$user_available = isset( $user_data->user_available ) && $user_data->user_available == "on" ? 'checked' : '';

$country = isset( $profile->tax_input['country'][0] ) ? $profile->tax_input['country'][0]->name : '';

$category = isset( $profile->tax_input['project_category'][0] ) ? $profile->tax_input['project_category'][0]->slug : '';


get_header();

// Handle email change requests

$user_meta = get_user_meta( $user_ID, 'adminhash', true );


if ( ! empty( $_GET['adminhash'] ) ) {

	if ( is_array( $user_meta ) && $user_meta['hash'] == $_GET['adminhash'] && ! empty( $user_meta['newemail'] ) ) {

		wp_update_user( array(

			'ID' => $user_ID,

			'user_email' => $user_meta['newemail']

		) );

		delete_user_meta( $user_ID, 'adminhash' );

	}

	echo "<script> window.location.href = '" . et_get_page_link( "profile" ) . "'</script>";

} elseif ( ! empty( $_GET['dismiss'] ) && 'new_email' == $_GET['dismiss'] ) {

	delete_user_meta( $user_ID, 'adminhash' );

	echo "<script> window.location.href = '" . et_get_page_link( "profile" ) . "'</script>";

}


$rating = Fre_Review::employer_rating_score( $user_ID );

$role_template = 'employer';

if ( fre_share_role() || ae_user_role( $user_ID ) == FREELANCER ) {

	$rating = Fre_Review::freelancer_rating_score( $user_ID );

	$role_template = 'freelance';

}


$projects_worked = get_post_meta( $profile_id, 'total_projects_worked', true );

$project_posted = fre_count_user_posts_by_type( $user_ID, 'project', '"publish","complete","close","disputing","disputed", "archive" , "draft" ', true );

$hire_freelancer = fre_count_hire_freelancer( $user_ID );


$currency = ae_get_option( 'currency', array(

	'align' => 'left',

	'code' => 'USD',

	'icon' => '$'

) );

?>

<!---->
<?php
//$m = new Email_Notification();
//$m->email();
//?>


<div class="fre-page-wrapper list-profile-wrapper">
    <div class="profile_dashboard" id="<?php echo USER_ROLE; ?>-dashboard">

		<?php get_template_part( 'template-parts/sidebar', 'profile' ); // Dashboard Sidebar ?>

        <section id="dashboard_content"> <!--Dashboard Content Start-->
            <div class="dashboard_inn">

                <div class="dashboard_title">
                    <h2><?php _e( 'My Dashboard', ET_DOMAIN ); ?></h2>
                    <hr>
                </div>

				<?php if ( empty( $profile_id ) && ( fre_share_role() || ae_user_role( $user_ID ) == FREELANCER ) ) { ?>

                    <div class="notice-first-login">
                        <p>
                            <i class="fa fa-warning"></i><?php _e( 'You must complete your profile to do any activities on site', ET_DOMAIN ) ?>
                        </p>
                    </div>

				<?php } ?>

				<?php include( locate_template( 'template-parts/components/dashboard-cards.php' ) ); ?>


                <div class="others_info">


                    <div class="latest_messages">
                        <h4>Latest Messages</h4>


						<?php // Employer::get_messages( get_current_user_id() ); ?>

						<?php get_template_part( 'template-parts/components/message', 'card' ); ?>

                        <div class="view_all_nfo">
                            <a href="<?php echo get_site_url() . '/messages'; ?>">View All Messages</a>
                        </div>
                    </div><!-- End .latest_messages -->


                    <div class="recent_proposals">
						<?php if ( USER_ROLE == 'freelancer' ) : ?>
                            <h4><?php _e( 'Recent Proposals', ET_DOMAIN ); ?></h4>
							<?php
							$recent_proposals = Freelancer::get_bids( get_current_user_id(), null, 2 );
							if ( $recent_proposals->posts ) {
								foreach ( $recent_proposals->posts as $proposal ) {
									include( locate_template( 'template-parts/components/proposal-card.php' ) );
								}
							} else {
								echo '<p>No New Proposals Found!</p>';
							}
							?>
                            <div class="view_all_nfo">
                                <a href="<?php echo esc_url( home_url( 'projects' ) ); ?>">View All Projects</a>
                            </div>

						<?php else : ?>
                            <h4><?php _e( 'New bids on the projects', ET_DOMAIN ); ?></h4>
							<?php
							$recent_bids = Employer::get_project_bids( get_current_user_id(), null, 2 );
							if ( $recent_bids ) {
								foreach ( $recent_bids->posts as $bid ) {
									include( locate_template( 'template-parts/components/bid-card.php' ) );
								}
							} else {
								echo '<p>No New Bids Found!</p>';
							}
							?>

                            <div class="view_all_nfo">
                                <a href="<?php echo esc_url( home_url( 'my-projects' ) ); ?>">View All Projects</a>
                            </div>

						<?php endif; ?>
                    </div><!-- End .recent_proposals -->


                </div><!-- End .others_info -->
            </div>

        </section><!-- End #dashboard_content -->

    </div>

</div>


<!-- CURRENT PROFILE -->

<?php if ( $profile_id && $profile_post && ! is_wp_error( $profile_post ) ) { ?>
    <script type="data/json" id="current_profile">
        <?php echo json_encode( $profile ) ?>






    </script>

<?php } ?>

<!-- END / CURRENT PROFILE -->


<!-- CURRENT SKILLS -->

<?php if ( ! empty( $current_skills ) ) { ?>
    <script type="data/json" id="current_skills">
        <?php echo json_encode( $current_skills ) ?>






    </script>
<?php } ?>

<!-- END / CURRENT SKILLS -->


<?php
get_footer( 'dashboard' );
?>



