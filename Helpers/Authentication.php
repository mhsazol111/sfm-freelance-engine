<?php

/**
 * Class Authentication
 * User Related Functions are created here.
 */
class Authentication {

	public function __construct() {

		add_action( 'show_user_profile', array( $this, 'show_user_profile_custom_fields' ) );
		add_action( 'edit_user_profile', array( $this, 'show_user_profile_custom_fields' ) );

		add_action( 'personal_options_update', array( $this, 'update_user_profile_custom_fields' ) );
		add_action( 'edit_user_profile_update', array( $this, 'update_user_profile_custom_fields' ) );

		add_action( 'wp_ajax_sfm_handle_custom_register', array( $this, 'handle_custom_register' ) );
		add_action( 'wp_ajax_nopriv_sfm_handle_custom_register', array( $this, 'handle_custom_register' ) );
	}


	/**
	 * @param $user
	 * Shows fields in the admin panel
	 */
	public function show_user_profile_custom_fields( $user ) {
		?>
        <h3>Additional Information</h3>
        <table class="form-table">
            <tr>
                <th><label for="phone_number">Phone Number</label></th>
                <td><input type="text" id="phone_number" class="regular-text code" name="phone_number"
                           value="<?= esc_attr( get_user_meta( $user->ID, 'phone_number', true ) ) ?>"></td>
            </tr>
			<?php if ( $user->roles[0] == 'employer' ) : ?>
                <tr>
                    <th><label for="company_name">Company Name</label></th>
                    <td><input type="text" id="company_name" class="regular-text code" name="company_name"
                               value="<?= esc_attr( get_user_meta( $user->ID, 'company_name', true ) ) ?>"></td>
                </tr>
			<?php endif; ?>
            <tr>
                <th><label for="job_title">Job Title</label></th>
                <td><input type="text" id="job_title" class="regular-text code" name="job_title"
                           value="<?= esc_attr( get_user_meta( $user->ID, 'job_title', true ) ) ?>"></td>
            </tr>
			<?php if ( $user->roles[0] == 'freelancer' ) : ?>
                <tr>
                    <th><label for="daily_wage_rate">Daily wage rate</label></th>
                    <td><input type="text" id="daily_wage_rate" class="regular-text code" name="daily_wage_rate"
                               value="<?= esc_attr( get_user_meta( $user->ID, 'daily_wage_rate', true ) ) ?>"></td>
                </tr>
			<?php endif; ?>
            <tr>
                <th><label for="describe_more">Describe more details about you</label></th>
                <td><textarea id="describe_more" class="regular-text code" name="describe_more" rows="7"
                              cols="50"><?= esc_attr( get_user_meta( $user->ID, 'describe_more', true ) ) ?></textarea>
                </td>
            </tr>
            <tr>
                <th><label for="facebook">Facebook</label></th>
                <td><input type="text" id="facebook" class="regular-text code" name="facebook"
                           value="<?= esc_attr( get_user_meta( $user->ID, 'facebook', true ) ) ?>"></td>
            </tr>
            <tr>
                <th><label for="twitter">Twitter</label></th>
                <td><input type="text" id="twitter" class="regular-text code" name="twitter"
                           value="<?= esc_attr( get_user_meta( $user->ID, 'twitter', true ) ) ?>"></td>
            </tr>
            <tr>
                <th><label for="linkedin">Linkedin</label></th>
                <td><input type="text" id="linkedin" class="regular-text code" name="linkedin"
                           value="<?= esc_attr( get_user_meta( $user->ID, 'linkedin', true ) ) ?>"></td>
            </tr>
            <tr>
                <th><label for="skype">Skype</label></th>
                <td><input type="text" id="skype" class="regular-text code" name="skype"
                           value="<?= esc_attr( get_user_meta( $user->ID, 'skype', true ) ) ?>"></td>
            </tr>
            <tr>
                <th><label for="city_name">City Name</label></th>
                <td><input type="text" id="city_name" class="regular-text code" name="city_name"
                           value="<?= esc_attr( get_user_meta( $user->ID, 'city_name', true ) ) ?>"></td>
            </tr>
            <tr>
                <th><label for="account_status">Account Status</label></th>
                <td>
                    <select name="account_status" id="account_status">
						<?php
						if ( get_user_meta( $user->ID, 'account_status', true ) == 'pending' ) {
							echo '<option value="pending" selected>Pending</option>';
							echo '<option value="active">Active</option>';
						} else {
							echo '<option value="pending">Pending</option>';
							echo '<option value="active" selected>Active</option>';
						}
						?>
                    </select>
                </td>
            </tr>
        </table>
		<?php
	}


