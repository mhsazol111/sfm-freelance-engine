<?php


class Email_Notification {

	private $admin_emails;
	public $headers;
	private $from_email;

	public function __construct() {
		$this->from_email = get_field( 'from_email', 'option' );
		$emails           = get_field( 'admin_emails', 'option' );
		$emails_array     = [];
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

		add_filter( 'ae_get_mail_header', array( $this, 'change_sfm_default_email_header' ) );
		add_filter( 'ae_get_mail_footer', array( $this, 'change_sfm_default_email_footer' ) );

		add_action( 'user_register_email', array( $this, 'user_register_email_cb' ), 10, 3 );
		add_action( 'pending_user_approval_email', array( $this, 'pending_user_approval_email_cb' ), 10, 1 );
		add_action( 'new_bid_notification', array( $this, 'new_bid_notification_cb' ), 10, 2 );
		add_action( 'accept_proposal_notification', array( $this, 'accept_proposal_notification_cb' ), 10, 4 );
		add_action( 'declined_proposal_notification', array( $this, 'declined_proposal_notification_cb' ), 10, 2 );
		add_action( 'post_project_notification', array( $this, 'post_project_notification_cb' ), 10, 2 );
	}


	public function change_sfm_default_email_header() {
		return '<table width="100%" border="0" cellpadding="5" cellspacing="0" style="border: 2px solid #2094c6; max-width: 600px; margin: auto;">
            <thead>
                <tr>
                    <th colspan="6" style="padding: 15px 20px;text-align: center">
                        <img style="max-width: 120px; width: 120px;" src="' . esc_url( get_stylesheet_directory_uri() . '/inc/images/SFM-Logo.png' ) . '" alt="SFM">
                    </th>
                </tr>
            </thead>
            <tbody style="border-top: 5px solid #2094c6;">
                <tr>
                    <td colspan="6" style="padding: 20px 20px; border-top: 5px solid #2094c6; font-family:sans-serif; font-size: 16px;line-height: 1.5">';
	}

	public function change_sfm_default_email_footer() {
		$footer_text = get_field( 'email_footer_text', 'option' );

		return '</td>
                </tr>
            </tbody>
            <tfoot style="background-color: #2094c6;">
                <tr>
                    <td colspan="4" style="color: #fff; font-family:sans-serif; padding: 15px 20px; font-size: 14px; line-height: 1.4">' . $footer_text . '</td>
                    <td colspan="2" style="text-align: right; color: #fff; padding: 15px 20px; font-family:sans-serif; font-size: 14px; line-height: 1.4">SFM<br>
                        <a style="color: #fff; font-family:sans-serif;" href="mailto:' . get_field( 'from_email', 'option' ) . '">' . get_field( 'from_email', 'option' ) . '</a>
                    </td>
                </tr>
            </tfoot>
        </table>';
	}

	public function email_body_html( $body_text ) {
		$footer_text = get_field( 'email_footer_text', 'option' );
		ob_start();
		?>
        <table width="100%" border="0" cellpadding="5" cellspacing="0"
               style="border: 2px solid #2094c6; max-width: 600px; margin: auto;">
            <thead>
            <tr>
                <th colspan="6" style="padding: 15px 20px;text-align: center">
                    <img style="max-width: 120px; width: 120px;"
                         src="<?php echo esc_url( get_stylesheet_directory_uri() . '/inc/images/SFM-Logo.png' ) ?>"
                         alt="SFM">
                </th>
            </tr>
            </thead>
            <tbody style="border-top: 5px solid #2094c6;">
            <tr>
                <td colspan="6"
                    style="padding: 20px 20px; border-top: 5px solid #2094c6; font-family:sans-serif; font-size: 16px;line-height: 1.5">
					<?php echo $body_text; ?>
                </td>
            </tr>
            </tbody>
            <tfoot style="background-color: #2094c6;">
            <tr>
                <td colspan="4"
                    style="color: #fff; font-family:sans-serif; padding: 15px 20px; font-size: 14px; line-height: 1.4"><?php echo $footer_text ?></td>
                <td colspan="2"
                    style="text-align: right; color: #fff; padding: 15px 20px; font-family:sans-serif; font-size: 14px; line-height: 1.4">
                    SFM<br>
                    <a style="color: #fff; font-family:sans-serif;"
                       href="mailto:<?php echo $this->from_email ?>"><?php echo $this->from_email; ?></a>
                </td>
            </tr>
            </tfoot>
        </table>
		<?php
		return ob_get_clean();
	}


