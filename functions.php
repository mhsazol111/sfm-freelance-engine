<?php

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
//	if ( is_post_type_archive( 'project' ) ) {
//		wp_enqueue_script( 'wnumb', '//cdnjs.cloudflare.com/ajax/libs/wnumb/1.2.0/wNumb.min.js', array( 'jquery' ), '14.0.3', true );
//		wp_enqueue_script( 'noui-js', '//cdnjs.cloudflare.com/ajax/libs/noUiSlider/14.0.3/nouislider.min.js', array( 'jquery' ), '14.0.3', true );
//		wp_enqueue_style( 'noui-css', '//cdnjs.cloudflare.com/ajax/libs/noUiSlider/14.0.3/nouislider.min.css', null, '14.0.3', 'all' );
//	}

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
	if ( ( is_post_type_archive( PROJECT ) || is_page_template( 'page-edit-profile.php' ) || is_singular( PROJECT ) || is_singular( PROFILE ) || is_singular( BID ) ) && ! is_user_logged_in() ) {
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
	if ( 'users_page_pending_users' != $hook ) {
		return;
	}
	wp_enqueue_script( 'sfm-admin-js', get_stylesheet_directory_uri() . '/assets/js/sfm-admin-script.js', array( 'jquery' ), '1.0', true );
	wp_localize_script( 'sfm-admin-js', 'ajaxObject', array(
		'ajaxUrl' => admin_url( 'admin-ajax.php' ),
	) );
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
	$codes = get_field('custom_header_codes', 'option');
	echo $codes;
}
add_action('wp_head', 'sfm_add_header_scripts');


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
