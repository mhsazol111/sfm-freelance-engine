<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

class Custom {

	/**
	 * Returns a pagination class with html
	 *
	 * @param $query
	 *
	 * @return false|string
	 */
	public static function pagination( $query ) {
		ob_start();
		?>
        <div class="sfm-pagination">
			<?php
			$big = 999999999; // need an unlikely integer
			echo paginate_links( array(
				'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
				'format'    => '/paged/%#%',
				'current'   => max( 1, $query->query['paged'] ),
				'total'     => $query->max_num_pages,
				'prev_text' => '<',
				'next_text' => '>',
				'type'      => 'list',
				'mid_size'  => 1,
				'end_size'  => 1
			) );
			?>
        </div>
		<?php
		return ob_get_clean();
	}


	/**
	 * Return All Taxonomy terms
	 *
	 * @param $taxonomy
	 * @param bool $hide_empty
	 *
	 * @return int|WP_Error|WP_Term[]
	 */
	public static function all_terms( $taxonomy, $hide_empty = false ) {
		$terms = get_terms( array(
			'taxonomy'   => $taxonomy,
			'hide_empty' => $hide_empty,
		) );

		return $terms;
	}


	/*
	 * Get Post Array from WP_Query
	 */
	public static function query_to_posts( $query ) {
		return $posts = $query->posts;
	}


	/*
	 * Count Total post from a WP_Query
	 */
	public static function query_to_post_count( $query ) {
		$count = 0;
		if ( $query ) {
			$count = count( $query->posts );
		}

		return $count;
	}


	/**
	 * Get meta range from a meta value
	 *
	 * @param $meta_key
	 *
	 * @return array
	 */
	public static function get_project_meta_range( $meta_key ) {
		$projects = new WP_Query( array(
			'post_type'      => PROJECT,
			'post_status'    => 'publish',
			'posts_per_page' => - 1
		) );

		$meta = [];
		foreach ( $projects->posts as $project ) {
			$project_meta = get_post_meta( $project->ID, $meta_key, true );
			$meta[]       = $project_meta;
		}

		return $meta_range = range( min( $meta ), max( $meta ), 1 );
	}


	/**
	 * Get all the admin emails
	 * @return array
	 */
	public static function get_admin_emails() {
		$admins = get_users( 'role=Administrator' );
		$emails = [];

		foreach ( $admins as $admin ) {
			$emails[] = $admin->data->user_email;
		}

		return $emails;
	}

}