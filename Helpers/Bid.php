<?php


class Bid {

	public function __construct() {
		add_action( 'wp_ajax_sfm_file_upload', array( $this, 'sfm_handle_file_upload' ) );
		add_action( 'wp_ajax_nopriv_sfm_file_upload', array( $this, 'sfm_handle_file_upload' ) );

		add_action( 'wp_ajax_sfm_file_delete', array( $this, 'sfm_handle_file_delete' ) );
		add_action( 'wp_ajax_nopriv_sfm_file_delete', array( $this, 'sfm_handle_file_delete' ) );

		add_action( 'wp_ajax_sfm_submit_proposal', array( $this, 'submit_proposal' ) );
		add_action( 'wp_ajax_nopriv_sfm_submit_proposal', array( $this, 'submit_proposal' ) );

		add_action( 'wp_ajax_sfm_accept_proposal', array( $this, 'accept_proposal' ) );
		add_action( 'wp_ajax_nopriv_sfm_accept_proposal', array( $this, 'accept_proposal' ) );

		add_action( 'wp_ajax_sfm_decline_proposal', array( $this, 'decline_proposal' ) );
		add_action( 'wp_ajax_nopriv_sfm_decline_proposal', array( $this, 'decline_proposal' ) );
	}


	// SFM Custom Uploader With pUpload
	public function sfm_handle_file_upload() {
		header( 'Content-Type: application/json' );

		if ( isset( $_FILES['file'] ) && $_FILES['file']['name'] != '' ) {
			// These files need to be included as dependencies when on the front end.
			require_once ABSPATH . 'wp-admin/includes/image.php';
			require_once ABSPATH . 'wp-admin/includes/file.php';
			require_once ABSPATH . 'wp-admin/includes/media.php';

			$attachment_id = media_handle_upload( 'file', 0 );

			if ( is_wp_error( $attachment_id ) ) {
				$errors[] = array( 'name' => 'file', 'message' => 'Error uploading image' );
				echo wp_json_encode( array( 'status' => false, 'errors' => $errors ) );
				wp_die();
			}

			echo wp_json_encode( $attachment_id );
		}

		wp_die();
	}


	public function sfm_handle_file_delete() {
		header( 'Content-Type: application/json' );

		if ( isset( $_POST['id'] ) && $_POST['id'] != '' ) {
			wp_delete_attachment( $_POST['id'], true );
			echo wp_json_encode( [ 'success' => true ] );
		}

		wp_die();
	}


