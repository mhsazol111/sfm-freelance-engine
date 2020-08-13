<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

class Employer {

	public function __construct() {
		add_action( 'wp_ajax_sfm_update_employer_profile', array( $this, 'update_employer_profile' ) );
		add_action( 'wp_ajax_nopriv_sfm_update_employer_profile', array( $this, 'update_employer_profile' ) );
	}

	/**
	 * Return Specific Employers Projects as an array
	 *
	 * @param $employer_id
	 * @param array $project_status
	 * @param int $per_page
	 *
	 * @return WP_Query
	 */
	public static function get_projects( $employer_id, $project_status = array(), $per_page = - 1 ) {
		/**
		 * 'close' => Ongoing Projects
		 * 'complete' => Completed Projects
		 * 'publish' => Published Projects
		 * 'archive' => Achieve Projects
		 * 'disputing' => Cancelled Projects
		 * 'draft' => Pending Projects
		 */

		if ( get_query_var( 'paged' ) ) {
			$paged = get_query_var( 'paged' );
		} elseif ( get_query_var( 'page' ) ) {
			$paged = get_query_var( 'page' );
		} else {
			$paged = 1;
		}

		$project = new WP_Query( array(
			'post_type'      => 'project',
			'post_status'    => $project_status,
			'author'         => $employer_id,
			'posts_per_page' => $per_page,
			'paged'          => $paged
		) );

		return $project;
	}


	/***
	 * Returns a single project details object
	 *
	 * @param $project_id
	 *
	 * @return object | bool
	 */
	public static function get_project( $project_id ) {
		$project_post = get_post( $project_id );
		$project_meta = get_post_meta( $project_id );

		if ( get_post_type( $project_id ) != PROJECT ) {
			return false;
		}

		$metas = [];

		if ( '' != $project_meta ) {
			foreach ( $project_meta as $key => $meta ) {
				$metas[ $key ] = $meta[0];
			}
		}

		$project = array(
			'id'          => $project_id,
			'employer_id' => $project_post->post_author,
			'title'       => $project_post->post_title,
			'content'     => $project_post->post_content,
			'url'         => get_permalink( $project_post->ID ),
			'post_date'   => $project_post->post_date,
			'status'      => $project_post->post_status,
			'metas'       => $metas,
		);

		return (object) array_flatten( $project );
	}


	/**
	 * Get all the bids from a specific employer's project and returns as an array.
	 *
	 * @param $employer_id
	 * @param array $project_id
	 * @param int $total
	 *
	 * @return WP_Query | false
	 */
	public static function get_project_bids( $employer_id, array $project_id = null, $total = - 1 ) {
		// Getting all projects created by this user and pass the ids to get all the bids from all the projects
		$projects = get_posts( array( 'post_type' => 'project', 'author' => $employer_id ) );

		// Exit if employer never posted a project
		if ( empty( $projects ) ) {
			return false;
		}

		$project_ids = [];
		foreach ( $projects as $project ) {
			$project_ids[] = $project->ID;
		}

		$bids = new WP_Query( array(
			'post_type'       => 'bid',
			'posts_per_page'  => $total,
			'post_parent__in' => $project_id != '' ? $project_id : $project_ids,
		) );

		return $bids;
	}


	/**
	 * Returns specific employers details object
	 *
	 * @param $employer_id
	 *
	 * @return object
	 */
	public static function get_employer( $employer_id ) {
		$user_metas          = get_user_meta( $employer_id, '', true );
		$employer_profile_id = get_user_meta( $employer_id, 'user_profile_id', true );
		$employer_profile    = get_post( $employer_profile_id );
		$employer_meta       = get_post_meta( $employer_profile_id, '', true );

		// Returns All user_meta;
		$u_metas = [];
		foreach ( $user_metas as $key => $meta ) {
			$u_metas[ $key ] = $meta[0];
		}

		$metas = [];
		if ( $employer_profile_id ) {
			foreach ( $employer_meta as $key => $meta ) {
				$metas[ $key ] = $meta[0];
			}
		}

		$details = array(
			'id'           => $employer_id,
			'name'         => get_user_meta( $employer_id, 'first_name', true ) . ' ' . get_user_meta( $employer_id, 'last_name', true ),
			'display_name' => get_userdata( $employer_id )->display_name,
			'slug'         => $employer_profile->guid,
			'user_metas'   => $u_metas,
			'profile_post' => $metas,
		);

		return $employer = (object) array_flatten( $details );
	}


