<?php


if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly
class Project {
	public function __construct() {
		add_action( 'wp_ajax_sfm_browse_all_projects', array( $this, 'browse_all_projects' ) );
		add_action( 'wp_ajax_nopriv_sfm_browse_all_projects', array( $this, 'browse_all_projects' ) );

		add_action( 'wp_ajax_sfm_get_employer_own_projects', array( $this, 'get_employer_own_projects' ) );
		add_action( 'wp_ajax_nopriv_sfm_get_employer_own_projects', array( $this, 'get_employer_own_projects' ) );

		add_action( 'wp_ajax_sfm_get_freelancer_own_projects', array( $this, 'get_freelancer_own_projects' ) );
		add_action( 'wp_ajax_nopriv_sfm_get_freelancer_own_projects', array( $this, 'get_freelancer_own_projects' ) );

		add_action( 'wp_ajax_sfm_project_post_and_update', array( $this, 'project_post_and_update' ) );
		add_action( 'wp_ajax_nopriv_sfm_project_post_and_update', array( $this, 'project_post_and_update' ) );

		add_action( 'wp_ajax_sfm_project_action', array( $this, 'project_action' ) );
		add_action( 'wp_ajax_nopriv_sfm_project_action', array( $this, 'project_action' ) );
	}


	/**
	 * Browse All Project Ajax
	 */
	public function browse_all_projects() {
		$form_data = $_POST;

		$user_profile_id = get_user_meta( get_current_user_id(), 'user_profile_id', true );
		$cat_ids         = [];
		$categories      = get_the_terms( $user_profile_id, 'project_category' );
		foreach ( $categories as $cat ) {
			$cat_ids[] = $cat->term_id;
		}

		$args = array(
			'post_type'      => PROJECT,
			'post_status'    => 'publish',
			'posts_per_page' => 10,
			'paged'          => $form_data['page'],
			'tax_query'      => array(
				'relation' => 'AND',
				array(
					'taxonomy' => 'project_category',
					'field'    => $form_data['project-category'] != '' ? 'slug' : 'term_id',
					'terms'    => $form_data['project-category'] != '' ? $form_data['project-category'] : $cat_ids,
				),
			),
		);

		if ( $form_data['project-search'] != '' ) {
			$args['s'] = $form_data['project-search'];
		}

		if ( $form_data['project-skill'] != '' ) {
			$args['tax_query'][] = array(
				'taxonomy' => 'skill',
				'field'    => 'slug',
				'terms'    => $form_data['project-skill'],
			);
		}

		if ( $form_data['project-country'] != '' ) {
			$args['tax_query'][] = array(
				'taxonomy' => 'country',
				'field'    => 'slug',
				'terms'    => $form_data['project-country'],
			);
		}

		if ( $form_data['project-bid'] != '' ) {
			$args['meta_query'] = array(
				'relation' => 'AND',
				array(
					'key'     => 'total_bids',
					'value'   => $form_data['project-bid'],
					'compare' => '='
				)
			);
		}

		if ( $form_data['project-min-budget'] != '' && $form_data['project-max-budget'] != '' ) {
			$args['meta_query'][] = array(
				'key'     => 'et_budget',
				'value'   => array( $form_data['project-min-budget'], $form_data['project-max-budget'] ),
				'type'    => 'numeric',
				'compare' => 'BETWEEN',
			);
		}

		$query = new WP_Query( $args );
		ob_start();
		?>

        <div class="projects-wrapper-content">
			<?php
			if ( $query->have_posts() ) :
				while ( $query->have_posts() ) : $query->the_post();
					include( locate_template( 'template-parts/components/browse-project-item.php' ) );
				endwhile;
				echo Custom::pagination( $query );
			else :
				get_template_part( 'template-parts/components/project', 'empty' );
			endif;
			?>
        </div>

		<?php
		echo ob_get_clean();

		die();
	}


	/**
	 * Employer's Own Project Ajax Callback
	 */
	public function get_employer_own_projects() {
		$form_data = $_POST;

		$args = array(
			'post_type'      => 'project',
			'post_status'    => $form_data['project-status'] != '' ? $form_data['project-status'] : 'any',
			'author'         => $form_data['currentUserId'],
			'posts_per_page' => 10,
			'paged'          => $form_data['page'],
		);

		if ( $form_data['project-search'] != '' ) {
			$args['s'] = $form_data['project-search'];
		}

		$query = new WP_Query( $args );

		ob_start();
		?>
        <div class="projects-wrapper-content">
			<?php
			if ( $query->posts ) {
				foreach ( $query->posts as $project ) {
					include( locate_template( 'template-parts/components/employer-project-item.php' ) );
				}
				echo Custom::pagination( $query );
			} else {
				get_template_part( 'template-parts/components/project', 'empty' );
			}
			?>
        </div>

		<?php
		echo ob_get_clean();

		die();
	}


	/**
	 * Freelancer's Own Project Ajax Callback
	 */
	public function get_freelancer_own_projects() {
		$form_data = $_POST;

		$bids = new WP_Query( array(
			'post_type'      => 'bid',
			'post_status'    => $form_data['project-status'] != '' ? $form_data['project-status'] : 'any',
			'author'         => $form_data['currentUserId'],
			'posts_per_page' => - 1,
		) );

		if ( $bids->posts ) {
			$project_ids = [];
			foreach ( $bids->posts as $bid ) {
				$project_ids[] = $bid->post_parent;
			}

			$args = array(
				'post_type'      => 'project',
				'post_status'    => 'any',
				'post__in'       => $project_ids,
				'orderby'        => 'post__in',
				'posts_per_page' => 10,
				'paged'          => $form_data['page'],
			);

			if ( $form_data['project-search'] != '' ) {
				$args['s'] = $form_data['project-search'];
			}

			$query = new WP_Query( $args );

			ob_start();
			?>
            <div class="projects-wrapper-content">
				<?php
				if ( $query->posts ) {
					foreach ( $query->posts as $project ) {
						include( locate_template( 'template-parts/components/freelancer-project-item.php' ) );
					}
					echo Custom::pagination( $query );
				} else {
					get_template_part( 'template-parts/components/project', 'empty' );
				}
				?>
            </div>

			<?php
			echo ob_get_clean();
		} else {
			get_template_part( 'template-parts/components/project', 'empty' );
		}
		die();
	}


