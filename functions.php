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
	//portfolio page script
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
	if ( is_post_type_archive( 'project' ) ) {
		wp_enqueue_script( 'wnumb', '//cdnjs.cloudflare.com/ajax/libs/wnumb/1.2.0/wNumb.min.js', array( 'jquery' ), '14.0.3', true );
		wp_enqueue_script( 'noui-js', '//cdnjs.cloudflare.com/ajax/libs/noUiSlider/14.0.3/nouislider.min.js', array( 'jquery' ), '14.0.3', true );
		wp_enqueue_style( 'noui-css', '//cdnjs.cloudflare.com/ajax/libs/noUiSlider/14.0.3/nouislider.min.css', null, '14.0.3', 'all' );
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

	//if ( is_user_logged_in() ) {
	wp_enqueue_style( 'select2-css', '//cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css', null, '4.1.0', 'all' );
	wp_enqueue_script( 'select2-js', '//cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js', array( 'jquery' ), '4.1.0', true );
	//}

	wp_enqueue_script( 'custom-script', get_stylesheet_directory_uri() . '/assets/js/custom.js', array( 'jquery' ), time(), true );
	wp_enqueue_script( 'sfm-ajax-scripts', get_stylesheet_directory_uri() . '/assets/js/sfm-ajax-scripts.js', array( 'jquery' ), time(), true );
	wp_localize_script( 'sfm-ajax-scripts', 'ajaxObject', array(
		'ajaxUrl'       => admin_url( 'admin-ajax.php' ),
		'currentUserId' => get_current_user_id(),
		'upload'        => admin_url( 'admin-ajax.php?action=sfm_file_upload' ),
//		'delete'        => admin_url( 'admin-ajax.php?action=sfm_file_delete' ),
	) );
}

add_action( 'wp_enqueue_scripts', 'sfm_load_scripts', 99 );


/* OLD CODE */
function sfm_enqueue_admin_script() {
	wp_enqueue_script( 'admin-scripts', get_stylesheet_directory_uri() . '/inc/js/admin.js', array( 'jquery' ), '1.0', true );
	$translation_array = array( 'templateUrl' => get_stylesheet_directory_uri() );
	wp_localize_script( 'admin-scripts', 'local_data', $translation_array );
}

add_action( 'admin_enqueue_scripts', 'sfm_enqueue_admin_script' );


// function my_acf_init() {
//     acf_update_setting('google_api_key', 'AIzaSyAG3T-wRVijpw-eECOOUW2O5WyhdfPiHIs');
// }
// add_action('acf/init', 'my_acf_init');

// shortcode include
require_once get_theme_file_path( 'inc/shortcodes.php' );

/**
 * Add a sidebar.
 */
