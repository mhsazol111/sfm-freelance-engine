<?php

define( 'ET_DOMAIN', 'enginetheme' );

/**
 * Including Custom scripts
 */
function sfm_load_scripts() {
	wp_enqueue_style( 'Open-Sans', '//fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700;1,800&display=swap' );
	wp_enqueue_style( 'smf-custom-css', get_stylesheet_directory_uri() . '/assets/css/custom.css', false, '2.3.4', 'all' );

	if ( is_page_template( 'template-home.php' ) ) {
		wp_enqueue_style( 'home-css', get_stylesheet_directory_uri() . '/assets/css/home.css', null, time(), 'all' );
	}
	if ( is_page_template( 'template-blog.php' ) ) {
		wp_enqueue_style( 'blog-css', get_stylesheet_directory_uri() . '/assets/css/blog.css', null, time(), 'all' );
	}
	if ( is_page_template( 'template-contact.php' ) ) {
		wp_enqueue_style( 'contact-css', get_stylesheet_directory_uri() . '/assets/css/contact.css', null, time(), 'all' );
	}
	if ( is_page_template( 'template-faq.php' ) ) {
		wp_enqueue_style( 'faq-css', get_stylesheet_directory_uri() . '/assets/css/faq.css', null, time(), 'all' );
	}
	if ( is_page_template( 'page-my-portfolios.php' ) ) {
		wp_enqueue_script( 'profile-child', get_template_directory_uri() . '/assets/js/profile.js', array( 'jquery' ), time(), true );
	}
	if ( is_page_template( array( 'template-registration.php', 'page-register.php', 'page-login.php' ) ) ) {
		wp_enqueue_style( 'registration-css', get_stylesheet_directory_uri() . '/assets/css/registration.css', null, time(), 'all' );
	}
	if ( is_archive() | is_category() | is_page_template( 'template-blog.php' ) ) {
		wp_enqueue_style( 'archive-post-css', get_stylesheet_directory_uri() . '/assets/css/archive.css', null, time(), 'all' );
	}
	if ( is_singular() ) {
		wp_enqueue_style( 'single-post-css', get_stylesheet_directory_uri() . '/assets/css/single.css', null, time(), 'all' );
	}

	wp_enqueue_style( 'sfm-dashboard', get_stylesheet_directory_uri() . '/assets/css/dashboard.css', null, time(), 'all' );

	wp_enqueue_style( 'magnific-css', '//cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css', null, '1.1.0', 'all' );
	wp_enqueue_style( 'owl-css', '//cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css', null, '2.3.4', 'all' );

	wp_enqueue_script( 'fontawesome-kit', 'https://kit.fontawesome.com/31e4a7fdfe.js' );
	wp_enqueue_script( 'magnific-js', '//cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js', array( 'jquery' ), '1.1.0', true );
	wp_enqueue_script( 'owl-js', '//cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js', array( 'jquery' ), '2.3.4', true );
	wp_enqueue_script( 'jquery-validate', '//cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js', array( 'jquery' ), '1.19.1', true );

	if ( is_page_template( 'page-submit-project.php' ) || is_page_template( 'page-edit-project.php' ) || is_page_template( 'page-submit-proposal.php' ) ) {
		wp_enqueue_script( 'pignos-js', '//cdn.jsdelivr.net/npm/pg-calendar@1.4.31/dist/js/pignose.calendar.full.min.js', array( 'jquery' ), '1.4.31', true );
		wp_enqueue_style( 'pignos-css', '//cdn.jsdelivr.net/npm/pg-calendar@1/dist/css/pignose.calendar.min.css', null, '1.4.31', 'all' );
	}

	wp_enqueue_script( 'noty-js', '//cdnjs.cloudflare.com/ajax/libs/noty/3.1.4/noty.min.js', array( 'jquery' ), '3.1.4', true );
	wp_enqueue_style( 'noty-css', '//cdnjs.cloudflare.com/ajax/libs/noty/3.1.4/noty.min.css', null, '3.1.4', 'all' );

	wp_enqueue_style( 'select2-css', '//cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css', null, '4.1.0', 'all' );
	wp_enqueue_script( 'select2-js', '//cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js', array( 'jquery' ), '4.1.0', true );

	wp_enqueue_script( 'custom-script', get_stylesheet_directory_uri() . '/assets/js/custom.js', array( 'jquery' ), time(), true );
	wp_enqueue_script( 'sfm-ajax-scripts', get_stylesheet_directory_uri() . '/assets/js/sfm-ajax-scripts.js', array( 'jquery' ), time(), true );
	wp_localize_script( 'sfm-ajax-scripts', 'ajaxObject', array(
		'ajaxUrl'       => admin_url( 'admin-ajax.php' ),
		'currentUserId' => get_current_user_id(),
		'upload'        => admin_url( 'admin-ajax.php?action=sfm_file_upload' ),
		'site_root'     => get_site_url(),
//		'delete'        => admin_url( 'admin-ajax.php?action=sfm_file_delete' ),
	) );
}