	/**
	 * @param $user_id
	 *
	 * @return bool
	 * Update user's metadata from admin panel
	 */
	function update_user_profile_custom_fields( $user_id ) {
		// check that the current user have the capability to edit the $user_id
		if ( ! current_user_can( 'edit_user', $user_id ) ) {
			return false;
		}

		// create/update user meta for the $user_id
		$metas = array(
			'phone_number'    => sanitize_text_field( $_POST['phone_number'] ),
			'company_name'    => sanitize_text_field( $_POST['company_name'] ),
			'job_title'       => sanitize_text_field( $_POST['job_title'] ),
			'daily_wage_rate' => sanitize_text_field( $_POST['daily_wage_rate'] ),
			'describe_more'   => sanitize_text_field( $_POST['describe_more'] ),
			'facebook'        => sanitize_text_field( $_POST['facebook'] ),
			'twitter'         => sanitize_text_field( $_POST['twitter'] ),
			'linkedin'        => sanitize_text_field( $_POST['linkedin'] ),
			'skype'           => sanitize_text_field( $_POST['skype'] ),
			'city_name'       => sanitize_text_field( $_POST['city_name'] ),
			'account_status'  => sanitize_text_field( $_POST['account_status'] ),
		);

		foreach ( $metas as $key => $value ) {
			update_user_meta( $user_id, $key, $value );
		}
	}


	/**
	 * Register New Employer and Freelancer
	 */
	public function handle_custom_register() {
		header( 'Content-Type: application/json' );

		$form_data = $_POST;
		$errors    = [];
		$has_error = false;

		// Check required fields
//		if ( $form_data['first_name'] == '' ) {
//			$errors[]  = array( 'name' => 'first_name', 'message' => 'First Name is required!' );
//			$has_error = true;
//		}
//		if ( $form_data['last_name'] == '' ) {
//			$errors[]  = array( 'name' => 'last_name', 'message' => 'Last Name is required!' );
//			$has_error = true;
//		}
//		if ( $form_data['user_email'] == '' ) {
//			$errors[]  = array( 'name' => 'user_email', 'message' => 'Email Address is required!' );
//			$has_error = true;
//		}
//		if ( email_exists( $form_data['user_email'] ) ) {
//			$errors[]  = array( 'name' => 'user_email', 'message' => 'This email address is taken' );
//			$has_error = true;
//		}
//		if ( $form_data['user_login'] == '' ) {
//			$errors[]  = array( 'name' => 'user_login', 'message' => 'Username is required!' );
//			$has_error = true;
//		}
//		if ( username_exists( $form_data['user_login'] ) ) {
//			$errors[]  = array( 'name' => 'user_login', 'message' => 'This username is taken' );
//			$has_error = true;
//		}
//		if ( $form_data['user_pass'] == '' ) {
//			$errors[]  = array( 'name' => 'user_pass', 'message' => 'Password is required!' );
//			$has_error = true;
//		}
//		if ( $form_data['repeat_pass'] == '' ) {
//			$errors[]  = array( 'name' => 'repeat_pass', 'message' => 'Password Confirmation is required!' );
//			$has_error = true;
//		}
//		if ( $form_data['user_pass'] != $form_data['repeat_pass'] ) {
//			$errors[]  = array( 'name' => 'repeat_pass', 'message' => 'Password didn\'t match' );
//			$has_error = true;
//		}
//
//		if ( $has_error && $errors ) {
//			echo wp_json_encode( array( 'status' => false, 'errors' => $errors ) );
//			die();
//		}

		// Create User Account
//		$user_id = wp_insert_user( array(
//			'first_name' => sanitize_text_field( $form_data['first_name'] ),
//			'last_name'  => sanitize_text_field( $form_data['last_name'] ),
//			'user_email' => sanitize_text_field( $form_data['user_email'] ),
//			'user_login' => sanitize_text_field( $form_data['user_login'] ),
//			'user_pass'  => sanitize_text_field( $form_data['user_pass'] ),
//			'role'       => $_REQUEST['role'],
//		) );
//
//		// Set account status to pending
//		update_user_meta( $user_id, 'account_status', 'pending' );

		// Send email notification
        $user_id = 1;
		do_action( 'user_register_email', $_REQUEST['role'], $user_id, sanitize_text_field( $form_data['user_email'] ) );

		// Login with new user
//		wp_set_current_user( $user_id );
//		wp_set_auth_cookie( $user_id );

		echo wp_json_encode( [
			'status'   => true,
			'message'  => __( 'Registration Successful!', ET_DOMAIN ),
//			'redirect' => home_url() . '/dashboard'
		] );

		wp_die();
	}
}

new Authentication();