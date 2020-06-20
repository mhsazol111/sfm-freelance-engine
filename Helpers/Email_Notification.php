<?php


class Email_Notification {

	private $admin_emails;
	private $headers;

	public function __construct() {
		$admin_emails       = get_field( 'admin_emails', 'option' );
		$this->admin_emails = [];
		foreach ( $admin_emails as $email ) {
			$this->admin_emails[] = $email['admin_email'];
		}
		$headers = array(
			"Content-Type: text/html",
			"charset=UTF-8",
			"From: SFM <email@sfm.com>"
		);

		$this->admin_emails = $admin_emails;
		$this->headers      = $headers;

		add_action( 'user_register_email', array( $this, 'user_register_email_cb' ), 10, 3 );
	}


	// Send email notification about new account
	public function user_register_email_cb( $role, $user_id, $user_email ) {
		$subject     = __( 'New user sign up notification.', ET_DOMAIN );
		$message     = __( 'A new user just signed up as ' . $role . '. Please review the profile and take appropriate action. <a href="' . get_site_url() . '/wp-admin/user-edit.php?user_id=' . $user_id . '&wp_http_referer=%2Fwp-admin%2Fusers.php">View User</a>', ET_DOMAIN );
		wp_mail( $this->admin_emails, $subject, $message, $this->headers );

		wp_mail( $user_email, __( 'Welcome to SFM', ET_DOMAIN ), __( 'Welcome to SFM, We are currently reviewing your account. We will let you know once your account is approved. Thank you.', ET_DOMAIN ), $this->headers );
	}

}

new Email_Notification();