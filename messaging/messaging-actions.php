<?php
if( ! defined( 'ABSPATH' ) ) die( "You can't access this file directly" );


/**
 * Action for Inquiry Message submit
 * @param  $project_id
 * @param  $inquiry_message
 * @param  $author_id
 * @return boolean|void
 */
function la_inquiry_message_submit_callback( $project_id, $inquiry_message, $author_id ){
	if ( ! is_user_logged_in() ) return false;
	$sender_id = get_current_user_id();
	$args = array(
		'project_id' => $project_id,
		'author_id' => $author_id,
		'sender_id' => $sender_id,
		'message' => $inquiry_message,
	);

	$pm = new LAPrivateMessaging();
	$status = $pm->create_message($args);

	$time = current_time( 'mysql' );
	$time = mysql2date('U', $time, false);
	$send_time = date( 'h:ia @ M d', $time );
	$current_time = str_replace( '@', 'on', $send_time);
	// Send email to CM if message saved
	if( $status ) {
		// Project
		$project = get_post( $project_id );
		$project_title = '<a href="' . get_permalink( $project->ID ) . '">'. $project->post_title .'!</a>';
		// Author
		$author = get_user_by('ID', $author_id );
		$author_name = get_short_username( $author );
		// CM details
		$cm_id = $project->post_author;
		$cm = get_user_by('ID', $cm_id );
		$cm_name = $cm->first_name;
		if( empty( $cm_name ) ){
			$cm_name = $cm->display_name;
		}
		// Links
		$message_link = get_site_url() . '/messages'; // will be changed later
		$settings_link = get_site_url() . '/profile'; // will be changed later
		// if author
		if( FREELANCER == ae_user_role($sender_id) ) {
			// Author message
			$author_message = '<div style="padding: 10px; background-color: #eef1ff; width: 100%; margin: 20px 0;">';
			$author_message .= '<p style="margin:0;"><strong>'.$author_name.' - '. $current_time .'</strong></p>';
			$author_message .= '<p style="margin: 5px 0px 0;">' . $inquiry_message . '</p>';
			$author_message .= '</div>';
			// Create email
			$email_settings = get_messaging_option( 'author_email_settings' );
			$subject = $email_settings['subject'];
			$email_content = $email_settings['email_content'];
			$replaces = array(
				'{{cm_name}}', '{{project_title}}', '{{message}}', '{{message_link}}', '{{settings_link}}'
			);
			$replace_with = array(
				$cm_name, $project_title, $author_message, esc_url( $message_link ), esc_url( $settings_link )
			);
			$email_content = str_replace( $replaces, $replace_with, $email_content);
			// Create a new notification
			$args = array(
				'author' => $author->ID, 'project' => $project->ID, 'notify_to' => $cm->ID
			);
			send_message_notification( $args );
			// Okay, everything done! Now send it.
			la_send_email( $cm->user_email, $subject, $email_content );
		}
		// If CM
		if( EMPLOYER == ae_user_role($sender_id) ) {
			$author_f_name = $author->first_name;
			// Author message
			$author_message = '<div style="padding: 10px; background-color: #eef1ff; width: 100%; margin: 20px 0;">';
			$author_message .= '<p style="margin:0;"><strong>'.$cm_name.' - '. $current_time .'</strong></p>';
			$author_message .= '<p style="margin: 5px 0px 0;">' . $inquiry_message . '</p>';
			$author_message .= '</div>';
			// Create email
			$email_settings = get_messaging_option( 'cm_email_settings' );
			$subject = $email_settings['subject'];
			$email_content = $email_settings['email_content'];
			$replaces = array(
				'{{author_name}}', '{{project_title}}', '{{message}}', '{{message_link}}'
			);
			$replace_with = array(
				$author_f_name, $project_title, $author_message, esc_url( $message_link )
			);
			$email_content = str_replace( $replaces, $replace_with, $email_content);
			// Create a new notification
			$args = array(
				'author' => $author->ID, 'project' => $project->ID, 'notify_to' => $author->ID
			);
			send_message_notification( $args );
			// Okay, everything done! Now send it.
			la_send_email( $author->user_email, $subject, $email_content );
		}
	}
}
add_action( 'la_inquiry_message_submit', 'la_inquiry_message_submit_callback', 10, 3 );

/**
 * Ajax: Get Inquire Message items
 */
function la_get_inquiry_message_items() {
	$data = $_POST;
	if( ! wp_verify_nonce( $data['reply_nonce'], '_la_message_reply' ) ) {
		echo 'Check if you are in right place, please reload the page and try again.';
		die();
	}
	$project_id = isset( $data['project_id'] ) ? sanitize_text_field( $data['project_id'] ) : '';
	$author_id = isset( $data['author_id'] ) ? sanitize_text_field( $data['author_id'] ) : '';
	if( empty( $project_id ) || empty( $author_id ) ) {
		echo "Required field is empty, please try again from the right page!";
		die();
	}
	$project = get_post( $project_id );
	$messages = get_project_messages ( $project_id, $author_id );
	include_once dirname( __FILE__ ) . '/parts/ajax-message-item.php';
	la_mark_project_read( $project_id, $author_id );
	die();
}
add_action( 'wp_ajax_get_inquiry_message_items', 'la_get_inquiry_message_items');
add_action( 'wp_ajax_nopriv_get_inquiry_message_items', 'la_get_inquiry_message_items');