function sfm_child_sidebar_register() {
	register_sidebar( array(
		'name'          => __( 'Footer 5', 'textdomain' ),
		'id'            => 'fre-footer-5',
		'description'   => __( 'Widgets in this area will be shown on all posts and pages.', 'textdomain' ),
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

	// $api->add_section( 'footer-social', array(
	// 	'title'    => 'Footer Social',
	// 	'priority' => 11,
	// ) );
	// $api->add_setting( 'instagram', array(
	// 	'default'   => "https://www.instagram.com/",
	// 	'transport' => 'refresh',
	// ) );
	// $api->add_control( 'instagram', array(
	// 	'section' => 'footer-social',
	// 	'label'   => 'Instagram',
	// 	'type'    => 'text',
	// ) );
	// $api->add_setting( 'facebook', array(
	// 	'default'   => "https://www.facebook.com/",
	// 	'transport' => 'refresh',
	// ) );
	// $api->add_control( 'facebook', array(
	// 	'section' => 'footer-social',
	// 	'label'   => 'Facebook',
	// 	'type'    => 'text',
	// ) );
	// $api->add_setting( 'twitter', array(
	// 	'default'   => "https://twitter.com/",
	// 	'transport' => 'refresh',
	// ) );
	// $api->add_control( 'twitter', array(
	// 	'section' => 'footer-social',
	// 	'label'   => 'Twitter',
	// 	'type'    => 'text',
	// ) );
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


//add_action( 'wp_print_scripts', 'my_enqueue_scripts' );
//
//function my_enqueue_scripts() {
//	wp_enqueue_script( 'tiny_mce' );
//	if ( function_exists( 'wp_tiny_mce' ) ) {
//		wp_tiny_mce();
//	}
//
//}

// function update_user_form(){

//     if( ! isset( $_POST['first_name']) && empty( $_POST['first_name'] )) {
//         $errors[] = __( 'First name is required.', ET_DOMAIN);
//     }

//     if( ! isset( $_POST['last_name']) && empty( $_POST['last_name'] )) {
//         $errors[] = __( 'Last name is required.', ET_DOMAIN);
//     }

// if( ! isset( $_POST['display_name']) && empty( $_POST['display_name'] )) {
//     $errors[] = __( 'Display name is required.', ET_DOMAIN);
// }

// if( count( $errors ) > 0 ) {
//     die();
// }

// $user_details = serialize( array(
//     'first_name'    => sanitize_text_field( $_POST['first_name'] ),
//     'last_name'     => sanitize_text_field( $_POST['last_name'] ),
// ) );

// update_user_meta( $user_id, 'user_details', $user_details);

//}


// function sfm_profile_picture_url( $url, $user_id ) {

// 	$att_id = get_user_meta( $user_id, 'sfm_profile_picture', true );

// 	if ( $att_id ) {
// 		$att_url = wp_get_attachment_url( $att_id );

// 		if ( ! empty( $att_url ) ) {
// 			return $att_url;
// 		}
// 	}

// 	return $url;
// }

// add_filter( 'get_avatar_url', 'sfm_profile_picture_url', 10, 2 );

/**
 * @param $name
 * @param $value
 */
function sfm_image_uploader_field( $name, $value = '' ) {
	$image      = ' button">Upload image';
	$image_size = 'thumbnail'; // it would be better to use thumbnail size here (150x150 or so)
	$display    = 'none'; // display state ot the "Remove image" button

	if ( $image_attributes = wp_get_attachment_image_src( $value, $image_size ) ) {

		// $image_attributes[0] - image URL
		// $image_attributes[1] - image width
		// $image_attributes[2] - image height

		$image   = '"><img src="' . $image_attributes[0] . '" style="max-width:200px;display:block;" />';
		$display = 'inline-block';

	}

	return '
	<div style="margin: 0 10px 55px 10px;max-width:250px;display:inline-block;">
		<a href="#" class="sfm_upload_image_button' . $image . '</a>
		<input type="hidden" name="' . $name . '" id="' . $name . '" value="' . $value . '" />
		<p class="hide-if-no-js howto">Click the image</p>
		<a href="#" class="sfm_remove_image_button" style="display:inline-block;display:' . $display . '">Remove image</a>
	</div>';
}

// metabox
function bid_attachment_file_meta() {
	add_meta_box(
		'attachment',
		'Attachment File',
		'bid_attachment_file_cal_back',
		array( 'bid' ),
		'normal',
		'default'
	);
}

add_action( 'add_meta_boxes', 'bid_attachment_file_meta' );

/**
 * @param $post
 */
function bid_attachment_file_cal_back( $post ) {
	echo sfm_image_uploader_field( 'bid_attachment_file_1', get_post_meta( $post->ID, 'bid_attachment_file_1', true ) );
	echo sfm_image_uploader_field( 'bid_attachment_file_2', get_post_meta( $post->ID, 'bid_attachment_file_2', true ) );
	echo sfm_image_uploader_field( 'bid_attachment_file_3', get_post_meta( $post->ID, 'bid_attachment_file_3', true ) );
	echo sfm_image_uploader_field( 'bid_attachment_file_4', get_post_meta( $post->ID, 'bid_attachment_file_4', true ) );
	echo sfm_image_uploader_field( 'bid_attachment_file_5', get_post_meta( $post->ID, 'bid_attachment_file_5', true ) );
}

/**
 * @param $post_id
 *
 * @return mixed
 */
function bid_attachment_file_database( $post_id ) {

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return $post_id;
	}

	if ( isset( $_POST['bid_attachment_file_1'] ) ) {
		update_post_meta( $post_id, 'bid_attachment_file_1', $_POST['bid_attachment_file_1'] );
	}

	if ( isset( $_POST['bid_attachment_file_2'] ) ) {
		update_post_meta( $post_id, 'bid_attachment_file_2', $_POST['bid_attachment_file_2'] );
	}

	if ( isset( $_POST['bid_attachment_file_3'] ) ) {
		update_post_meta( $post_id, 'bid_attachment_file_3', $_POST['bid_attachment_file_3'] );
	}

	if ( isset( $_POST['bid_attachment_file_4'] ) ) {
		update_post_meta( $post_id, 'bid_attachment_file_4', $_POST['bid_attachment_file_4'] );
	}

	if ( isset( $_POST['bid_attachment_file_5'] ) ) {
		update_post_meta( $post_id, 'bid_attachment_file_5', $_POST['bid_attachment_file_5'] );
	}

	if ( array_key_exists( 'project_id', $_POST ) ) {
		update_post_meta(
			$post_id,
			'project_id',
			sanitize_textarea_field( $_POST['project_id'] )
		);
	}

}

add_action( 'save_post', 'bid_attachment_file_database' );
// metabox

/**
 * @param $file_handler
 * @param $post_id
 * @param $set_thu
 *
 * @return mixed
 */
function multiple_handle_attachment( $file_handler, $post_id, $set_thu = false ) {
	// check to make sure its a successful upload
	if ( $_FILES[ $file_handler ]['error'] !== UPLOAD_ERR_OK ) {
		__return_false();
	}

	require_once ABSPATH . "wp-admin" . '/includes/image.php';
	require_once ABSPATH . "wp-admin" . '/includes/file.php';
	require_once ABSPATH . "wp-admin" . '/includes/media.php';

	$attach_id = media_handle_upload( $file_handler, $post_id );
	if ( is_numeric( $attach_id ) ) {
		update_post_meta( $post_id, '_my_file_upload', $attach_id );
	}

	return $attach_id;
}

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
 * Theme Fixing
 * Registering the missing taxonomies ['country, 'skill']
 */
function register_fre_missing_taxonomy() {
	$labels = array(
		'name'                  => _x( 'Countries', 'Taxonomy plural name', ET_DOMAIN ),
		'singular_name'         => _x( 'Country', 'Taxonomy singular name', ET_DOMAIN ),
		'search_items'          => __( 'Search countries', ET_DOMAIN ),
		'popular_items'         => __( 'Popular countries', ET_DOMAIN ),
		'all_items'             => __( 'All countries', ET_DOMAIN ),
		'parent_item'           => __( 'Parent country', ET_DOMAIN ),
		'parent_item_colon'     => __( 'Parent country', ET_DOMAIN ),
		'edit_item'             => __( 'Edit country', ET_DOMAIN ),
		'update_item'           => __( 'Update country ', ET_DOMAIN ),
		'add_new_item'          => __( 'Add New country ', ET_DOMAIN ),
		'new_item_name'         => __( 'New country Name', ET_DOMAIN ),
		'add_or_remove_items'   => __( 'Add or remove country', ET_DOMAIN ),
		'choose_from_most_used' => __( 'Choose from most used enginetheme', ET_DOMAIN ),
		'menu_name'             => __( 'Countries', ET_DOMAIN ),
	);
	$args   = array(
		'labels'            => $labels,
		'public'            => true,
		'show_in_nav_menus' => true,
		'show_admin_column' => true,
		'hierarchical'      => true,
		'show_tagcloud'     => true,
		'show_ui'           => true,
		'rewrite'           => array(
			'slug' => ae_get_option( 'country_slug', 'country' ),
		),
		'query_var'         => true,
		'capabilities'      => array(
			'manage_terms',
			'edit_terms',
			'delete_terms',
			'assign_terms',
		),
	);
	register_taxonomy( 'country', array( PROFILE, PROJECT ), $args );

	global $pagenow;
	$isHierarchical = true;
	$action         = isset( $_REQUEST['action'] ) ? $_REQUEST['action'] : '';
	if ( $pagenow == 'edit-tags.php' || $action == 'ae-project-sync' ) {
		$isHierarchical = false;
		$method         = isset( $_REQUEST['method'] ) ? $_REQUEST['method'] : '';
		if ( in_array( $method, array( 'create', 'update' ) ) ) {
			/**
			 * isHierarchical = false --> skill don't save.
			 * danng
			 */
			if ( ( isset( $_REQUEST['archive'] ) && $_REQUEST['archive'] ) || ( isset( $_REQUEST['publish'] ) && $_REQUEST['publish'] ) || ( isset( $_REQUEST['reject_message'] ) && ! empty( $_REQUEST['reject_message'] ) ) ) {
				$isHierarchical = false;
			} else {
				$isHierarchical = true;
			}
		}
	}

	$labels = array(
		'name'                  => _x( 'Skills', 'Taxonomy plural name', ET_DOMAIN ),
		'singular_name'         => _x( 'Skill', 'Taxonomy singular name', ET_DOMAIN ),
		'search_items'          => __( 'Search Skills', ET_DOMAIN ),
		'popular_items'         => __( 'Popular Skills', ET_DOMAIN ),
		'all_items'             => __( 'All Skills', ET_DOMAIN ),
		'parent_item'           => __( 'Parent Skill', ET_DOMAIN ),
		'parent_item_colon'     => __( 'Parent Skill', ET_DOMAIN ),
		'edit_item'             => __( 'Edit Skill', ET_DOMAIN ),
		'update_item'           => __( 'Update Skill ', ET_DOMAIN ),
		'add_new_item'          => __( 'Add New Skill ', ET_DOMAIN ),
		'new_item_name'         => __( 'New Skill Name', ET_DOMAIN ),
		'add_or_remove_items'   => __( 'Add or remove skill', ET_DOMAIN ),
		'choose_from_most_used' => __( 'Choose from most used enginetheme', ET_DOMAIN ),
		'menu_name'             => __( 'Skills', ET_DOMAIN ),
	);
	$args   = array(
		'labels'            => $labels,
		'public'            => true,
		'show_in_nav_menus' => true,
		'show_admin_column' => true,
		'hierarchical'      => $isHierarchical,
		'show_tagcloud'     => true,
		'show_ui'           => true,
		'query_var'         => true,
		'rewrite'           => array(
			'slug'         => ae_get_option( 'skill_slug', 'skill' ),
			'hierarchical' => false,
		),
		'capabilities'      => array(
			'manage_terms',
			'edit_terms',
			'delete_terms',
			'assign_terms',
		),
	);
	register_taxonomy( 'skill', array( PROFILE, PORTFOLIO, PROJECT ), $args );
}

add_action( 'init', 'register_fre_missing_taxonomy' );


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
			'freelance_menu' => __( 'Freelance Menu', 'ET_DOMAIN' ),
			'employer_menu'  => __( 'Employer Menu', 'ET_DOMAIN' ),
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


//function wpdocs_this_screen() {
//	$currentScreen = get_current_screen();
//	$pending       = new Pending_Users_Table();
//	if ( $currentScreen->id === "users" && isset( $_REQUEST['account_status'] ) && $_REQUEST['account_status'] == 'pending' ) {
//		$pending->set_data( $data );
//		$pending->display();
//		$pending->prepare_items();
//	}
//}
//
//add_action( 'current_screen', 'wpdocs_this_screen' );
//


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