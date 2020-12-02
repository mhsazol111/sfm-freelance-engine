<?php

class User_Notification extends Email_Notification {
	public function __construct() {
		parent::__construct();

		add_action( 'wp_ajax_handle_notification_settings', array( $this, 'notification_settings' ) );
		add_action( 'wp_ajax_nopriv_handle_notification_settings', array( $this, 'notification_settings' ) );

		add_action( 'init', array( $this, 'sfm_register_sent_notification_table' ) );
		add_filter( 'cron_schedules', array( $this, 'sfm_custom_cron_job_recurrence' ) );
	}

	public function notification_settings() {
		header( 'Content-Type: application/json' );

		$formData              = $_REQUEST;
		$errors                = [];
		$has_error             = false;
		$notification_settings = [];
		$user_id               = get_current_user_id();

		if ( isset( $formData['notification-toggle'] ) && $formData['notification-toggle'] == 'on' ) {
			$notification_settings['status'] = true;
		} else {
			$notification_settings['status'] = false;
		}

		if ( isset( $formData['notification-frequency'] ) && $formData['notification-frequency'] != '' ) {
			$notification_settings['frequency'] = $formData['notification-frequency'];
		} else {
			$errors[]  = array(
				'name'    => 'notification-frequency',
				'message' => 'You must select a frequency!'
			);
			$has_error = true;
		}

		if ( isset( $formData['quantity'] ) && $formData['quantity'] != '' ) {
			$notification_settings['quantity'] = $formData['quantity'];
		} else {
			$errors[]  = array(
				'name'    => 'quantity',
				'message' => 'You must select a quantity!'
			);
			$has_error = true;
		}


		if ( USER_ROLE == 'freelancer' ) {
			if ( isset( $formData['project-cat-ids'] ) && $formData['project-cat-ids'] != '' ) {
				$notification_settings['project_cat_ids'] = $formData['project-cat-ids'];
			} else {
				$errors[]  = array(
					'name'    => 'project-cat-ids[]',
					'message' => 'You must select a category!'
				);
				$has_error = true;
			}
		} else {
			if ( isset( $formData['freelancer-cat-ids'] ) && $formData['freelancer-cat-ids'] != '' ) {
				foreach ( $formData['freelancer-cat-ids'] as $cat_id ) {
					$notification_settings['freelancer_cat_ids'][ $cat_id ] = [];
				}
//				$notification_settings['freelancer_cat_ids'] = $formData['freelancer-cat-ids'];
			} else {
				$errors[]  = array(
					'name'    => 'freelancer-cat-ids[]',
					'message' => 'You must select a category!'
				);
				$has_error = true;
			}
		}

		if ( USER_ROLE != 'freelancer' ) {
			if ( isset( $formData['freelancer-skill-switch'] ) && $formData['freelancer-skill-switch'] != '' ) {
				$notification_settings['freelancer_skill_switch'] = $formData['freelancer-skill-switch'];
			}

			if ( isset( $formData['freelancer-skill-ids'] ) && $formData['freelancer-skill-ids'] != '' ) {
				foreach ( $formData['freelancer-skill-ids'] as $key => $id ) {
					if ( array_key_exists( $key, $notification_settings['freelancer_cat_ids'] ) ) {
						$notification_settings['freelancer_cat_ids'][ $key ] = $id;
					} else {
						$notification_settings['freelancer_cat_ids'];
					}
				}
//				$notification_settings['freelancer_skill_ids'] = $formData['freelancer-skill-ids'];
			}
		}

//		pri_dump( $notification_settings );
//		wp_die();

		if ( $has_error && $errors ) {
			echo wp_json_encode( array( 'success' => false, 'errors' => $errors ) );
			wp_die();
		}

		update_user_meta( $user_id, 'notification_settings', serialize( $notification_settings ) );

		echo wp_json_encode( [
			'success' => true,
			'message' => __( 'Notification settings successfully updated!', ET_DOMAIN ),
		] );

		wp_die();
	}

	public function sfm_register_sent_notification_table() {
		$args = array(
			'label'     => __( 'Sent Notifications', ET_DOMAIN ),
			'public'    => true,
//			'publicly_queryable' => false,
//			'show_ui'            => false,
//			'show_in_menu'       => false,
//			'query_var'          => true,
//			'capability_type'    => 'post',
//			'has_archive'        => false,
//			'hierarchical'       => false,
			'rewrite'   => array( 'slug' => 'sent_notification' ),
			'menu_icon' => 'dashicons-book',
		);

		register_post_type( 'sent_notification', $args );
	}

	public function sfm_custom_cron_job_recurrence( $schedules ) {
		if ( ! isset( $schedules['fortnightly'] ) ) {
			$schedules['fortnightly'] = array(
				'display'  => __( 'Fortnightly', ET_DOMAIN ),
				'interval' => 15 * 24 * 60 * 60,
			);
		}

		if ( ! isset( $schedules['once_monthly'] ) ) {
			$schedules['once_monthly'] = array(
				'display'  => __( 'Once a month', ET_DOMAIN ),
				'interval' => 30 * 24 * 60 * 60,
			);
		}

		return $schedules;
	}

}