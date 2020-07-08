<?php
if( ! defined('ABSPATH') ) die('No direct access, please!');

if( ! function_exists( 'sfm_is_translating' ) ) {
	/**
	 * Check if user currently translating the site.
	 *
	 * @param string $user_role
	 *
	 * @return bool
	 */
	function sfm_is_translating( $user_role = 'administrator' ) {
		// Check if TranslatePress is installed and active.
		if( ! class_exists( 'TRP_Translate_Press' ) ) return false;

		// Now check if it's translating
		if( isset( $_GET['trp-edit-translation'] ) && 'preview' == $_GET['trp-edit-translation'] ) {
			$current_user_id = get_current_user_id();
			return $user_role == ae_user_role( $current_user_id );
		}
		return false;
	}
}

if ( !function_exists( 'sfm_translating_as') ) {
	/**
	 * Check if given user role is translating the page.
	 *
	 * @param string $user_role  employer || freelancer
	 *
	 * @return bool
	 */
	function sfm_translating_as( $user_role ) {
		if( sfm_is_translating() ) {
			return isset( $_GET['trp-view-as'] ) && $user_role == $_GET['trp-view-as'];
		}
		return false;
	}
}