	// Send email notification about new account
	public function user_register_email_cb( $role, $user_id, $user_email ) {
		$admin_email_fields = get_field( 'en_new_user_sign_up_notification_to_admins', 'option' );
		$user_email_fields  = get_field( 'en_welcome_email_to_new_user', 'option' );
		if ( get_locale() == 'fr_FR' ) {
			$admin_email_fields = get_field( 'fr_new_user_sign_up_notification_to_admins', 'option' );
			$user_email_fields  = get_field( 'fr_welcome_email_to_new_user', 'option' );
		}

		// Admin Email
		$new_user_data      = get_userdata( $user_id );
		$admin_subject      = $admin_email_fields['subject'];
		$admin_email_body   = $admin_email_fields['email_body'];
		$admin_replaces     = array(
			'{{first_name}}',
			'{{last_name}}',
			'{{email}}',
			'{{registered_as}}',
			'{{pending_user_link}}',
			'{{user_id}}',
		);
		$admin_replace_with = array(
			$new_user_data->first_name,
			$new_user_data->last_name,
			$user_email,
			$role,
			esc_url( get_site_url() . '/wp-admin/user-edit.php?user_id=' . $user_id . '&wp_http_referer=%2Fwp-admin%2Fusers.php' ),
			$user_id,
		);
		$admin_email_body   = str_replace( $admin_replaces, $admin_replace_with, $admin_email_body );
		wp_mail( $this->admin_emails, $admin_subject, $this->email_body_html( $admin_email_body ), $this->headers );

		// Freelancer Email
		$user_subject      = $user_email_fields['subject'];
		$user_email_body   = $user_email_fields['email_body'];
		$user_replaces     = array(
			'{{first_name}}',
			'{{last_name}}',
			'{{email}}',
			'{{registered_as}}',

		);
		$user_replace_with = array(
			$new_user_data->first_name,
			$new_user_data->last_name,
			$user_email,
			$role,
		);
		$user_email_body   = str_replace( $user_replaces, $user_replace_with, $user_email_body );
		wp_mail( $user_email, $user_subject, $this->email_body_html( $user_email_body ), $this->headers );
	}

	// Send email to user after their account approval
	public function pending_user_approval_email_cb( $user_id ) {
		$user_email_fields = get_field( 'en_account_approved_notification_to_user', 'option' );
		if ( get_locale() == 'fr_FR' ) {
			$user_email_fields = get_field( 'fr_account_approved_notification_to_user', 'option' );
		}

		$new_user_data     = get_userdata( $user_id );
		$user_subject      = $user_email_fields['subject'];
		$user_email_body   = $user_email_fields['email_body'];
		$user_replaces     = array(
			'{{first_name}}',
			'{{last_name}}',
			'{{email}}',
		);
		$user_replace_with = array(
			$new_user_data->first_name,
			$new_user_data->last_name,
			$new_user_data->user_email,
		);
		$user_email_body   = str_replace( $user_replaces, $user_replace_with, $user_email_body );
		wp_mail( $new_user_data->user_email, $user_subject, $this->email_body_html( $user_email_body ), $this->headers );
	}

	// Send notification to admins about new posted project.
	public function post_project_notification_cb( $employer_id, $project_id ) {
		$admin_email_fields = get_field( 'en_new_project_notification_to_admins', 'option' );
		if ( get_locale() == 'fr_FR' ) {
			$admin_email_fields = get_field( 'fr_new_project_notification_to_admins', 'option' );
		}

		$employer = Employer::get_employer( $employer_id );

		$admin_subject      = $admin_email_fields['subject'];
		$admin_email_body   = $admin_email_fields['email_body'];
		$admin_replaces     = array(
			'{{project_title}}',
			'{{project_url}}',
			'{{employer_name}}',
			'{{company_name}}',
			'{{employer_email}}',
		);
		$admin_replace_with = array(
			get_the_title( $project_id ),
			get_permalink( $project_id ),
			$employer->display_name,
			$employer->company_name,
			get_userdata( $employer_id )->user_email,
		);
		$admin_email_body   = str_replace( $admin_replaces, $admin_replace_with, $admin_email_body );
		wp_mail( $this->admin_emails, $admin_subject, $this->email_body_html( $admin_email_body ), $this->headers );
	}