	/**
	 * Project post and update ajax callback
	 */
	public function project_post_and_update() {
		header( 'Content-Type: application/json' );

		$form_data   = $_POST;
		$employer_id = get_current_user_id();
		$errors      = [];
		$has_error   = false;

		// Check required fields
		if ( $form_data['project_category'] == '' ) {
			$errors[]  = array( 'name' => 'project_category', 'message' => 'This field is required!' );
			$has_error = true;
		}
		if ( $form_data['post_title'] == '' ) {
			$errors[]  = array( 'name' => 'post_title', 'message' => 'This field is required!' );
			$has_error = true;
		}
		if ( $form_data['post_content'] == '' ) {
			$errors[]  = array( 'name' => 'post_content', 'message' => 'This field is required!' );
			$has_error = true;
		}
		if ( $form_data['et_budget'] == '' ) {
			$errors[]  = array( 'name' => 'et_budget', 'message' => 'This field is required!' );
			$has_error = true;
		}
		if ( $form_data['project_deadline'] == '' ) {
			$errors[]  = array( 'name' => 'project_deadline', 'message' => 'This field is required!' );
			$has_error = true;
		}

		// Show Errors on frontend
		if ( $has_error && $errors ) {
			echo wp_json_encode( array( 'status' => false, 'errors' => $errors ) );
			die();
		}

		// Create Project and attach taxonomies to the project
		$status = 'draft';
		if ( $form_data['project_id'] != '' ) {
			$project = get_post( $form_data['project_id'] );
			$status  = $project->post_status;
		}

		$project_id = wp_insert_post( array(
			'ID'           => ( isset( $form_data['project_id'] ) && $form_data['project_id'] != '' ) ? $form_data['project_id'] : 0,
			'post_type'    => PROJECT,
			'post_author'  => $employer_id,
			'post_title'   => sanitize_text_field( $form_data['post_title'] ),
			'post_content' => sanitize_textarea_field( $form_data['post_content'] ),
			'post_status'  => $status,
			'meta_input'   => array(
				'et_budget'        => sanitize_text_field( $form_data['et_budget'] ),
				'project_deadline' => sanitize_text_field( $form_data['project_deadline'] ),
				'total_bids'       => 0,
			)
		) );

		wp_set_post_terms( $project_id, $form_data['project_category'], 'project_category' );
		wp_set_post_terms( $project_id, $form_data['skill'], 'skill' );
		wp_set_post_terms( $project_id, $form_data['country'], 'country' );

		// Update Images
		if ( $form_data['project_images'] != '' ) {
			$image_ids = explode( ',', $form_data['project_images'] );
			foreach ( $image_ids as $attachment ) {
				wp_update_post( array(
					'ID'          => $attachment,
					'post_parent' => $project_id,
				) );
			}
		}

		// Send Admin notification about new project
		$admin_email = get_option( 'admin_email' );
		$subject     = get_field( 'user_sign_up_admin_notification', 'option' )['subject'];
		$message     = get_field( 'user_sign_up_admin_notification', 'option' )['message'];
		$headers     = array(
			"Content-Type: text/html",
			"charset=UTF-8",
			"From: SFM <email@sfm.com>"
		);
		wp_mail( $admin_email, $subject, $message, $headers );

		echo wp_json_encode( array(
			'status'   => true,
			'message'  => __( 'Project Successfully Updated!', ET_DOMAIN ),
			'redirect' => home_url() . '/my-project'
		) );
		die();
	}


	public function project_action() {
		header( 'Content-Type: application/json' );

		$form_data   = $_POST;
		$employer_id = get_current_user_id();
		$errors      = [];
		$has_error   = false;

		// Check required fields
		if ( $form_data['project_id'] == '' ) {
			$errors[]  = array( 'name' => 'project_id', 'message' => 'Project id is required' );
			$has_error = true;
		}
		if ( $form_data['project_id'] != '' ) {
			$project = get_post( $form_data['project_id'] );
			if ( $project->post_author != $employer_id ) {
				$errors[]  = array( 'name' => 'project_id', 'message' => 'You are not the author of this project' );
				$has_error = true;
			}
		}

		// Show Errors on frontend
		if ( $has_error && $errors ) {
			echo wp_json_encode( array( 'status' => false, 'errors' => $errors ) );
			die();
		}

		// Delete a project
		if ( $form_data['project_action'] == 'delete' ) {
			wp_delete_post( $form_data['project_id'] );
			echo wp_json_encode( array(
				'status'   => true,
				'message'  => __( 'Project Successfully Deleted!', ET_DOMAIN ),
				'redirect' => home_url() . '/my-project'
			) );
			die();
		}

		// Archive a project
		if ( $form_data['project_action'] == 'archive' ) {
			wp_update_post( array(
				'ID'          => $form_data['project_id'],
				'post_status' => 'archive'
			) );
			echo wp_json_encode( array(
				'status'   => true,
				'message'  => __( 'Project Successfully Archived!', ET_DOMAIN ),
				'redirect' => home_url() . '/my-project'
			) );
			die();
		}

		die();

	}


}

new Project();