add_action( 'wp_enqueue_scripts', 'sfm_load_scripts', 99999 );


require_once __DIR__ . '/inc/helper_functions.php';
require_once get_theme_file_path( 'inc/shortcodes.php' );

/**
 * Add a sidebar.
 */
function sfm_child_sidebar_register() {
	register_sidebar( array(
		'name'          => __( 'Footer 5', ET_DOMAIN ),
		'id'            => 'fre-footer-5',
		'description'   => __( 'Widgets in this area will be shown on all posts and pages.', ET_DOMAIN ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widgettitle">',
		'after_title'   => '</h2>',
	) );
}

add_action( 'widgets_init', 'sfm_child_sidebar_register' );

// Adding Dark logo in customize option for Dashboard
/**
 * @param $wp_customize
 */
function my_register_additional_customizer_settings( $wp_customize ) {
	$wp_customize->add_setting( 'dark_logo_das', array(
		'default'   => '',
		'transport' => 'refresh',
	) );

	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'dark_logo_das', array(
		'section'  => 'title_tagline',
		'label'    => 'Dark Logo',
		'settings' => 'dark_logo_das',
	) ) );
}

add_action( 'customize_register', 'my_register_additional_customizer_settings' );

/**
 * @param $api
 */
function custom_option_api( $api ) {
	$api->add_section( 'contact_area', array(
		'title'    => 'Contact Area',
		'priority' => 10,
	) );

	$api->add_setting( 'contact_phone', array(
		'default'   => "+123 (456) 789",
		'transport' => 'refresh',
	) );
	$api->add_control( 'contact_phone', array(
		'section' => 'contact_area',
		'label'   => 'Phone',
		'type'    => 'text',
	) );
}

add_action( 'customize_register', 'custom_option_api' );


// Social Link Customizer Option
function social_link_option_api( $wp_customize ) {
	$wp_customize->add_section( 'footer-social', array(
		'title'    => 'Footer Social',
		'priority' => 11,
	) );
	$wp_customize->add_setting( 'instagram', array(
		'default'   => "https://www.instagram.com/",
		'transport' => 'refresh',
	) );
	$wp_customize->add_control( 'instagram', array(
		'section' => 'footer-social',
		'label'   => 'Instagram',
		'type'    => 'text',
	) );
	$wp_customize->add_setting( 'facebook', array(
		'default'   => "https://www.facebook.com/",
		'transport' => 'refresh',
	) );
	$wp_customize->add_control( 'facebook', array(
		'section' => 'footer-social',
		'label'   => 'Facebook',
		'type'    => 'text',
	) );
	$wp_customize->add_setting( 'twitter', array(
		'default'   => "https://twitter.com/",
		'transport' => 'refresh',
	) );
	$wp_customize->add_control( 'twitter', array(
		'section' => 'footer-social',
		'label'   => 'Twitter',
		'type'    => 'text',
	) );
}

add_action( 'customize_register', 'social_link_option_api' );

require_once dirname( __FILE__ ) . '/messaging/_loader.php';
/* OLD CODE */


/*==============================
========== New Code ============
===============================*/
// Define USER_ROLE
if ( is_user_logged_in() ) {
	define( 'USER_ROLE', wp_get_current_user()->roles[0] );
}


/**
 * Convert a multi-dimensional array into a single-dimensional array.
 *
 * @param array $array The multi-dimensional array.
 *
 * @return array
 */
