<?php


class Email_Notification {

	private $admin_emails;
	private $headers;
	private $from_email;


	public function __construct() {
		$this->from_email = get_field( 'from_email', 'option' );
		$emails       = get_field( 'admin_emails', 'option' );
		$emails_array = [];
		if ( $emails ) {
			foreach ( $emails as $email ) {
				$emails_array[] = $email['admin_email'];
			}
		}
		$this->admin_emails = $emails_array;

		$headers       = [];
		$headers[]     = "Content-Type: text/html";
		$headers[]     = "charset=UTF-8";
		$headers[]     = "From: SFM <{$this->from_email}>";
		$this->headers = $headers;

		add_filter('ae_get_mail_header', array($this, 'change_sfm_default_email_header'));
		add_filter('ae_get_mail_footer', array($this, 'change_sfm_default_email_footer'));

		add_action( 'user_register_email', array( $this, 'user_register_email_cb' ), 10, 3 );
		add_action( 'pending_user_approval_email', array( $this, 'pending_user_approval_email_cb' ), 10, 1 );
		add_action( 'new_bid_notification', array( $this, 'new_bid_notification_cb' ), 10, 2 );
		add_action( 'accept_proposal_notification', array( $this, 'accept_proposal_notification_cb' ), 10, 4 );
		add_action( 'post_project_notification', array( $this, 'post_project_notification_cb' ), 10, 2 );
	}


	public function change_sfm_default_email_header() {
		return '<table width="100%" border="0" cellpadding="5" cellspacing="0" style="border: 2px solid #2094c6; max-width: 600px; margin: auto;">
            <thead>
                <tr>
                    <th colspan="6" style="padding: 15px 20px;text-align: center">
                        <img style="max-width: 120px; width: 120px;" src="' . esc_url(get_stylesheet_directory_uri() . '/inc/images/SFM-Logo.png') . '" alt="SFM">
                    </th>
                </tr>
            </thead>
            <tbody style="border-top: 5px solid #2094c6;">
                <tr>
                    <td colspan="6" style="padding: 20px 20px; border-top: 5px solid #2094c6; font-family:sans-serif; font-size: 16px;line-height: 1.5">';
	}

	public function change_sfm_default_email_footer() {
		return '</td>
                </tr>
            </tbody>
            <tfoot style="background-color: #2094c6;">
                <tr>
                    <td colspan="4" style="color: #fff; font-family:sans-serif; padding: 15px 20px; font-size: 14px; line-height: 1.4">
                        &copy;2020. Switzerland Freelance Marketplace.<br> All Right Reserved.
                    </td>
                    <td colspan="2" style="text-align: right; color: #fff; padding: 15px 20px; font-family:sans-serif; font-size: 14px; line-height: 1.4">SFM<br>
                        <a style="color: #fff; font-family:sans-serif;" href="mailto:<?php echo $this->from_email ?>">' . get_field( 'from_email', 'option' ) . '</a>
                    </td>
                </tr>
            </tfoot>
        </table>';
	}

	public function email_body_html( $body_text ) {
		ob_start();
		?>
        <table width="100%" border="0" cellpadding="5" cellspacing="0" style="border: 2px solid #2094c6; max-width: 600px; margin: auto;">
            <thead>
                <tr>
                    <th colspan="6" style="padding: 15px 20px;text-align: center">
                        <img style="max-width: 120px; width: 120px;" src="<?php echo esc_url(get_stylesheet_directory_uri() . '/inc/images/SFM-Logo.png') ?>" alt="SFM">
                    </th>
                </tr>
            </thead>
            <tbody style="border-top: 5px solid #2094c6;">
                <tr>
                    <td colspan="6" style="padding: 20px 20px; border-top: 5px solid #2094c6; font-family:sans-serif; font-size: 16px;line-height: 1.5">
                        <?php echo $body_text; ?>
                    </td>
                </tr>
            </tbody>
            <tfoot style="background-color: #2094c6;">
                <tr>
                    <td colspan="4" style="color: #fff; font-family:sans-serif; padding: 15px 20px; font-size: 14px; line-height: 1.4">
                        &copy;2020. Switzerland Freelance Marketplace.<br> All Right Reserved.
                    </td>
                    <td colspan="2" style="text-align: right; color: #fff; padding: 15px 20px; font-family:sans-serif; font-size: 14px; line-height: 1.4">SFM<br>
                        <a style="color: #fff; font-family:sans-serif;" href="mailto:<?php echo $this->from_email ?>"><?php echo $this->from_email; ?></a>
                    </td>
                </tr>
            </tfoot>
        </table>
		<?php
		return ob_get_clean();
	}


	// Send email notification about new account
	public function user_register_email_cb( $role, $user_id, $user_email ) {
		$subject = __( 'New user sign up notification.', ET_DOMAIN );
		$message = $this->email_body_html('A new user just signed up as ' . $role . '. Please review the profile and take appropriate action. <a href="' . get_site_url() . '/wp-admin/user-edit.php?user_id=' . $user_id . '&wp_http_referer=%2Fwp-admin%2Fusers.php">View User</a>');
		wp_mail( $this->admin_emails, $subject, $message, $this->headers );

		wp_mail( $user_email, __( 'Welcome to SFM', ET_DOMAIN ), $this->email_body_html('Welcome to SFM, We are currently reviewing your account. We will let you know once your account is approved. Thank you.'), $this->headers );
	}

	// Send email to user after their account approval
	public function pending_user_approval_email_cb( $user_email ) {
		$subject = __( 'Account Approved.', ET_DOMAIN );
		$message = $this->email_body_html('Thanks for your patience, Your account has been approved by SFM. Please update your profile information after login and proceed');
		wp_mail( $user_email, $subject, $message, $this->headers );
	}

	// Send notification to admins about new posted project.
	public function post_project_notification_cb( $employer_id, $project_id ) {
		$employer_name = get_userdata( $employer_id )->display_name;
		$project       = get_post( $project_id );
		$subject       = __( 'New Project Notification' );
		$message       = $this->email_body_html("A new project (<a href='" . get_permalink( $project_id ) . "'>{$project->post_title})</a> is posted by {$employer_name}. Please take a look and take necessary action. Thank you.");
		wp_mail( $this->admin_emails, $subject, $message, $this->headers );
	}

	// Send email to employer if their project have a bid
	public function new_bid_notification_cb( $employer_email, $project ) {
		$subject = 'You have a new proposal on your project';
		$message = $this->email_body_html("Hi there, You have a new proposal on your following project: <a href='" . get_permalink( $project->ID ) . "'>" . $project->post_title . "</a>. Thank you.");
		wp_mail( $employer_email, $subject, $message, $this->headers );
	}

	// Send Email to admin and freelancer if a bid is accepted
	public function accept_proposal_notification_cb( $project, $employer, $company_name, $freelancer ) {
		$subject = __( 'New Project Started!', ET_DOMAIN );
		$message = $this->email_body_html("Hi there, The following project: <a href='" . get_permalink( $project->ID ) . "'>" . $project->post_title . "</a> is started. The project was created by {$employer->display_name} from {$company_name} and it has been assigned to {$freelancer->display_name}. Please contact with them. Thank you.");
		wp_mail( $this->admin_emails, $subject, $message, $this->headers );
		wp_mail( $freelancer->user_email, __( 'Proposal Accepted!', ET_DOMAIN ), $this->email_body_html("Congratulation! Your proposal on <a href='" . get_permalink( $project->ID ) . "'>" . $project->post_title . "</a> has been accepted. Keep up the good work. Thank you." ), $this->headers );
	}

}

new Email_Notification();