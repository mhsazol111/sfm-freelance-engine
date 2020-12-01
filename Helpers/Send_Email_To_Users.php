<?php

class Send_Email_To_Users extends Email_Notification {
	public function __construct() {
		parent::__construct();
		add_action( 'wp_ajax_handle_render_user_list_type', array( $this, 'render_user_list_type' ) );
		add_action( 'wp_ajax_nopriv_handle_render_user_list_type', array( $this, 'render_user_list_type' ) );

		add_action( 'wp_ajax_handle_multiple_user_email', array( $this, 'send_multiple_user_email' ) );
		add_action( 'wp_ajax_nopriv_handle_multiple_user_email', array( $this, 'send_multiple_user_email' ) );
	}

	public function render_user_list_type() {
		$args = array();
		$data = $_POST['inputData'];

		if ( isset( $data['role'] ) && $data['role'] == 'all' ) {
			$args['role__in'] = array( 'freelancer', 'employer' );
		}
		if ( isset( $data['role'] ) && $data['role'] == 'freelancer' ) {
			$args['role__in'] = array( 'freelancer' );
		}
		if ( isset( $data['role'] ) && $data['role'] == 'employer' ) {
			$args['role__in'] = array( 'employer' );
		}
		if ( isset( $data['role'] ) && $data['role'] == 'pending' ) {
			$args['meta_key']     = 'account_status';
			$args['meta_value']   = 'pending';
			$args['meta_compare'] = '=';
		}
		if ( isset( $data['search'] ) && $data['search'] != '' ) {
			$args['search']         = $data['search'];
			$args['search_columns'] = array( 'user_nicename', 'user_login', 'user_email', 'display_name' );
		}

		$users = new WP_User_Query( $args );
		$users = $users->get_results();

		ob_start();
		if ( $users ) {
			foreach ( $users as $user ) {
				include( locate_template( 'template-parts/admin/users/table-item.php' ) );
			}
		} else {
			echo '<tr><td colspan="6"><p>No user found!</p></td></tr>';
		}
		echo ob_get_clean();
		wp_die();
	}

	public function send_multiple_user_email() {
		header( 'Content-Type: application/json' );

		$email_data   = $_REQUEST['email'];
		$user_ids     = isset( $email_data['userIds'] ) && $email_data['userIds'] ? $email_data['userIds'] : '';
		$user_ids     = explode( ',', $user_ids );
		$user_ids     = array_filter( $user_ids );
		$mail_form    = isset( $email_data['mailFrom'] ) && $email_data['mailFrom'] ? $email_data['mailFrom'] : '';
		$mail_subject = isset( $email_data['mailSubject'] ) && $email_data['mailSubject'] ? $email_data['mailSubject'] : '';
		$mail_content = isset( $email_data['mailContent'] ) && $email_data['mailContent'] ? $email_data['mailContent'] : '';

		if ( ! isset( $_REQUEST['nonce'] ) || ! wp_verify_nonce( $_REQUEST['nonce'], 'email_user_nonce_action' ) ) {
			echo wp_json_encode( [ 'success' => false ] );
			wp_die();
		}

		$headers   = [];
		$headers[] = "Content-Type: text/html";
		$headers[] = "charset=UTF-8";
		$headers[] = "From: SFM <{$mail_form}>";

		foreach ( $user_ids as $user_id ) {
			$user              = get_userdata( $user_id );
			$user_replaces     = array(
				'{{first_name}}',
				'{{last_name}}',
				'{{email}}',
				'{{registered_as}}',
				'{{user_id}}',
				'{{dashboard_link}}',
			);
			$user_replace_with = array(
				$user->first_name,
				$user->last_name,
				$user->user_email,
				$user->roles[0],
				$user_id,
				esc_url( get_site_url() . '/dashboard/' ),
			);
			$mail_content      = str_replace( $user_replaces, $user_replace_with, $mail_content );

			wp_mail( $user->user_email, $mail_subject, $this->email_body_html( $mail_content ), $headers );
		}

		echo wp_json_encode( [ 'success' => true ] );
		wp_die();
	}
}

new Send_Email_To_Users();