function array_flatten( $array ) {
	if ( ! is_array( $array ) ) {
		return false;
	}
	$result = array();
	foreach ( $array as $key => $value ) {
		if ( is_array( $value ) ) {
			$result = array_merge( $result, array_flatten( $value ) );
		} else {
			$result = array_merge( $result, array( $key => $value ) );
		}
	}

	return $result;
}

/**
 * Print_r Code with better look and feel
 *
 * @param $code
 */
function pri_dump( $code ) {
	echo '<pre>';
	print_r( $code );
	echo '</pre>';
}


//Registering Nav Menu
if ( ! function_exists( 'sfm_register_nav_menu' ) ) {
	function sfm_register_nav_menu() {
		register_nav_menus( array(
			'freelance_menu' => __( 'Freelance Menu', ET_DOMAIN ),
			'employer_menu'  => __( 'Employer Menu', ET_DOMAIN ),
		) );
	}

	add_action( 'after_setup_theme', 'sfm_register_nav_menu', 0 );
}


function disable_logged_out_user_from_protected_pages() {
	if ( ( is_post_type_archive( PROJECT ) || is_page_template( 'page-edit-profile.php' ) || is_singular( PROJECT ) || is_singular( PROFILE ) || is_singular( BID ) || is_page_template( 'page-notification-settings.php' ) ) && ! is_user_logged_in() ) {
		$loginUrl = home_url( '/login/' );
		wp_redirect( $loginUrl );
		exit();
	}
}

add_action( 'template_redirect', 'disable_logged_out_user_from_protected_pages' );


function redirect_if_user_is_pending() {
	if ( is_user_logged_in() && ( 'pending' == get_user_meta( get_current_user_id(), 'account_status', true ) ) && ( is_post_type_archive( PROJECT ) || is_page_template( 'page-edit-profile.php' ) || is_singular( PROJECT ) || is_singular( PROFILE ) || is_singular( BID ) ) ) {
		$loginUrl = home_url( '/account-not-verified/' );
		wp_redirect( $loginUrl );
		exit();
	}
}

add_action( 'template_redirect', 'redirect_if_user_is_pending' );

// Remove revision capabilities from fre_profile
function disable_revisions() {
	remove_post_type_support( PROFILE, 'revisions' );
}

add_action( 'admin_init', 'disable_revisions' );


/**
 * Theme Option
 */
if ( function_exists( 'acf_add_options_page' ) ) {
	acf_add_options_page( array(
		'page_title' => 'Theme Options',
		'menu_title' => 'Theme Options',
		'menu_slug'  => 'theme-options',
		'capability' => 'edit_posts',
		'redirect'   => false
	) );
	acf_add_options_sub_page( array(
		'page_title'  => 'Email Options',
		'menu_title'  => 'Email Options',
		'parent_slug' => 'theme-options',
	) );
	acf_add_options_sub_page( array(
		'page_title'  => 'Notification Settings',
		'menu_title'  => 'Notification Settings',
		'menu_slug'   => 'notification-option',
		'parent_slug' => 'theme-options',
	) );
}


function pending_users_submenu() {
	add_users_page(
		__( 'Pending Users', ET_DOMAIN ),
		__( 'Pending Users', ET_DOMAIN ),
		'manage_options',
		'pending_users',
		'pending_users_admin_view'
	);
}

/**
 * Display callback for the submenu page.
 */
function pending_users_admin_view() {
	$args = array(
		'meta_key'     => 'account_status',
		'meta_value'   => 'pending',
		'meta_compare' => '='
	);

	$user_query = new WP_User_Query( $args );

	$users = [];
	foreach ( $user_query->get_results() as $user ) {
		$users[] = array(
//			'ID'       => $user->ID,
			'name'     => '<a href="' . get_edit_user_link( $user->ID ) . '">' . $user->display_name . '</a>',
			'email'    => $user->user_email,
			'username' => $user->user_login,
			'company'  => get_user_meta( $user->ID, 'company_name', true ),
			'status'   => 'Pending',
			'action'   => '<a href="' . get_edit_user_link( $user->ID ) . '">View Profile</a> | <a href="#" id="user-approve" class="pending-user-action" data-action="approve" data-user_id="' . $user->ID . '">Approve</a> | <a href="' . wp_nonce_url( "users.php?action=delete&amp;user={$user->ID}", 'bulk-users' ) . '" id="user-delete" class="pending-user-action" data-action="delete" data-user_id="' . $user->ID . '">Delete</a>',
		);
	}

	$pending = new Pending_Users_Table();
	$pending->set_data( $users );
	$pending->prepare_items();
	$pending->display();
}

