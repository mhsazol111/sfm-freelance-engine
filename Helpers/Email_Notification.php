<?php


class Email_Notification {

	private $admin_emails;
	private $headers;

	public function __construct() {
		$emails       = get_field( 'admin_emails', 'option' );
		$emails_array = [];
		foreach ( $emails as $email ) {
			$emails_array[] = $email['admin_email'];
		}
		$this->admin_emails = $emails_array;

		$headers       = [];
		$headers[]     = "Content-Type: text/html";
		$headers[]     = "charset=UTF-8";
		$headers[]     = "From: SFM <email@sfm.com>";
		$this->headers = $headers;

		add_action( 'user_register_email', array( $this, 'user_register_email_cb' ), 10, 3 );
		add_action( 'pending_user_approval_email', array( $this, 'pending_user_approval_email_cb' ), 10, 1 );
		add_action( 'new_bid_notification', array( $this, 'new_bid_notification_cb' ), 10, 2 );
		add_action( 'accept_proposal_notification', array( $this, 'accept_proposal_notification_cb' ), 10, 4 );
		add_action( 'post_project_notification', array( $this, 'post_project_notification_cb' ), 10, 2 );
	}


	// Send email notification about new account
	public function user_register_email_cb( $role, $user_id, $user_email ) {
		$subject = __( 'New user sign up notification.', ET_DOMAIN );
		$message = __( 'A new user just signed up as ' . $role . '. Please review the profile and take appropriate action. <a href="' . get_site_url() . '/wp-admin/user-edit.php?user_id=' . $user_id . '&wp_http_referer=%2Fwp-admin%2Fusers.php">View User</a>', ET_DOMAIN );
		wp_mail( $this->admin_emails, $subject, $message, $this->headers );

		wp_mail( $user_email, __( 'Welcome to SFM', ET_DOMAIN ), __( 'Welcome to SFM, We are currently reviewing your account. We will let you know once your account is approved. Thank you.', ET_DOMAIN ), $this->headers );
	}

	// Send email to user after their account approval
	public function pending_user_approval_email_cb( $user_email ) {
		$subject = __( 'Account Approved.', ET_DOMAIN );
		$message = __( "Thanks for your patience, Your account has been approved by SFM. Please update your profile information after login and proceed", ET_DOMAIN );
		wp_mail( $user_email, $subject, $message, $this->headers );
	}

	// Send email to employer if their project have a bid
	public function new_bid_notification_cb( $employer_email, $project ) {
		$subject = 'You have a new bid on your project';
		$message = "Hi there, You have a new bid on your following project: <a href='" . get_permalink( $project->ID ) . "'>" . $project->post_title . "</a>. Thank you.";
		wp_mail( $employer_email, $subject, $message, $this->headers );
	}

	// Send Email to admin and freelancer if a bid is accepted
	public function accept_proposal_notification_cb( $project, $employer, $company_name, $freelancer ) {
		$subject = __( 'New Project Started!', ET_DOMAIN );
		$message = "Hi there, The following project: <a href='" . get_permalink( $project->ID ) . "'>" . $project->post_title . "</a> is started. The project was created by {$employer->display_name} from {$company_name} and it has been assigned to {$freelancer->display_name}. Please contact with them. Thank you.";
		wp_mail( $this->admin_emails, $subject, $message, $this->headers );
		wp_mail( $freelancer->user_email, __( 'Proposal Accepted!', ET_DOMAIN ), __( "Congratulation! Your proposal on <a href='" . get_permalink( $project->ID ) . "'>" . $project->post_title . "</a> has been accepted. Keep up the good work. Thank you.", ET_DOMAIN ), $this->headers );
	}

	// Send notification to admins about new posted project.
	public function post_project_notification_cb( $employer_id, $project_id ) {
		$employer_name = get_userdata( $employer_id )->display_name;
		$project       = get_post( $project_id );
		$subject       = __( 'New Project Notification' );
		$message       = "A new project (<a href='" . get_permalink( $project_id ) . "'>{$project->post_title})</a> is posted by {$employer_name}. Please take a look and take necessary action. Thank you.";
		wp_mail( $this->admin_emails, $subject, $message, $this->headers );
	}

}

new Email_Notification();