	// Submit a proposal
	public function submit_proposal() {
		header( 'Content-Type: application/json' );

		$form_data = $_POST;
		$errors    = [];
		$has_error = false;

		$project       = get_post( $form_data['project_id'] );
		$freelancer_id = get_current_user_id();

		// Check required fields
		if ( $form_data['project_id'] == '' || $project->post_type != PROJECT ) {
			$errors[]  = array( 'name' => 'project_id', 'message' => 'Project ID is not valid' );
			$has_error = true;
		}
		if ( $form_data['bid_daily_wage'] == '' ) {
			$errors[]  = array( 'name' => 'bid_daily_wage', 'message' => 'Please enter daily wage' );
			$has_error = true;
		}
		if ( $form_data['bid_work_days'] == '' ) {
			$errors[]  = array( 'name' => 'bid_work_days', 'message' => 'Please enter number of days' );
			$has_error = true;
		}
		if ( $form_data['bid_deadline'] == '' ) {
			$errors[]  = array( 'name' => 'bid_deadline', 'message' => 'Please select a deadline' );
			$has_error = true;
		}
		if ( $form_data['bid_content'] == '' ) {
			$errors[]  = array( 'name' => 'bid_content', 'message' => 'This field is required' );
			$has_error = true;
		}

		// Show Errors on frontend
		if ( $has_error && $errors ) {
			echo wp_json_encode( array( 'status' => false, 'errors' => $errors ) );
			die();
		}

		// Create a new Bid
		$new_bid = wp_insert_post( array(
			'post_title'   => $project->post_title,
			'post_content' => sanitize_textarea_field( $form_data['bid_content'] ),
			'post_status'  => 'publish',
			'post_type'    => 'bid',
			'post_parent'  => $form_data['project_id'],
			'meta_input'   => array(
				'bid_daily_wage' => sanitize_text_field( $form_data['bid_daily_wage'] ),
				'bid_work_days'  => sanitize_text_field( $form_data['bid_work_days'] ),
				'bid_deadline'   => sanitize_text_field( $form_data['bid_deadline'] ),
			)
		) );

		// Update Bid count of the project
		$old_project_bids = get_post_meta( $form_data['project_id'], 'total_bids', true );
		update_post_meta( $form_data['project_id'], 'total_bids', ( $old_project_bids + 1 ) );

		// Update Images
		if ( $form_data['proposal_files'] != '' ) {
			$image_ids = explode( ',', $form_data['proposal_files'] );
			foreach ( $image_ids as $attachment ) {
				wp_update_post( array(
					'ID'          => $attachment,
					'post_parent' => $new_bid,
				) );
			}
		}

		// Create a new notification
		$notify_content = 'type=new_bid&project=' . $form_data['project_id'] . '&bid=' . $new_bid;
		$notification   = wp_insert_post( array(
			'post_type'    => 'notify',
			'post_content' => $notify_content,
			'post_excerpt' => $notify_content,
			'post_author'  => $project->post_author,
			'post_title'   => sprintf( __( "New bid on %s", ET_DOMAIN ), $project->post_title ),
			'post_status'  => 'publish',
			'post_parent'  => $form_data['project_id'],
		) );

		// Update notification id to new bid meta
		update_post_meta( $new_bid, 'notify_id', $notification );

		// Send an Email to Project author
		$employer_id           = $project->post_author;
		$sfm_mail_notification = new Email_Notification();
		$sfm_mail_notification->new_bid_notification_cb( $employer_id, $project );
//		do_action( 'new_bid_notification', $employer_id, $project );

		echo wp_json_encode( [
			'status'   => true,
			'message'  => __( 'Your proposal has been submitted successfully', ET_DOMAIN ),
			'redirect' => get_permalink( $form_data['project_id'] ),
		] );

		die();
	}


	public function accept_proposal() {
		header( 'Content-Type: application/json' );

		$form_data = $_POST;
		$errors    = [];
		$has_error = false;

		// Check required fields
		if ( $form_data['bid_id'] == '' ) {
			$errors[]  = array( 'name' => 'bid_id', 'message' => 'Bid ID is can not be empty!' );
			$has_error = true;
		}

		// Show Errors on frontend
		if ( $has_error && $errors ) {
			echo wp_json_encode( array( 'status' => false, 'errors' => $errors ) );
			die();
		}


		$bid           = get_post( $form_data['bid_id'] );
		$employer_id   = get_current_user_id();
		$freelancer_id = $bid->post_author;
		$project       = get_post( $bid->post_parent );

		// Update Project Status
		wp_update_post( array(
			'ID'          => $project->ID,
			'post_status' => 'close',
		) );
		// Save accepted project id to post meta
		update_post_meta( $project->ID, 'accepted', $bid->ID );

		// Update bid status to accepted
		wp_update_post( array(
			'ID'          => $form_data['bid_id'],
			'post_status' => 'accept',
		) );

		// Set all other bids to unaccepted
		$other_bids = new WP_Query( array(
			'post_type'   => BID,
			'post_parent' => $project->ID,
			'post_status' => array( 'publish', 'unaccept' ),
		) );

		if ( $other_bids->have_posts() ) {
			foreach ( $other_bids->posts as $bid ) {
				if ( $bid->post_author != $freelancer_id ) {
					wp_update_post( array(
						'ID'          => $bid->ID,
						'post_status' => 'unaccept',
					) );
				}
			}
		}

		// Create a new notification for freelancer
//		$notify_content = 'type=bid_accept&project=' . $project->ID;
		$notify_content = 'type=delete_bid&amp;freelancer=' . $bid->post_author . '&amp;project=' . $project->ID . '&amp;bid=' . $bid->ID;
		$notification   = wp_insert_post( array(
			'post_type'    => 'notify',
			'post_content' => $notify_content,
			'post_excerpt' => $notify_content,
			'post_author'  => $freelancer_id,
			'post_title'   => sprintf( __( "Bid on %s was accepted", ET_DOMAIN ), $project->post_title ),
			'post_status'  => 'publish',
			'post_parent'  => $project->ID,
		) );
		update_user_meta( $freelancer_id, 'fre_new_notify', $notification );
		update_post_meta( $bid, 'notify_id', $notification );

		// Send email to freelancer and admin
		$company_name = get_user_meta( $employer_id, 'company_name', true );
//		do_action( 'accept_proposal_notification', $project, $employer_id, $company_name, $freelancer_id );
		$sfm_mail_notification = new Email_Notification();
		$sfm_mail_notification->accept_proposal_notification_cb( $project, $employer_id, $company_name, $freelancer_id );


		echo wp_json_encode( [
			'status'   => true,
			'message'  => __( 'You have successfully accepted the proposal', ET_DOMAIN ),
			'redirect' => get_permalink( $project->ID ),
		] );

		wp_die();
	}