add_action( 'admin_menu', 'pending_users_submenu' );

function sfm_admin_scripts( $hook ) {
	if ( 'users_page_pending_users' == $hook ) {
		wp_enqueue_script( 'sfm-admin-js', get_stylesheet_directory_uri() . '/assets/js/sfm-admin-script.js', array( 'jquery' ), '1.0', true );
		wp_localize_script( 'sfm-admin-js', 'ajaxObject', array(
			'ajaxUrl' => admin_url( 'admin-ajax.php' ),
		) );
	}
	if ( 'users_page_mass_email_to_users' == $hook ) {
		wp_enqueue_style( 'sfm-admin-user-email-style', get_stylesheet_directory_uri() . '/assets/admin/users/email-style.css', null, '1.0', 'all' );
		wp_enqueue_script( 'sfm-admin-user-email-script', get_stylesheet_directory_uri() . '/assets/admin/users/email-script.js', array( 'jquery' ), '1.0', true );
		wp_localize_script( 'sfm-admin-user-email-script', 'ajaxObject', array(
			'ajaxUrl' => admin_url( 'admin-ajax.php' ),
		) );
	}
}

add_action( 'admin_enqueue_scripts', 'sfm_admin_scripts' );

function sfm_fix_pending_review_text() {
	// From the project list page
	if ( isset( $_GET['post_type'] ) && 'project' == $_GET['post_type'] ) { ?>
        <script>
            jQuery(document).ready(function ($) {
                var __sfm_status_draft = jQuery('.inline-edit-status').find('option[value="draft"]');
                if (__sfm_status_draft.length) {
                    __sfm_status_draft.text('Pending');
                }
                var __sfm_status_pending = jQuery('.inline-edit-status').find('option[value="pending"]');
                if (__sfm_status_pending.length) {
                    __sfm_status_pending.remove();
                }
                var __sfm_table_row_status_draft = jQuery('#the-list .status-draft td.title span.post-state');
                __sfm_table_row_status_draft.each(function (index, elm) {
                    elm.innerText = 'Pending';
                });
            });
        </script>
		<?php
	}
	// From project single page
	if ( isset( $_GET['post'] ) && ! empty( $_GET['post'] ) && 'edit' == @$_GET['action'] ) {
		if ( 'project' == get_post_type( $_GET['post'] ) ) {
			?>
            <script>
                jQuery(document).ready(function ($) {
                    var __sfm_status_draft = jQuery('#post-status-select').find('option[value="draft"]');
                    if (__sfm_status_draft.length) {
                        __sfm_status_draft.text('Pending');
                    }
                    var __sfm_status_pending = jQuery('#post-status-select').find('option[value="pending"]');
                    if (__sfm_status_pending.length) {
                        __sfm_status_pending.remove();
                    }

                    var __sfm_status_text = jQuery('span#post-status-display').text();
                    if (__sfm_status_text.indexOf('Draft') > -1) {
                        jQuery('#post-status-display').text('Pending');
                    }
                });
            </script>
			<?php
		}
	}
}

add_action( 'admin_print_footer_scripts-edit.php', 'sfm_fix_pending_review_text' );
add_action( 'admin_print_footer_scripts-post.php', 'sfm_fix_pending_review_text' );


function sfm_project_admin_view_change( $views ) {
	if ( isset( $views['draft'] ) ) {
		$views['draft'] = str_replace( 'Drafts ', 'Pending ', $views['draft'] );
	}

	return $views;
}

add_filter( "views_edit-project", 'sfm_project_admin_view_change' );


