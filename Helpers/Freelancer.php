<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly


class Freelancer {

	public function __construct() {
		add_action( 'wp_ajax_sfm_update_freelancer_profile', array( $this, 'update_freelancer_profile' ) );
		add_action( 'wp_ajax_nopriv_sfm_update_freelancer_profile', array( $this, 'update_freelancer_profile' ) );

		add_action( 'wp_ajax_sfm_browse_freelancer', array( $this, 'browse_freelancer' ) );
		add_action( 'wp_ajax_nopriv_sfm_browse_freelancer', array( $this, 'browse_freelancer' ) );
	}

	/**
	 * Return Specific Freelancer Projects on which he already bidden
	 *
	 * @param $freelancer_id
	 * @param array $project_status
	 * @param int $per_page
	 *
	 * @return WP_Query | bool
	 */
	public static function get_projects( $freelancer_id, $project_status = array(), $per_page = - 1 ) {
		/**
		 *  'accept' => Ongoing Projects
		 *  'publish' => Pending Projects
		 *  'unaccept' => Unaccepted Projects
		 *  'complete' => Completed Projects
		 *  'disputing' => Cancelled Projects
		 *  'disputed' => Resolved Projects
		 *  'draft' => Unpublished Projects
		 */

		$bids = new WP_Query( array(
			'post_type'      => 'bid',
			'post_status'    => $project_status,
			'author'         => $freelancer_id,
			'posts_per_page' => - 1,
		) );


		if ( $bids->posts ) {

			$project_ids = [];
			foreach ( $bids->posts as $bid ) {
				$project_ids[] = $bid->post_parent;
			}

			if ( get_query_var( 'paged' ) ) {
				$paged = get_query_var( 'paged' );
			} elseif ( get_query_var( 'page' ) ) {
				$paged = get_query_var( 'page' );
			} else {
				$paged = 1;
			}

			$projects = new WP_Query( array(
				'post_type'      => 'project',
				'post_status'    => 'any',
				'post__in'       => $project_ids,
				'orderby'        => 'post__in',
				'posts_per_page' => $per_page,
				'paged'          => $paged,
			) );

			return $projects;
		} else {
			return false;
		}
	}


	/**
	 * Return specific Freelancer info object
	 *
	 * @param $freelancer_id
	 *
	 * @return object
	 */
	public static function get_freelancer( $freelancer_id ) {
		$user_metas            = get_user_meta( $freelancer_id, '', true );
		$freelancer_profile_id = get_user_meta( $freelancer_id, 'user_profile_id', true );
		$freelancer_profile    = get_post( $freelancer_profile_id );
		$freelancer_meta       = get_post_meta( $freelancer_profile_id, '', true );

		// Returns All user_meta;
		$u_metas = [];
		foreach ( $user_metas as $key => $meta ) {
			$u_metas[ $key ] = $meta[0];
		}

		$metas = [];
		if ( $freelancer_profile_id ) {
			foreach ( $freelancer_meta as $key => $meta ) {
				$metas[ $key ] = $meta[0];
			}
		}

		$details = array(
			'name'         => get_user_meta( $freelancer_id, 'first_name', true ) . ' ' . get_user_meta( $freelancer_id, 'last_name', true ),
			'display_name' => get_userdata( $freelancer_id )->display_name,
			'slug'         => $freelancer_profile->guid,
			'email'        => get_userdata( $freelancer_id )->user_email,
			'user_metas'   => $u_metas,
			'profile_post' => $metas,
		);

		return $freelancer = (object) array_flatten( $details );
	}


	/**
	 * Return freelancer bids array
	 *
	 * @param $freelancer_id
	 * @param array|null $project_id
	 * @param int $total
	 *
	 * @return WP_Query
	 */
	public static function get_bids( $freelancer_id, array $project_id = null, $total = - 1 ) {
		$bids = new WP_Query( array(
			'post_type'       => 'bid',
			'posts_per_page'  => $total,
			'author'          => $freelancer_id,
			'post_parent__in' => $project_id != '' ? $project_id : '',
		) );

		return $bids;
	}


	/**
	 * Returns a single bid info object
	 *
	 * @param $bid_id
	 *
	 * @return object
	 */
	public static function get_bid( $bid_id ) {
		$bid_post = get_post( $bid_id );
		$bid_meta = get_post_meta( $bid_id );

		$metas = [];

		foreach ( $bid_meta as $key => $meta ) {
			$metas[ $key ] = $meta[0];
		}

		$bid = array(
			'post_type'     => $bid_post->post_type,
			'freelancer_id' => $bid_post->post_author,
			'project_id'    => $bid_post->post_parent,
			'title'         => $bid_post->post_title,
			'content'       => $bid_post->post_content,
			'slug'          => $bid_post->post_name,
			'post_date'     => $bid_post->post_date,
			'metas'         => $metas,
		);

		return (object) array_flatten( $bid );
	}


