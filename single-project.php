<?php
/**
 * The Template for displaying all single posts
 *
 * @package WordPress
 * @subpackage FreelanceEngine
 * @since FreelanceEngine 1.0
 */

// Redirects an user back to their edit profile to update the profile first
if ( ! get_user_meta( get_current_user_id(), 'user_profile_id', true ) ) {
	wp_redirect( home_url() . '/edit-profile' );
}

get_header();
global $wp_query, $ae_post_factory, $post, $user_ID;
$post_object = $ae_post_factory->get( PROJECT );
$convert     = $post_object->convert( $post );


$role_template = 'employer';
if ( fre_share_role() || ae_user_role( $user_ID ) == FREELANCER ) {
	$role_template = 'freelance';
}

if ( have_posts() ) : the_post(); ?>

    <div class="fre-page-wrapper single-project-wrapper">
        <div class="profile_dashboard" id="<?php echo USER_ROLE ?>-dashboard">

			<?php get_template_part( 'template-parts/sidebar', 'profile' ); // Dashboard Sidebar ?>

            <section id="dashboard_content">
                <div class="dashboard_inn">
					<?php

					if ( isset( $_REQUEST['dispute'] ) && $_REQUEST['dispute'] ) {
						get_template_part( 'template/project', 'report' );
					} else {
						get_template_part( 'template-parts/single-project', 'info' );
						get_template_part( 'template-parts/single-project', 'content' );
					}
					?>
				</div>
				
				<?php if ( USER_ROLE == 'freelancer' ) : 

					// Check freelancer already bid on the project
					$children = get_children( array(
						'post_parent' => get_queried_object_id(),
						'post_type'   => 'bid'
					) );

					if ( ! empty( $children ) ) {
						$author_ids = [];
						foreach ( $children as $child ) {
							$author_ids[] = $child->post_author;
						}
						//pri_dump($child);
						if ( in_array( get_current_user_id(), $author_ids ) ) : ?>
							<div class="dashboard_inn single-projects-bid-wrap">
								<?php get_template_part( 'template-parts/single-project', 'bidding' ); ?>
							</div>
						<?php endif;
					}

				endif; ?>
                
				<?php if ( $user_ID == get_queried_object()->post_author ) : ?>
                    <div class="dashboard_inn single-projects-bid-wrap">
						<?php get_template_part( 'template-parts/single-project', 'bidding' ); ?>
                    </div>
				<?php endif; ?>

				<?php echo '<script type="data/json" id="project_data">' . json_encode( $convert ) . '</script>'; ?>

            </section>
        </div>
    </div>

<?php
endif;
get_footer();