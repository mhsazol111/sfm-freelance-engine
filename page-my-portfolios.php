<?php

/**
 * Template Name: My Portfolios
 */

// Redirects an user back to their edit profile to update the profile first
if ( ! get_user_meta( get_current_user_id(), 'user_profile_id', true ) ) {
	wp_redirect( home_url() . '/edit-profile' );
}

global $user_ID;

get_header();
//convert current user
$ae_users = AE_Users::get_instance();
$user_data = $ae_users->convert( $current_user->data );
$user_role = ae_user_role( $current_user->ID );
//convert current profile
$post_object = $ae_post_factory->get( PROFILE );
$profile_id = get_user_meta( $user_ID, 'user_profile_id', true );
$profile = array();
if ( $profile_id ) {
	$profile_post = get_post( $profile_id );
	if ( $profile_post && ! is_wp_error( $profile_post ) ) {
		$profile = $post_object->convert( $profile_post );
	}
}
$display_name = $user_data->display_name;
$job_title = isset( $profile->et_professional_title ) ? $profile->et_professional_title : '';

$role_template = 'employer';
if ( fre_share_role() || ae_user_role( $user_ID ) == FREELANCER ) {
    $role_template = 'freelance';
}

?>
<div class="fre-page-wrapper post-project-wrapper">
<div class="profile_dashboard" id="<?php echo $role_template; ?>-dashboard">
    <?php include( locate_template( 'template-parts/sidebar-profile.php' ) ); // Dashboard Sidebar ?>
    <section id="dashboard_content">
        <div class="dashboard_inn">

            <div class="fre-page-section list-profile-wrapper sfm-my-portfolios-wrapper">
            <?php
				global $wp_query, $ae_post_factory, $post;
				$wp_query->query = array_merge(  $wp_query->query ,array('posts_per_page' => 6)) ;
				$post_object = $ae_post_factory->get( 'portfolio' );
				$is_edit = false;
				if(is_author()){
					$author_id        = get_query_var( 'author' );
				}else{
					$author_id        = get_current_user_id();
					$is_edit = true;
				}

				$query_args =  array(
					// 'post_parent' => $convert->ID,
					'posts_per_page' => 6,
					'post_status' => 'publish',
					'post_type' => PORTFOLIO,
					'author' => $author_id,
					'is_edit' =>$is_edit
				);

				query_posts($query_args);
				if(have_posts() or $is_edit) {
					?>
					<div class="fre-profile-boxx">
						<div class="portfolio-container">
							<div class="profile-freelance-portfolio">
								<div class="my-portfolio-bar">
									<div class="m-p-left">
										<h2 class="freelance-portfolio-title"><?php _e('My Portfolios',ET_DOMAIN) ?></h2>
									</div>
									<?php if($is_edit){ ?>
										<div class="m-p-right">
											<div class="freelance-portfolio-add">
												<a href="#"  class="fre-normal-btn-o portfolio-add-btn add-portfolio"><?php _e('Add new',ET_DOMAIN);?></a>
											</div>
										</div>
									<?php } ?>
								</div>

								<?php if(!have_posts() and $is_edit){ ?>
									<p class="fre-empty-optional-profile"><?php _e('Add portfolio to your profile. (optional)',ET_DOMAIN) ?></p>
								<?php }else { ?>
									<ul class="freelance-portfolio-list row fpp-portfolio-wrap">
										<?php
										$postdata = array();
										while ( have_posts() ) {
											the_post();
											$convert    = $post_object->convert( $post, 'thumbnail' );
											$postdata[] = $convert;
											get_template_part( 'template/portfolio', 'item' ); 
										}
										?>
									</ul>
								<?php } ?>
								<?php
								if ( ! empty( $postdata ) && $wp_query->max_num_pages > 1 ) {
									/**
									 * render post data for js
									 */
									echo '<script type="data/json" class="postdata portfolios-data" >' . json_encode( $postdata ) . '</script>';
									echo '<div class="freelance-portfolio-loadmore">';
									ae_pagination( $wp_query, get_query_var( 'paged' ), 'load_more','View more' );
									echo '</div>';
								}
								?>
							</div>
						</div>
					</div>
				<?php }  ?>
            </div>

        </div>
    </section>

</div>
</div>

<?php

get_footer();