<?php


class Admin_Functions {
	public function __construct() {
		add_action( 'wp_ajax_handle_pending_user_action', array( $this, 'pending_user_action' ) );
		add_action( 'wp_ajax_nopriv_handle_pending_user_action', array( $this, 'pending_user_action' ) );
	}

	// Handle Pending User Actions from Admin Panel
	public function pending_user_action() {
		header( 'Content-Type: application/json' );

		$actionType = isset( $_POST['actionType'] ) && $_POST['actionType'] != '' ? $_POST['actionType'] : '';
		$user_id    = isset( $_POST['userId'] ) && $_POST['userId'] != '' ? $_POST['userId'] : '';

		if ( ! $user_id ) {
			echo wp_json_encode( [ 'success' => false, 'message' => 'User ID not found!' ] );
			wp_die();
		}

		$current_status = get_user_meta( $user_id, 'account_status', true );
		if ( $current_status != 'pending' ) {
			echo wp_json_encode( [
				'success' => false,
				'message' => 'User status is invalid or user is already approved!'
			] );
			wp_die();
		}

		if ( 'approve' == $actionType ) {
			// Update Account Status
			update_user_meta( $user_id, 'account_status', 'active' );

			// Send Approved notification
//			do_action( 'pending_user_approval_email', $user_id );
			$sfm_mail_notification = new Email_Notification();
			$sfm_mail_notification->pending_user_approval_email_cb( $user_id );

			echo wp_json_encode( [
				'success'  => true,
				'message'  => 'User successfully approved!',
				'redirect' => get_site_url() . '/wp-admin/users.php?page=pending_users',
			] );

			wp_die();

		} elseif ( 'delete' == $actionType ) {
			// Delete user
			wp_delete_user( $user_id );

			echo wp_json_encode( [
				'success'  => true,
				'message'  => 'User successfully deleted.',
				'redirect' => get_site_url() . '/wp-admin/users.php?page=pending_users',
			] );

			wp_die();
		}

		wp_die();
	}
}

new Admin_Functions();