// CF7 Dynamic Value From User Filter
function custom_shortcode_atts_wpcf7_filter( $out, $pairs, $atts ) {
	$my_attributes = array( 'your-name', 'your-email', 'tel-866' );
	foreach ( $my_attributes as $value ) {
		if ( isset( $atts[ $value ] ) ) {
			$out[ $value ] = $atts[ $value ];
		}
	}

	return $out;
}

add_filter( 'shortcode_atts_wpcf7', 'custom_shortcode_atts_wpcf7_filter', 10, 3 );


// Demo function to fix fetal error of the parent theme
if ( ! function_exists( 'et_get_customization' ) ) {
	function et_get_customization() {
		return array( 'background' => '#1f8dbc' );
	}
}

//
/**
 * Change flags folder path for certain languages.
 */

add_filter( 'trp_flags_path', 'sfm_trpc_flags_path', 10, 2 );
function sfm_trpc_flags_path( $original_flags_path, $language_code ) {

	$languages_with_custom_flags = array( 'en_US' );

	if ( in_array( $language_code, $languages_with_custom_flags ) ) {
		return get_stylesheet_directory_uri() . '/assets/flags/';
	} else {
		return $original_flags_path;
	}
}


/**
 * Registering language taxonomies
 */
function register_language_taxonomy() {
	$labels = array(
		'name'                  => _x( 'Languages', 'Taxonomy plural name', ET_DOMAIN ),
		'singular_name'         => _x( 'Language', 'Taxonomy singular name', ET_DOMAIN ),
		'search_items'          => __( 'Search Languages', ET_DOMAIN ),
		'popular_items'         => __( 'Popular Languages', ET_DOMAIN ),
		'all_items'             => __( 'All Languages', ET_DOMAIN ),
		'parent_item'           => __( 'Parent Language', ET_DOMAIN ),
		'parent_item_colon'     => __( 'Parent Language', ET_DOMAIN ),
		'edit_item'             => __( 'Edit Language', ET_DOMAIN ),
		'update_item'           => __( 'Update Language ', ET_DOMAIN ),
		'add_new_item'          => __( 'Add New Language ', ET_DOMAIN ),
		'new_item_name'         => __( 'New Language Name', ET_DOMAIN ),
		'add_or_remove_items'   => __( 'Add or remove Language', ET_DOMAIN ),
		'choose_from_most_used' => __( 'Choose from most used', ET_DOMAIN ),
		'menu_name'             => __( 'Languages', ET_DOMAIN ),
	);
	$args   = array(
		'labels'            => $labels,
		'public'            => true,
		'show_in_nav_menus' => true,
		'show_admin_column' => true,
		'hierarchical'      => true,
		'show_tagcloud'     => true,
		'show_ui'           => true,
		'query_var'         => true,
//		'rewrite'           => array(
//			'slug'         => 'sfm_language',
//		),
		'capabilities'      => array(
			'manage_terms',
			'edit_terms',
			'delete_terms',
			'assign_terms',
		),
	);
	register_taxonomy( 'language', array( PROFILE, PROJECT, BID ), $args );
}

add_action( 'init', 'register_language_taxonomy' );


// Custom Header Codes inside <head></head> tag
function sfm_add_header_scripts() {
	$codes = get_field( 'custom_header_codes', 'option' );
	echo $codes;
}

add_action( 'wp_head', 'sfm_add_header_scripts' );


/*
 * Send Emails to users
 */
add_action( 'admin_menu', 'mass_email_to_users_menu' );
function mass_email_to_users_menu() {
	add_users_page(
		__( 'Send Email to Users', ET_DOMAIN ),
		__( 'Send Email to Users', ET_DOMAIN ),
		'manage_options',
		'mass_email_to_users',
		'mass_email_to_users_admin_view'
	);
}

// Add display_name to WP_User_Query search column
add_filter( 'user_search_columns', function ( $search_columns ) {
	$search_columns[] = 'display_name';

	return $search_columns;
} );

function mass_email_to_users_admin_view() {
	ob_start();
	get_template_part( 'template-parts/admin/users/user-email', 'page' );
	echo ob_get_clean();
}