/**
 * Get Live Message Item
 */
function la_get_live_message_item(){
	$data = $_POST;
	if( ! wp_verify_nonce( $data['reply_nonce'], '_la_message_reply' ) ) {
		// echo 'Check if you are in right place, please reload the page and try again.';
		die();
	}
	$project_id = isset( $data['project_id'] ) ? sanitize_text_field( $data['project_id'] ) : '';
	$author_id = isset( $data['author_id'] ) ? sanitize_text_field( $data['author_id'] ) : '';
	if( empty( $project_id ) || empty( $author_id ) ) {
		// echo "Required field is empty, please try again from the right page!";
		die();
	}
	$messages = get_project_messages ( $project_id, $author_id, true );
	$extraClass = 'unread';
	if( count( $messages ) > 0 ) {
		foreach ( $messages as $message ) {
			include dirname( __FILE__ ) . '/parts/ajax-single-message-item.php';
		}
		la_mark_project_read( $project_id, $author_id );
	}
	die();
}
add_action( 'wp_ajax_get_live_messages', 'la_get_live_message_item');
add_action( 'wp_ajax_nopriv_get_live_messages', 'la_get_live_message_item');

/**
 * Ajax: get user profile
 */
function la_get_user_profile () {
	$data = $_POST;
	if( ! wp_verify_nonce( $data['csrf_token'], '_user_profile_nonce' ) ) {
		echo 'Check if you are in right place, please reload the page and try again.';
		die();
	}
	$user_id = isset( $data['user_id'] ) ? sanitize_text_field( $data['user_id'] ) : '';
	if( empty( $user_id ) ) {
		echo "Required field is empty, please try again from the right page!";
		die();
	}
	$user = get_userdata( $user_id );
	include_once dirname( __FILE__ ) . '/parts/modals/author-profile.php';
	die();
}
add_action( 'wp_ajax_la_get_user_profile', 'la_get_user_profile');
add_action( 'wp_ajax_nopriv_la_get_user_profile', 'la_get_user_profile');

/**
 * Ajax: get DA from Moz API
 */
function la_get_da_from_moz () {
	header( 'Content-Type: application/json;' );
	$post = $_POST;
	if( ! wp_verify_nonce( $post['csrf_token'], '_la_csrf_token' ) ) {
		echo wp_json_encode( [ 'status' => false, 'msg' => 'Try from appropriate page!'] );
		die();
	}
	$domain = isset( $post['domain'] ) ? sanitize_text_field( $post['domain'] ) : '';
	$follow = isset( $post['follow'] ) ? sanitize_text_field( $post['follow'] ) : '';
	if( empty( $domain ) ) {
		echo wp_json_encode( [ 'status' => false, 'msg' => 'Domain name is needed'] );
		die();
	}

	$domain_authority = get_da_from_moz_api( $domain );
	$pricing = get_pricing_from_da( $domain_authority, $domain, $follow );
	echo wp_json_encode( [ 'status' => true, 'msg' => $domain_authority, 'price' => $pricing ] );
	die();
}
add_action( 'wp_ajax_la_get_da_from_moz', 'la_get_da_from_moz' );
add_action( 'wp_ajax_nopriv_la_get_da_from_moz', 'la_get_da_from_moz' );

/**
 * Ajax: My Author Profile Information save
 */
function la_save_my_author_info(){
	$data = $_POST;
	if( ! wp_verify_nonce( $data['_csrf_token'], '_my_author_info' ) ) {
		echo wp_json_encode( ['status' => false, 'msg' => 'Invalid Request!'] );
		die();
	}
	$author_id = isset( $data['author_id'] ) ? sanitize_text_field( $data['author_id'] ) : '';
	$profile_id = isset( $data['profile_id'] ) ? sanitize_text_field( $data['profile_id'] ) : '';
	if ( empty( $author_id ) ) {
		echo wp_json_encode( ['status' => false, 'msg' => 'Information missing, please try again!'] );
		die();
	}
	$profile_title = isset( $data['my_author_title'] ) ? sanitize_text_field( $data['my_author_title'] ) : '';
	$profile_bio = isset( $data['my_author_bio'] ) ? sanitize_textarea_field( $data['my_author_bio'] ) : '';

	// Update Profile Information
	update_user_meta( $author_id, 'et_professional_title', $profile_title );
	update_user_meta( $author_id, 'description', $profile_bio );
	if( !empty( $profile_id ) ) {
		update_post_meta( $profile_id, 'et_professional_title', $profile_title );
	}

	echo wp_json_encode( ['status' => true, 'msg' => 'Information saved successfully!'] );
	die();
}
add_action( 'wp_ajax_la_save_my_author_info', 'la_save_my_author_info' );
add_action( 'wp_ajax_nopriv_la_save_my_author_info', 'la_save_my_author_info' );