	public function decline_proposal() {
		header( 'Content-Type: application/json' );

		$form_data = $_POST;
		$errors    = [];
		$has_error = false;

		// Check required fields
		if ( $form_data['bid_id'] == '' ) {
			$errors[]  = array( 'name' => 'bid_id', 'message' => 'Bid ID is not valid' );
			$has_error = true;
		}

		$bid = get_post( $form_data['bid_id'] );

		if ( $bid->post_type != BID ) {
			$errors[]  = array( 'name' => 'bid_id', 'message' => 'Bid ID is not valid' );
			$has_error = true;
		}

		// Show Errors on frontend
		if ( $has_error && $errors ) {
			echo wp_json_encode( array( 'status' => false, 'errors' => $errors ) );
			die();
		}

		$project    = get_post( $bid->post_parent );
		$freelancer = get_userdata( $bid->post_author );

		wp_update_post( [
			'ID'          => $form_data['bid_id'],
			'post_status' => 'unaccept',
		] );

		// Create a new notification for freelancer
//		$notify_content = 'type=delete_bid&project=' . $project->ID;
//		$notify_content = 'type=delete_bid&amp;freelancer=' . $bid->post_author . '&amp;project='. $project->ID . '&amp;bid=' . $bid->ID;
		$notify_content = 'type=decline_bid&amp;freelancer=' . $bid->post_author . '&amp;project=' . $project->ID . '&amp;bid=' . $bid->ID;
		$notification   = wp_insert_post( array(
			'post_type'    => 'notify',
			'post_content' => $notify_content,
			'post_excerpt' => $notify_content,
			'post_author'  => $bid->post_author,
			'post_title'   => sprintf( __( "Bid on %s was declined", ET_DOMAIN ), $project->post_title ),
			'post_status'  => 'publish',
			'post_parent'  => $project->ID,
		) );
		update_user_meta( $bid->post_author, 'fre_new_notify', $notification );

//		do_action( 'declined_proposal_notification', $project, $freelancer );
		$sfm_mail_notification = new Email_Notification();
		$sfm_mail_notification->declined_proposal_notification_cb( $project, $freelancer );

		echo wp_json_encode( [
			'status'   => true,
			'message'  => __( 'You have successfully declined the proposal', ET_DOMAIN ),
			'redirect' => get_permalink( $project->ID ),
		] );

		wp_die();
	}


}

new Bid();