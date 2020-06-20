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

if ( get_post_meta( $user_profile_id, 'user_role', true ) != 'freelancer' ) {
	wp_redirect( home_url() . '/dashboard' );
}

$current_skill    = '';
$current_category = '';

$cat_ids    = [];
$categories = get_the_terms( $user_profile_id, 'project_category' );
foreach ( $categories as $cat ) {
	$cat_ids[] = $cat->term_id;
}


//if ( get_query_var( 'paged' ) ) {
//	$paged = get_query_var( 'paged' );
//} elseif ( get_query_var( 'page' ) ) {
//	$paged = get_query_var( 'page' );
//} else {
//	$paged = 1;
//}

$query_args = array(
	'post_type'      => PROJECT,
	'post_status'    => 'publish',
	'posts_per_page' => 10,
	'paged'          => 1,
	'tax_query'      => array(
		'relation' => 'AND',
		array(
			'taxonomy' => 'project_category',
			'field'    => isset( $_GET['category_project'] ) && $_GET['category_project'] ? 'slug' : 'term_id',
			'terms'    => isset( $_GET['category_project'] ) && $_GET['category_project'] ? $_GET['category_project'] : $cat_ids,
		),
	),
);

if ( isset( $_GET['skill_project'] ) && $_GET['skill_project'] != '' ) {
	$current_skill = $_GET['skill_project'];

	$query_args['tax_query'][] = array(
		'taxonomy' => 'skill',
		'field'    => 'slug',
		'terms'    => $_GET['skill_project'],
	);
}

//if ( isset( $_GET['category_project'] ) && $_GET['category_project'] != '' ) {
//	$current_category = $_GET['category_project'];
//
//	$query_args['tax_query'][] = array(
//		'taxonomy' => 'project_category',
//		'field'    => 'slug',
//		'terms'    => $_GET['category_project'],
//	);
//}

$loop = new WP_Query( $query_args );

get_header();

?>

    <div class="fre-page-wrapper">
        <div class="my_projects profile_dashboard sfm-browse-projects-archive-page"
             id="<?php echo USER_ROLE; ?>-projects">

			<?php include( locate_template( 'template-parts/sidebar-profile.php' ) ); // Dashboard Sidebar ?>

            <section id="dashboard_content">
                <div class="dashboard_inn">

                    <div class="dashboard_title">
                        <h2>Browse Projects</h2>
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


    <!-- <div class="fre-page-title">

        <div class="container">

            <h2><?php //_e( 'Available Projects', ET_DOMAIN ); ?></h2>

        </div>

    </div> -->

    <!-- <div class="fre-page-section section-archive-project">

        <div class="container">

            <div class="page-project-list-wrap">

                <div class="fre-project-list-wrap">

					<?php //get_template_part( 'template/filter', 'projects' ); ?>

                    <div class="fre-project-list-box">

                        <div class="fre-project-list-wrap">

                            <div class="fre-project-result-sort">

                                <div class="row">

									<?php

	//$query_post = $loop->found_posts;

	//$found_posts = '<span class="found_post">' . $query_post . '</span>';

	//$plural = sprintf( __( '%s projects found', ET_DOMAIN ), $found_posts );

	//$singular = sprintf( __( '%s project found', ET_DOMAIN ), $found_posts );

	//$not_found = sprintf( __( 'There are no projects posted on this site!', ET_DOMAIN ), $found_posts );

	?>

                                    <div class="col-sm-4 col-sm-push-8">

										<?php //if ( $query_post >= 1 ) { ?>

                                            <div class="fre-project-sort">

                                                <select class="fre-chosen-single sort-order" id="project_orderby"

                                                        name="orderby">

                                                    <option value="date"><?php //_e( 'Latest Projects', ET_DOMAIN ); ?></option>

                                                    <option value="et_budget"><?php //_e( 'Highest Budget', ET_DOMAIN ); ?></option>

                                                </select>

                                            </div>

										<?php //} ?>

                                    </div>

                                    <div class="col-sm-8 col-sm-pull-4">

                                        <div class="fre-project-result">

                                            <p>

                                                    <span class="plural <?php //if ( $query_post == 1 ) {

	// echo 'hide';

	// } ?>"><?php //if ( $query_post < 1 ) {

	////echo $not_found;

	// } else {

	//echo $plural;

	//} ?></span>

                                                <span class="singular <?php //if ( $query_post > 1 || $query_post < 1 ) {

	//echo 'hide';

	//} ?>"><?php //echo $singular; ?></span>

                                            </p>

                                        </div>

                                    </div>

                                </div>

                            </div>

							<?php //get_template_part( 'list', 'projects' ); ?>

                        </div>

                    </div>

					<?php

	//$loop->query = array_merge( $loop->query, array( 'is_archive_project' => is_post_type_archive( PROJECT ) ) );

	//echo '<div class="fre-paginations paginations-wrapper">';

	//ae_pagination( $loop, get_query_var( 'paged' ) );

	//echo '</div>';

	?>

                </div>

            </div>

        </div>

    </div> -->

<?php

get_footer();