	public function update_freelancer_profile() {
		header( 'Content-Type: application/json' );

		$form_data     = $_POST;
		$freelancer_id = get_current_user_id();
		$errors        = [];
		$has_error     = false;

		// Check wp_nonce field
		$nonce = $form_data['edit_profile_nonce'];
		if ( $nonce == '' || ! wp_verify_nonce( $nonce, 'edit_profile' ) ) {
			$errors[]  = array( 'name' => 'edit_profile_nonce', 'message' => 'Sorry, your nonce did not verify.' );
			$has_error = true;
		}

		// Check required fields
		if ( $form_data['daily_wage_rate'] == '' ) {
			$errors[]  = array( 'name' => 'daily_wage_rate', 'message' => 'Daily Wage is required!' );
			$has_error = true;
		}
		if ( $form_data['language'] == '' ) {
			$errors[]  = array( 'name' => 'language[]', 'message' => 'Please select at least a language!' );
			$has_error = true;
		}
		if ( $form_data['project_category'] == '' ) {
			$errors[]  = array( 'name' => 'project_category[]', 'message' => 'Please select a category!' );
			$has_error = true;
		}
		if ( $form_data['project_skills'] == '' ) {
			$errors[]  = array( 'name' => 'project_skills[]', 'message' => 'Please select a skill!' );
			$has_error = true;
		}
		if ( $form_data['first_name'] == '' ) {
			$errors[]  = array( 'name' => 'first_name', 'message' => 'First Name is required!' );
			$has_error = true;
		}
		if ( $form_data['last_name'] == '' ) {
			$errors[]  = array( 'name' => 'last_name', 'message' => 'Last Name is required!' );
			$has_error = true;
		}
		if ( $form_data['phone_number'] == '' ) {
			$errors[]  = array( 'name' => 'phone_number', 'message' => 'Phone Number is required!' );
			$has_error = true;
		}
		if ( $form_data['describe_more'] == '' ) {
			$errors[]  = array( 'name' => 'describe_more', 'message' => 'Description field is required!' );
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

			$post_id = get_user_meta( $freelancer_id, 'et_avatar' );

			if ( $post_id ) {
				wp_delete_attachment( $post_id, true );
				wp_delete_post( $post_id, true );
			}

			update_user_meta( $freelancer_id, 'et_avatar', $attachment_id );
			update_user_meta( $freelancer_id, 'et_avatar_url', wp_get_attachment_url( $attachment_id ) );
		}

		// Create a post with the same name, if exists update it
		$profile_post = new WP_Query( array(
			'post_type' => PROFILE,
			'author'    => $freelancer_id,
		) );

		if ( ! count( $profile_post->posts ) > 0 ) {
			$new_profile_post = wp_insert_post( array(
				'post_author'  => $freelancer_id,
				'post_content' => $form_data['describe_more'],
				'post_title'   => $form_data['first_name'] . ' ' . $form_data['last_name'],
				'post_status'  => 'publish',
				'post_type'    => PROFILE,
			) );

			update_user_meta( $freelancer_id, 'user_profile_id', $new_profile_post );
			update_user_meta( $freelancer_id, 'user_available', 'on' );
		} else {
			$user_profile_post = get_user_meta( $freelancer_id, 'user_profile_id', true );
			$up_args           = array(
				'ID'           => $user_profile_post,
				'post_title'   => sanitize_text_field( $form_data['first_name'] ) . ' ' . sanitize_text_field( $form_data['last_name'] ),
				'post_content' => sanitize_text_field( $form_data['describe_more'] ),
			);

			wp_update_post( $up_args );
		}

		// Set the language, skill, category, country taxonomy with the profile id
		$user_profile_post = get_user_meta( $freelancer_id, 'user_profile_id', true );
		wp_set_post_terms( $user_profile_post, $form_data['language'], 'language' );
		wp_set_post_terms( $user_profile_post, $form_data['project_category'], 'project_category' );
		wp_set_post_terms( $user_profile_post, $form_data['project_skills'], 'skill' );
		wp_set_post_terms( $user_profile_post, $form_data['country_you_live'], 'country' );

		// Remove old country term id from user meta
		delete_user_meta( $freelancer_id, 'user_country_id' );
		delete_user_meta( $freelancer_id, 'user_category' );

		// Update Professional Job title
		update_post_meta( $user_profile_post, 'et_professional_title', sanitize_text_field( $form_data['job_title'] ) );
		update_post_meta( $user_profile_post, 'user_role', USER_ROLE );

		// Update User Metas
		$metas = array(
			'daily_wage_rate' => sanitize_text_field( $form_data['daily_wage_rate'] ),
			'first_name'      => sanitize_text_field( $form_data['first_name'] ),
			'last_name'       => sanitize_text_field( $form_data['last_name'] ),
			'phone_number'    => sanitize_text_field( $form_data['phone_number'] ),
			'company_name'    => sanitize_text_field( $form_data['company_name'] ),
			'job_title'       => sanitize_text_field( $form_data['job_title'] ),
			'describe_more'   => sanitize_text_field( $form_data['describe_more'] ),
			'facebook'        => sanitize_text_field( $form_data['facebook'] ),
			'twitter'         => sanitize_text_field( $form_data['twitter'] ),
			'linkedin'        => sanitize_text_field( $form_data['linkedin'] ),
			'skype'           => sanitize_text_field( $form_data['skype'] ),
			'city_name'       => sanitize_text_field( $form_data['city_name'] ),
		);

		wp_update_user( array(
			'ID'           => $freelancer_id,
			'display_name' => sanitize_text_field( $form_data['display_name'] )
		) );

		foreach ( $metas as $key => $value ) {
			update_user_meta( $freelancer_id, $key, $value );
		}

		echo wp_json_encode( [
			'status'   => true,
			'message'  => __( 'Profile Successfully Updated!', ET_DOMAIN ),
			'redirect' => home_url() . '/dashboard'
		] );
		die();
	}