	/**
	 * @param $project_id
	 *
	 * @param string $term_name
	 * @param bool $link
	 * @param string $wrapper_tag
	 * @param bool $comma
	 *
	 * @return string
	 */
	public static function get_project_terms( $project_id, $term_name = 'project_category', $link = true, $wrapper_tag = '', $comma = false ) {
		ob_start();

		$terms = get_the_terms( $project_id, $term_name );

		$url_param = 'category_project';
		if ( 'skill' == $term_name ) {
			$url_param = 'skill_project';
		}

		if ( $terms ) {
			foreach ( $terms as $i => $term ) {

				$comma_string = '';
				if ( $comma == true ) {
					if ( $i < count( (array) $terms ) - 1 ) {
						$comma_string = ", ";
					}
				}

				$cat = '<a href="' . get_post_type_archive_link( 'project' ) . '?' . $url_param . '=' . $term->slug . '">' . $term->name . $comma_string . '</a>';
				if ( $link == false ) {
					$cat = $term->name . $comma_string;
				}

				if ( '' != $wrapper_tag ) {
					$cat = '<' . $wrapper_tag . '>' . $cat . '</' . $wrapper_tag . '>';
				}

				echo $cat;

			}
		} else {
			if ( 'skill' == $term_name ) {
				echo 'No Skill Found!';
			} else {
				echo 'No Categories Found!';
			}
		}

		return ob_get_clean();
	}


