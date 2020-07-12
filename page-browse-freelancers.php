<?php
/**
 * Template Name: Page Browse Freelancers
 */


// Redirects an user back to their edit profile to update the profile first
if ( ! get_user_meta( get_current_user_id(), 'user_profile_id', true ) ) {
	wp_redirect( home_url() . '/edit-profile' );
}

$user_profile_id = get_user_meta( get_current_user_id(), 'user_profile_id', true );
if ( USER_ROLE == 'freelancer' ) {
	wp_redirect( home_url() . '/dashboard' );
}

get_header();

if ( get_query_var( 'paged' ) ) {
	$paged = get_query_var( 'paged' );
} elseif ( get_query_var( 'page' ) ) {
	$paged = get_query_var( 'page' );
} else {
	$paged = 1;
}

$term_ids = [];
$terms    = get_the_terms( $user_profile_id, 'project_category' );
foreach ( $terms as $term ) {
	$term_ids[] = $term->term_id;
}

$query_args = array(
	'post_type'      => PROFILE,
	'post_status'    => 'publish',
	'posts_per_page' => 10,
	'paged'          => $paged,
	'meta_query'     => array(
		array(
			'key'     => 'user_role',
			'value'   => 'freelancer',
			'compare' => '=',
		)
	),
	'tax_query'      => array(
		array(
			'taxonomy' => 'project_category',
			'field'    => 'term_id',
			'terms'    => $term_ids,
		),
	)
);

$loop = new WP_Query( $query_args );
?>

    <div class="fre-page-wrapper archive-freelancer-wrapper">
        <div class="profile_dashboard" id="<?php echo USER_ROLE; ?>-dashboard">

			<?php get_template_part( 'template-parts/sidebar', 'profile' ); // Dashboard Sidebar ?>

            <section id="dashboard_content">
                <div class="dashboard_inn" id="archive-freelancer-inner">
                    <div class="archive-freelancer-filter">
						<?php get_template_part( 'template-parts/components/browse-freelancer', 'filter' ); ?>
                    </div>

                    <div id="projects-wrapper" class="browse-freelancer-wrapper">
                        <div class="freelancers-wrapper-content">
							<?php
							if ( $loop->have_posts() ) :
								while ( $loop->have_posts() ) : $loop->the_post();
									include( locate_template( 'template-parts/components/browse-freelancer-item.php' ) );
								endwhile;
								echo Custom::pagination( $loop );
							else :
								echo _e( 'Nothing Found', ET_DOMAIN );
							endif;
							?>
                        </div>
                    </div>
                </div>
            </section>

        </div>
    </div>
<?php
get_footer();