	// Freelancer Ajax Filter Function
	public function browse_freelancer() {
		$form_data = $_POST;

		$user_profile_id = get_user_meta( get_current_user_id(), 'user_profile_id', true );
		$term_ids        = [];
		$terms           = get_the_terms( $user_profile_id, 'project_category' );
		foreach ( $terms as $term ) {
			$term_ids[] = $term->term_id;
		}

		if ( isset( $form_data['freelancer-category'] ) && $form_data['freelancer-category'] != '' ) {
			$term_ids = $form_data['freelancer-category'];
		}

		$query_args = array(
			'post_type'      => PROFILE,
			'post_status'    => 'publish',
			'posts_per_page' => 10,
			'paged'          => $form_data['page'],
			'meta_query'     => array(
				array(
					'key'     => 'user_role',
					'value'   => 'freelancer',
					'compare' => '=',
				)
			),
			'tax_query'      => array(
				'relation' => 'AND',
				array(
					'taxonomy' => 'project_category',
					'field'    => 'term_id',
					'terms'    => $term_ids,
				),
			)
		);

		if ( isset( $form_data['freelancer-search'] ) && $form_data['freelancer-search'] != '' ) {
			$query_args['s'] = $form_data['freelancer-search'];
		}
		if ( isset( $form_data['freelancer-skill'] ) && $form_data['freelancer-skill'] != '' ) {
			$query_args['tax_query'][] = array(
				'taxonomy' => 'skill',
				'field'    => 'term_id',
				'terms'    => $form_data['freelancer-skill'],
			);
		}
		if ( isset( $form_data['freelancer-language'] ) && $form_data['freelancer-language'] != '' ) {
			$query_args['tax_query'][] = array(
				'taxonomy' => 'language',
				'field'    => 'term_id',
				'terms'    => $form_data['freelancer-language'],
			);
		}
		if ( isset( $form_data['freelancer-country'] ) && $form_data['freelancer-country'] != '' ) {
			$query_args['tax_query'][] = array(
				'taxonomy' => 'country',
				'field'    => 'term_id',
				'terms'    => $form_data['freelancer-country'],
			);
		}

		$loop = new WP_Query( $query_args );

		ob_start(); ?>


        <div class="freelancers-wrapper-content">
			<?php
			if ( $loop->have_posts() ) :
				while ( $loop->have_posts() ) : $loop->the_post();
					include( locate_template( 'template-parts/components/browse-freelancer-item.php' ) );
				endwhile;
				echo Custom::pagination( $loop );
			else :
				echo "Nothing Found";
			endif;
			?>
        </div>

		<?php
		echo ob_get_clean();
		die();
	}

}

new Freelancer();