	/**
	 * Update Employer Profile
	 */
	public function update_employer_profile() {
		header( 'Content-Type: application/json' );

		$form_data   = $_POST;
		$employer_id = get_current_user_id();
		$errors      = [];
		$has_error   = false;

		// Check wp_nonce field
		$nonce = $form_data['edit_profile_nonce'];
		if ( $nonce == '' || ! wp_verify_nonce( $nonce, 'edit_profile' ) ) {
			$errors[]  = array( 'name' => 'edit_profile_nonce', 'message' => 'Sorry, your nonce did not verify.' );
			$has_error = true;
		}

		// Check required fields
		if ( $form_data['first_name'] == '' ) {
			$errors[]  = array( 'name' => 'first_name', 'message' => 'First Name is required!' );
			$has_error = true;
		}
		if ( $form_data['last_name'] == '' ) {
			$errors[]  = array( 'name' => 'last_name', 'message' => 'Last Name is required!' );
			$has_error = true;
		}
		if ( $form_data['display_name'] == '' ) {
			$errors[]  = array( 'name' => 'display_name', 'message' => 'Display Name is required!' );
			$has_error = true;
		}
		if ( $form_data['phone_number'] == '' ) {
			$errors[]  = array( 'name' => 'phone_number', 'message' => 'Phone Number is required!' );
			$has_error = true;
		}
		if ( $form_data['company_name'] == '' ) {
			$errors[]  = array( 'name' => 'company_name', 'message' => 'Company Name is required!' );
			$has_error = true;
		}
		if ( $form_data['job_title'] == '' ) {
			$errors[]  = array( 'name' => 'job_title', 'message' => 'Job Title is required!' );
			$has_error = true;
		}
		if ( $form_data['project_category'] == '' ) {
			$errors[]  = array( 'name' => 'project_category[]', 'message' => 'Please select at least a category!' );
			$has_error = true;
		}
		if ( $form_data['country_you_live'] == '' ) {
			$errors[]  = array( 'name' => 'country_you_live', 'message' => 'Please select a country!' );
			$has_error = true;
		}
		if ( $form_data['city_name'] == '' ) {
			$errors[]  = array( 'name' => 'city_name', 'message' => 'City Name is required!' );
			$has_error = true;
		}
		if ( $has_error && $errors ) {
			echo wp_json_encode( array( 'status' => false, 'errors' => $errors ) );
			die();
		}

		// Upload Profile Image
		if ( isset( $_FILES['profile_image'] ) && $_FILES['profile_image']['name'] != '' ) {
			// These files need to be included as dependencies when on the front end.
			require_once ABSPATH . 'wp-admin/includes/image.php';
			require_once ABSPATH . 'wp-admin/includes/file.php';
			require_once ABSPATH . 'wp-admin/includes/media.php';

			// Remember, 'my_image_upload' is the name of our file input in our form above.
			$attachment_id = media_handle_upload( 'profile_image', 0 );
			if ( is_wp_error( $attachment_id ) ) {
				$errors[] = array( 'name' => 'profile_image', 'message' => 'Error uploading image' );
				echo wp_json_encode( array( 'status' => false, 'errors' => $errors ) );
				die();
			}

			$post_id = get_user_meta( $employer_id, 'et_avatar' );

			if ( $post_id ) {
				wp_delete_attachment( $post_id, true );
				wp_delete_post( $post_id, true );
			}

			update_user_meta( $employer_id, 'et_avatar', $attachment_id );
			update_user_meta( $employer_id, 'et_avatar_url', wp_get_attachment_url( $attachment_id ) );
		}

		// Create a post with the same name, if exists update it
		$profile_post = new WP_Query( array(
			'post_type' => PROFILE,
			'author'    => $employer_id,
		) );

		if ( ! count( $profile_post->posts ) > 0 ) {
			$new_profile_post = wp_insert_post( array(
				'post_author'  => $employer_id,
				'post_content' => $form_data['describe_more'],
				'post_title'   => $form_data['first_name'] . ' ' . $form_data['last_name'],
				'post_status'  => 'publish',
				'post_type'    => PROFILE,
			) );

			update_user_meta( $employer_id, 'user_profile_id', $new_profile_post );
//			update_user_meta( $employer_id, 'user_available', 'on' );
		} else {
			$user_profile_post = get_user_meta( $employer_id, 'user_profile_id', true );
			$up_args           = array(
				'ID'           => $user_profile_post,
				'post_title'   => sanitize_text_field( $form_data['first_name'] ) . ' ' . sanitize_text_field( $form_data['last_name'] ),
				'post_content' => sanitize_text_field( $form_data['describe_more'] ),
			);

			wp_update_post( $up_args );
		}

		// Set the country taxonomy with the profile id
		$user_profile_post = get_user_meta( $employer_id, 'user_profile_id', true );
		wp_set_post_terms( $user_profile_post, $form_data['project_category'], 'project_category' );
		wp_set_post_terms( $user_profile_post, $form_data['country_you_live'], 'country' );

		// Remove old country term id from user meta
		delete_user_meta( $employer_id, 'user_country_id' );
		delete_user_meta( $employer_id, 'user_category' );

		// Update Professional Job title
		update_post_meta( $user_profile_post, 'et_professional_title', sanitize_text_field( $form_data['job_title'] ) );
		update_post_meta( $user_profile_post, 'user_role', USER_ROLE );

		// Update User Metas
		$metas = array(
			'first_name'    => sanitize_text_field( $form_data['first_name'] ),
			'last_name'     => sanitize_text_field( $form_data['last_name'] ),
			'phone_number'  => sanitize_text_field( $form_data['phone_number'] ),
			'company_name'  => sanitize_text_field( $form_data['company_name'] ),
			'job_title'     => sanitize_text_field( $form_data['job_title'] ),
			'describe_more' => sanitize_text_field( $form_data['describe_more'] ),
			'facebook'      => sanitize_text_field( $form_data['facebook'] ),
			'twitter'       => sanitize_text_field( $form_data['twitter'] ),
			'linkedin'      => sanitize_text_field( $form_data['linkedin'] ),
			'skype'         => sanitize_text_field( $form_data['skype'] ),
			'city_name'     => sanitize_text_field( $form_data['city_name'] ),
		);

		wp_update_user( array(
			'ID'           => $employer_id,
			'display_name' => sanitize_text_field( $form_data['display_name'] )
		) );

		foreach ( $metas as $key => $value ) {
			update_user_meta( $employer_id, $key, $value );
		}

		echo wp_json_encode( [
			'status'   => true,
			'message'  => __( 'Profile Successfully Updated!', ET_DOMAIN ),
			'redirect' => home_url() . '/dashboard'
		] );
		die();
	}


	public static function get_messages( $employer_id ) {
		global $wpdb;

		$query = $wpdb->get_results(
			$wpdb->prepare( "SELECT * FROM {$wpdb->prefix}la_private_messages WHERE author_id=%s", $employer_id )
		);

		pri_dump( $query );

	}

}

new Employer();