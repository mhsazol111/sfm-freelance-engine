<?php


class Bid {

	public function __construct() {
		add_action( 'wp_ajax_sfm_submit_proposal', array( $this, 'submit_proposal' ) );
		add_action( 'wp_ajax_nopriv_sfm_submit_proposal', array( $this, 'submit_proposal' ) );

		add_action( 'wp_ajax_sfm_accept_proposal', array( $this, 'accept_proposal' ) );
		add_action( 'wp_ajax_nopriv_sfm_accept_proposal', array( $this, 'accept_proposal' ) );
	}

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
		$author_email = get_userdata( $project->post_author )->user_email;
		$subject      = 'You have a new bid on your project';
		$message      = "Hi there, You have a new bid on your following project: <a href='" . get_permalink( $project->ID ) . "'>" . $project->post_title . "</a>. Thank you.";
		$headers      = array(
			"Content-Type: text/html",
			"charset=UTF-8",
			"From: SFM <email@sfm.com>"
		);
		wp_mail( $author_email, $subject, $message, $headers );

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
		$notify_content = 'type=bid_accept&project=' . $project->ID;
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

		// Send email to freelancer and admin
		$admin_email  = get_option( 'admin_email' );
		$freelancer   = get_userdata( $freelancer_id );
		$employer     = get_userdata( $employer_id );
		$company_name = get_user_meta( $employer_id, 'company_name', true );
		$subject      = 'New Project Started!';
		$message      = "Hi there, The following project: <a href='" . get_permalink( $project->ID ) . "'>" . $project->post_title . "</a> is started. The project was created by {$employer->display_name} from {$company_name} and it has been assigned to {$freelancer->display_name}. Please contact with them. Thank you.";
		$headers      = array(
			"Content-Type: text/html",
			"charset=UTF-8",
			"From: SFM <email@sfm.com>"
		);
		wp_mail( $admin_email, $subject, $message, $headers );
		wp_mail( $freelancer->user_email, __( 'Proposal Accepted!', ET_DOMAIN ), __( "Congratulation! Your proposal on <a href='" . get_permalink( $project->ID ) . "'>" . $project->post_title . "</a> has been accepted. Keep up the good work. Thank you.", ET_DOMAIN ), $headers );

		echo wp_json_encode( [
			'status'   => true,
			'message'  => __( 'Your proposal accepted successfully', ET_DOMAIN ),
			'redirect' => get_permalink( $project->ID ),
		] );

		wp_die();
	}


}

new Bid();