<?php

/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme and one
 * of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query,
 * e.g., it puts together the home page when no home.php file exists.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage FreelanceEngine
 * @since FreelanceEngine 1.0
 */

// Redirects an user back to their edit profile to update the profile first
if ( ! get_user_meta( get_current_user_id(), 'user_profile_id', true ) ) {
	wp_redirect( home_url() . '/edit-profile' );
}

$user_profile_id = get_user_meta( get_current_user_id(), 'user_profile_id', true );

if ( ( USER_ROLE == 'employer' ) ) {
	wp_redirect( home_url() . '/dashboard' );
}

$current_skill    = ( isset( $_GET['skill_project'] ) && $_GET['skill_project'] != '' ) ? $_GET['skill_project'] : '';
$current_category = ( isset( $_GET['category_project'] ) && $_GET['category_project'] != '' ) ? $_GET['category_project'] : '';

$cat_ids    = [];
$categories = get_the_terms( $user_profile_id, 'project_category' );
foreach ( $categories as $cat ) {
	$cat_ids[] = $cat->term_id;
}

$query_args = array(
	'post_type'      => PROJECT,
	'post_status'    => 'publish',
	'posts_per_page' => 10,
	'paged'          => 1,
);

//if ( ! current_user_can( 'administrator' ) ) {
$query_args['tax_query'] = array(
	'relation' => 'AND',
	array(
		'taxonomy' => 'project_category',
		'field'    => isset( $_GET['category_project'] ) && $_GET['category_project'] ? 'slug' : 'term_id',
		'terms'    => isset( $_GET['category_project'] ) && $_GET['category_project'] ? $_GET['category_project'] : $cat_ids,
	),
);
//}

if ( isset( $_GET['skill_project'] ) && $_GET['skill_project'] != '' ) {
	$query_args['tax_query'][] = array(
		'taxonomy' => 'skill',
		'field'    => 'slug',
		'terms'    => $_GET['skill_project'],
	);
}

$loop = new WP_Query( $query_args );

get_header();

?>

    <div class="fre-page-wrapper">
        <div class="my_projects profile_dashboard sfm-browse-projects-archive-page"
             id="<?php echo USER_ROLE; ?>-projects">

			<?php get_template_part( 'template-parts/sidebar', 'profile' ); ?>

            <section id="dashboard_content">
                <div class="dashboard_inn">

                    <div class="dashboard_title">
                        <h2><?php _e( 'Browse Projects', ET_DOMAIN ) ?></h2>
                        <hr>
                    </div>

					<?php include( locate_template( 'template-parts/components/browse-project-filter.php' ) ); ?>

                    <div id="projects-wrapper" class="browse-project-wrapper">

                        <div class="projects-wrapper-content">
							<?php
							if ( $loop->have_posts() ) :
								while ( $loop->have_posts() ) : $loop->the_post();
									get_template_part( 'template-parts/components/browse-project', 'item' );
								endwhile;
								echo Custom::pagination( $loop );
							else :
								get_template_part( 'template-parts/components/project', 'empty' );
							endif;
							?>
                        </div>

                    </div>

                </div><!-- End .dashbord_inn -->

            </section><!-- End #dashbord_content -->

        </div>
    </div>

<?php

get_footer();