// Helper Classes
require 'Helpers/Authentication.php';
require 'Helpers/Pending_Users_Table.php';
require 'Helpers/Admin_Functions.php';
require 'Helpers/Employer.php';
require 'Helpers/Freelancer.php';
require 'Helpers/Custom.php';
require 'Helpers/Project.php';
require 'Helpers/Bid.php';
require 'Helpers/Email_Notification.php';
require 'Helpers/sfmInvitations.php';
require 'Helpers/Send_Email_To_Users.php';
require 'Helpers/User_Notification.php';


function custom_logs( $message ) {
	if ( is_array( $message ) ) {
		$message = json_encode( $message );
	}
	$file = fopen( __DIR__ . '/debug.log', "a" );
	echo fwrite( $file, "\n" . date( 'Y-m-d h:i:s' ) . " :: " . $message );
	fclose( $file );
}


/**
 * Sending User Email Notifications
 */
$user_notification = new User_Notification();

//  Daily notification
if ( ! wp_next_scheduled( 'send_daily_employer_notification', array( 'employer', 'daily' ) ) ) {
	wp_schedule_event( time(), 'daily', 'send_daily_employer_notification', array( 'employer', 'daily' ) );
}
add_action( 'send_daily_employer_notification', 'send_user_email_notification', 10, 2 );

if ( ! wp_next_scheduled( 'send_daily_freelancer_notification', array( 'freelancer', 'daily' ) ) ) {
	wp_schedule_event( time(), 'daily', 'send_daily_freelancer_notification', array( 'freelancer', 'daily' ) );
}
add_action( 'send_daily_freelancer_notification', 'send_user_email_notification', 10, 2 );


//  Weekly notification
if ( ! wp_next_scheduled( 'send_weekly_employer_notification', array( 'employer', 'weekly' ) ) ) {
	wp_schedule_event( time(), 'weekly', 'send_weekly_employer_notification', array( 'employer', 'weekly' ) );
}
add_action( 'send_weekly_employer_notification', 'send_user_email_notification', 10, 2 );

if ( ! wp_next_scheduled( 'send_weekly_freelancer_notification', array( 'freelancer', 'weekly' ) ) ) {
	wp_schedule_event( time(), 'weekly', 'send_weekly_freelancer_notification', array( 'freelancer', 'weekly' ) );
}
add_action( 'send_weekly_freelancer_notification', 'send_user_email_notification', 10, 2 );


//  Fortnightly notification
if ( ! wp_next_scheduled( 'send_fortnightly_employer_notification', array( 'employer', 'fortnightly' ) ) ) {
	wp_schedule_event( time(), 'fortnightly', 'send_fortnightly_employer_notification', array(
		'employer',
		'fortnightly'
	) );
}
add_action( 'send_fortnightly_employer_notification', 'send_user_email_notification', 10, 2 );

if ( ! wp_next_scheduled( 'send_fortnightly_freelancer_notification', array( 'freelancer', 'fortnightly' ) ) ) {
	wp_schedule_event( time(), 'fortnightly', 'send_fortnightly_freelancer_notification', array(
		'freelancer',
		'fortnightly'
	) );
}
add_action( 'send_fortnightly_freelancer_notification', 'send_user_email_notification', 10, 2 );


//  Monthly notification
if ( ! wp_next_scheduled( 'send_once_monthly_employer_notification', array( 'employer', 'once_monthly' ) ) ) {
	wp_schedule_event( time(), 'once_monthly', 'send_once_monthly_employer_notification', array(
		'employer',
		'once_monthly'
	) );
}
add_action( 'send_once_monthly_employer_notification', 'send_user_email_notification', 10, 2 );

if ( ! wp_next_scheduled( 'send_once_monthly_freelancer_notification', array( 'freelancer', 'once_monthly' ) ) ) {
	wp_schedule_event( time(), 'once_monthly', 'send_once_monthly_freelancer_notification', array(
		'freelancer',
		'once_monthly'
	) );
}
add_action( 'send_once_monthly_freelancer_notification', 'send_user_email_notification', 10, 2 );

