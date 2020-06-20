<?php 
/**
 * Template Name: Page List Notification 
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other 'pages' on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage FreelanceEngine
 * @since FreelanceEngine 1.0
 */

// Redirects an user back to their edit profile to update the profile first
if ( ! get_user_meta( get_current_user_id(), 'user_profile_id', true ) ) {
	wp_redirect( home_url() . '/edit-profile' );
}

 add_filter( 'body_class', 'body_class_wpse_85793', 10, 2 );
 function body_class_wpse_85793( $classes, $class )
{
    $classes[] = 'dashboard';
    return $classes;
}
global $user_ID;
//convert current user
$ae_users = AE_Users::get_instance();
$user_data = $ae_users->convert( $current_user->data );
$user_role = ae_user_role( $current_user->ID );
//convert current profile
$post_object = $ae_post_factory->get( PROFILE );
$profile_id = get_user_meta( $user_ID, 'user_profile_id', true );
$profile = array();
if ( $profile_id ) {
	$profile_post = get_post( $profile_id );
	if ( $profile_post && ! is_wp_error( $profile_post ) ) {
		$profile = $post_object->convert( $profile_post );
	}
}

$display_name = $user_data->display_name;
$job_title = isset( $profile->et_professional_title ) ? $profile->et_professional_title : '';
$role_template = 'employer';
if ( fre_share_role() || ae_user_role( $user_ID ) == FREELANCER ) {
    $role_template = 'freelance';
}
get_header();
?>

<div class="fre-page-wrapper all-notification-wrapper">
    <div class="profile_dashboard" id="<?php echo $role_template; ?>-dashboard">
        <?php include( locate_template( 'template-parts/sidebar-profile.php' ) ); // Dashboard Sidebar ?>
        <section id="dashboard_content">
            <div class="dashboard_inn">

                <div class="dashboard_title">
                    <h2><?php _e( 'Your Notifications', ET_DOMAIN ); ?></h2>
                    <hr>
                </div>

                <div class="fre-page-section">
                    <div class="page-notification-wrap" id="fre_notification_container">
                        <?php fre_user_notification( $user_ID, 1,'', 'fre-notification-list'); ?>
                    </div>
                </div>

            </div>
        </section>

    </div>
</div>

 <?php get_footer(); ?>