	// Send email to employer if their project have a bid
	public function new_bid_notification_cb( $employer_id, $project ) {
		$user_email_fields = get_field( 'en_new_proposal_notification_to_employer', 'option' );
		if ( get_locale() == 'fr_FR' ) {
			$user_email_fields = get_field( 'fr_new_proposal_notification_to_employer', 'option' );
		}

		$user_subject      = $user_email_fields['subject'];
		$user_email_body   = $user_email_fields['email_body'];
		$user_replaces     = array(
			'{{project_title}}',
			'{{project_url}}',
			'{{employer_name}}',
		);
		$user_replace_with = array(
			$project->post_title,
			get_permalink( $project->ID ),
			get_userdata( $employer_id )->display_name,
		);

		$user_email_body = str_replace( $user_replaces, $user_replace_with, $user_email_body );
		wp_mail( get_userdata( $employer_id )->user_email, $user_subject, $this->email_body_html( $user_email_body ), $this->headers );
	}

	// Send Email to admin and freelancer if a bid is accepted
	public function accept_proposal_notification_cb( $project, $employer_id, $company_name, $freelancer_id ) {
		$admin_email_fields = get_field( 'en_new_project_started_notification_to_admins', 'option' );
		$user_email_fields  = get_field( 'en_proposal_accepted_notification_to_freelancer', 'option' );
		if ( get_locale() == 'fr_FR' ) {
			$admin_email_fields = get_field( 'fr_new_project_started_notification_to_admins', 'option' );
			$user_email_fields  = get_field( 'fr_proposal_accepted_notification_to_freelancer', 'option' );
		}

		// Admin Email
		$admin_subject      = $admin_email_fields['subject'];
		$admin_email_body   = $admin_email_fields['email_body'];
		$admin_replaces     = array(
			'{{project_title}}',
			'{{project_url}}',
			'{{employer_name}}',
			'{{company_name}}',
			'{{freelancer_name}}',
		);
		$admin_replace_with = array(
			$project->post_title,
			get_permalink( $project->ID ),
			get_userdata( $employer_id )->display_name,
			$company_name,
			get_userdata( $freelancer_id )->display_name,
		);
		$admin_email_body   = str_replace( $admin_replaces, $admin_replace_with, $admin_email_body );
		wp_mail( $this->admin_emails, $admin_subject, $this->email_body_html( $admin_email_body ), $this->headers );

		// Freelancer Email
		$user_subject      = $user_email_fields['subject'];
		$user_email_body   = $user_email_fields['email_body'];
		$user_replaces     = array(
			'{{freelancer_name}}',
			'{{project_title}}',
			'{{project_url}}',
		);
		$user_replace_with = array(
			get_userdata( $freelancer_id )->display_name,
			$project->post_title,
			get_permalink( $project->ID ),
		);
		$user_email_body   = str_replace( $user_replaces, $user_replace_with, $user_email_body );
		wp_mail( get_userdata( $freelancer_id )->user_email, $user_subject, $this->email_body_html( $user_email_body ), $this->headers );
	}

	// Send Email to admin and freelancer if a bid is accepted
	public function declined_proposal_notification_cb( $project, $freelancer ) {
		$user_email_fields  = get_field( 'en_proposal_declined_notification_to_freelancer', 'option' );
		if ( get_locale() == 'fr_FR' ) {
			$user_email_fields  = get_field( 'fr_proposal_declined_notification_to_freelancer', 'option' );
		}

		$user_subject      = $user_email_fields['subject'];
		$user_email_body   = $user_email_fields['email_body'];
		$user_replaces     = array(
			'{{freelancer_name}}',
			'{{project_title}}',
			'{{project_url}}',
		);
		$user_replace_with = array(
			$freelancer->display_name,
			$project->post_title,
			get_permalink( $project->ID ),
		);
		$user_email_body   = str_replace( $user_replaces, $user_replace_with, $user_email_body );
		wp_mail( $freelancer->user_email, $user_subject, $this->email_body_html( $user_email_body ), $this->headers );
	}

}

new Email_Notification();