// Callback for user notification
function send_user_email_notification( $role, $recurrence ) {
	$users = get_users( array(
		'role' => $role,
	) );

	$notification = new User_Notification();

	foreach ( $users as $user ) {
		$notification_settings = get_user_meta( $user->ID, 'notification_settings', true ) ? unserialize( get_user_meta( $user->ID, 'notification_settings', true ) ) : false;
		if ( $notification_settings ) {
			$status = $notification_settings['status'];
			if ( $status ) {
				$frequency = $notification_settings['frequency'];
				$quantity  = $notification_settings['quantity'];

				if ( $role == 'freelancer' ) {
					$project_cat_ids = $notification_settings['project_cat_ids'];

					if ( $recurrence == $frequency ) {
						$projects_ids = get_eligible_project_ids( $recurrence, $project_cat_ids );

						if ( $projects_ids ) {

							$total_projects = count( $projects_ids );
							if ( $total_projects > $quantity ) {
								shuffle( $projects_ids );
								$projects_ids = array_slice( $projects_ids, 0, $quantity );
							}

							$projects_html = '<ul style="margin: 0; padding: 0; list-style-type: none;">';
							foreach ( $projects_ids as $project ) {
								$project       = get_post( $project );
								$projects_html .= '<li id="project_id_' . $project->ID . '" style="margin: 0 0 5px;"><a href="' . get_permalink( $project->ID ) . '" target="_blank" style="font-size: 14px;text-decoration: none;display: block;color: #333;padding: 5px 10px 5px 15px;background-color: rgba(32, 148, 198, .1);border-radius: 15px;">' . get_the_title( $project->ID ) . '</a></li>';
							}
							$projects_html .= '</ul>';

							$email_fields       = get_field( 'en_freelancer_notification_email_template', 'option' );
							$email_subject      = $email_fields['subject'];
							$email_body         = $email_fields['email_body'];
							$email_replaces     = array(
								'{{freelancer_name}}',
								'{{freelancer_email}}',
								'{{project_list}}',
								'{{notification_settings}}'
							);
							$email_replace_with = array(
								$user->display_name,
								$user->user_email,
								$projects_html,
								esc_url( get_site_url() . '/notification-settings' ),
							);
							$email_body         = str_replace( $email_replaces, $email_replace_with, $email_body );

							wp_mail( $user->user_email, $email_subject, $notification->email_body_html( $email_body ), $notification->headers );
						}
					}
				} elseif ( $role == 'employer' ) {
					$freelancer_required_categories = $notification_settings['freelancer_cat_ids'];
					$freelancer_required_skills     = $notification_settings['freelancer_skill_ids'];

					if ( $recurrence == $frequency ) {
						$freelancer_ids = get_eligible_freelancer_ids( $recurrence, $freelancer_required_categories, $freelancer_required_skills );

						if ( $freelancer_ids ) {

							$total_freelancers = count( $freelancer_ids );
							if ( $total_freelancers > $quantity ) {
								shuffle( $freelancer_ids );
								$freelancer_ids = array_slice( $freelancer_ids, 0, $quantity );
							}

							$freelancers_html = '<ul style="margin: 0; padding: 0; list-style-type: none;">';
							foreach ( $freelancer_ids as $f_id ) {
								$freelancer       = get_user_by( 'ID', $f_id );
								$freelancers_html .= '
								<li id="freelancer_id_' . $f_id . '" style="margin: 0 0 10px;">
								    <a href="' . get_author_posts_url( $f_id ) . '" target="_blank" style="display: table; max-width: 535px; width:100%; font-size: 14px;text-decoration: none;color: #333;padding: 5px 10px 5px 15px;background-color: rgba(32, 148, 198, .1);border-radius: 7px;">
								        <div style="width: 50px; height: 50px; border-radius: 50px; overflow: hidden; display: block; margin-right: 10px; margin-top: 5px;">' . get_avatar( $f_id, 50 ) . '</div>
								        <div style="width: 495px; display: table-cell; vertical-align: middle; padding: 10px 5px;"><p style="margin: 0;">' . $freelancer->display_name . '</p><small>' . get_user_meta( $f_id, 'job_title', true ) . '</small></div>
								    </a>
								</li>';
							}
							$freelancers_html .= '</ul>';

							$email_fields       = get_field( 'en_employer_notification_email_template', 'option' );
							$email_subject      = $email_fields['subject'];
							$email_body         = $email_fields['email_body'];
							$email_replaces     = array(
								'{{employer_name}}',
								'{{employer_email}}',
								'{{freelancer_list}}',
								'{{notification_settings}}'
							);
							$email_replace_with = array(
								$user->display_name,
								$user->user_email,
								$freelancers_html,
								esc_url( get_site_url() . '/notification-settings' ),
							);
							$email_body         = str_replace( $email_replaces, $email_replace_with, $email_body );

							wp_mail( $user->user_email, $email_subject, $notification->email_body_html( $email_body ), $notification->headers );
						}

					}
				}
			}
		}
	}
}

add_action( 'init', 'get_eligible_freelancer_ids', 9999, 1 );

/**
 * Get eligible freelancer ids based on category and skill
 *
 * @param string $time_period
 * @param array $required_categories
 * @param array $required_skills
 *
 * @return array|false
 */
function get_eligible_freelancer_ids( $time_period = 'daily', $required_categories = array(), $required_skills = array() ) {

	$date_query = '-1 day';

	if ( $time_period == 'weekly' ) {
		$date_query = '-7 days';
	} elseif ( $time_period == 'fortnightly' ) {
		$date_query = '-15 days';
	} elseif ( $time_period == 'once_monthly' ) {
		$date_query = 'last month';
	}

	$args = array(
		'role'       => 'freelancer',
		'meta_query' => array(
			'relation' => 'AND',
			array(
				'key'     => 'account_status',
				'value'   => 'active',
				'compare' => '='
			),
			array(
				'key'     => 'user_profile_id',
				'compare' => 'EXISTS'
			),
		),
// 		'date_query' => array(
// 			array( 'after' => $date_query, 'inclusive' => true )
// 		)
	);

	$users = new WP_User_Query( $args );

	if ( ! $users->get_results() ) {
		return false;
	}

	$freelancer_ids          = wp_list_pluck( $users->get_results(), 'ID' );
	$eligible_freelancer_ids = [];

	foreach ( $freelancer_ids as $id ) {
		$freelancer_profile_post_id = get_user_meta( $id, 'user_profile_id', true );
		$freelancer_categories      = wp_get_post_terms( $freelancer_profile_post_id, 'project_category', array( 'fields' => 'ids' ) );
		$freelancer_skills          = wp_get_post_terms( $freelancer_profile_post_id, 'skill', array( 'fields' => 'ids' ) );

		foreach ( $required_categories as $cat => $skills ) {
			if ( in_array( $cat, $freelancer_categories ) ) {
				if ( ! in_array( $id, $eligible_freelancer_ids ) ) {
					$eligible_freelancer_ids[] = $id;
				}

				if ( in_array( $id, $eligible_freelancer_ids ) ) {
					if ( $required_categories[ $cat ] && array_diff( $required_categories[ $cat ], $freelancer_skills ) ) {
						$eligible_freelancer_ids = array_diff( $eligible_freelancer_ids, [ $id ] );
					}
				}
			}
		}
	}

	return $eligible_freelancer_ids;
}


/**
 * Get eligible post objects matched based on category
 *
 * @param string $time_period
 * @param array $required_categories
 *
 * @return false|array
 */
function get_eligible_project_ids( $time_period = 'daily', $required_categories = array() ) {
	$date_query = '-1 day';
	if ( $time_period == 'weekly' ) {
		$date_query = '-7 days';
	} elseif ( $time_period == 'fortnightly' ) {
		$date_query = '-15 days';
	} elseif ( $time_period == 'once_monthly' ) {
		$date_query = 'last month';
	}

	$args = array(
		'post_type'      => 'project',
		'post_status'    => 'publish',
		'posts_per_page' => 9999,
		'tax_query'      => array(
			'relation' => 'AND',
			array(
				'taxonomy' => 'project_category',
				'field'    => 'term_id',
				'terms'    => $required_categories,
			),
		),
//		'date_query'     => array(
//			array( 'after' => $date_query, 'inclusive' => true )
//		)
	);

	$projects = new WP_Query( $args );

	if ( ! $projects->posts ) {
		return false;
	}

	return wp_list_pluck( $projects->posts, 'ID' );
}


add_action('admin_head', 'fix_profile_pagination_admin_css');

function fix_profile_pagination_admin_css() {
  echo '<style>
    .tablenav {
    	display: block !important;
	}
  </style>';
}