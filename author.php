<?php
/**
 * The Template for displaying a user profile
 *
 * @package WordPress
 * @subpackage FreelanceEngine
 * @since FreelanceEngine 1.0
 */

global $wp_query, $ae_post_factory, $post, $user_ID;
if ( ! get_user_meta( get_current_user_id(), 'user_profile_id', true ) ) {
	wp_redirect( home_url() . '/edit-profile' );
}
$post_object      = $ae_post_factory->get( PROFILE );
$author_id        = get_query_var( 'author' );
$author_name      = get_the_author_meta( 'display_name', $author_id );
$author_available = get_user_meta( $author_id, 'user_available', true );
// get user profile id
$profile_id = get_user_meta( $author_id, 'user_profile_id', true );

/*if($author_id == get_current_user_id()){
    wp_redirect(et_get_page_link( "profile" ));
}*/



$convert = '';
if ( $profile_id ) {
	// get post profile
	$profile = get_post( $profile_id );
	if ( $profile && ! is_wp_error( $profile ) ) {
		$convert = $post_object->convert( $profile );
	}
}

// try to check and add profile up current user dont have profile
if ( ! $convert && ( fre_share_role() || ae_user_role( $author_id ) == FREELANCER ) ) {
	$profile_post = get_posts( array( 'post_type' => PROFILE, 'author' => $author_id ) );
	if ( ! empty( $profile_post ) ) {
		$profile_post = $profile_post[0];
		$convert      = $post_object->convert( $profile_post );
		$profile_id   = $convert->ID;
		update_user_meta( $author_id, 'user_profile_id', $profile_id );
	} else {
		$convert = $post_object->insert( array(
				'post_status'  => 'publish',
				'post_author'  => $author_id,
				'post_title'   => $author_name,
				'post_content' => ''
			)
		);

		$convert    = $post_object->convert( get_post( $convert->ID ) );
		$profile_id = $convert->ID;
	}
}
//  count author review number
$count_review = fre_count_reviews( $author_id );


get_header();

$next_post = false;
if ( $convert ) {
	$next_post = ae_get_adjacent_post( $convert->ID, false, '', true, 'skill' );
}



$rating          = Fre_Review::employer_rating_score( $author_id );
$class_name = 'employer';
if ( fre_share_role() || ae_user_role( $author_id ) == FREELANCER ) {
	$rating          = Fre_Review::freelancer_rating_score( $author_id );
	$class_name = 'freelance';
}

$projects_worked = get_post_meta( $profile_id, 'total_projects_worked', true );
$project_posted = fre_count_user_posts_by_type( $author_id, 'project', '"publish","complete","close","disputing","disputed" ', true );
$hire_freelancer = fre_count_hire_freelancer( $user_ID );

$user      = get_userdata( $author_id );
$ae_users  = AE_Users::get_instance();
$user_data = $ae_users->convert( $user );
$hour_rate = 0;

if( isset($convert->hour_rate) )
	$hour_rate = (int) $convert->hour_rate;
?>

<?php 
  $author_employer = Employer::get_employer($author_id);
  $author_freelancer = Freelancer::get_freelancer($author_id);
  // echo "<pre>";
  // print_r($author_freelancer); 
  // echo "<pre>";
?>
    <div class="fre-page-wrapper list-profile-wrapper">
      <div class="profile_dashboard">
        <?php get_template_part( 'template-parts/sidebar', 'profile' ); // Dashboard Sidebar ?>

        <section id="dashboard_content">
        
        <div class="spublic-profile-page">
          <section class="top-fpp-about-section">
              <div class="scontainer">
                  <div class="srow">
                      <div class="scol-lg-12">
                          <div class="freelancer-public-profile-about fpp-box-shadows dashboard_inn">
                              <div class="fpp-info-top">
                                  <div class="left-content">
                                      <div class="profile-image">
                                          <?php echo get_avatar( $author_id, 70 ); ?>
                                      </div>
                                      <div class="profile-info">                                   
                                          <h4 class="title fpp-title"><?php echo $author_name ?></h4>
                                          <h5 class="designation">
                                              <?php if ( fre_share_role() || ae_user_role( $author_id ) == FREELANCER ) {
                                                  if ( $convert ) { ?>
                                                      <span><?php echo $convert->et_professional_title; ?></span>
                                                  <?php }
                                              } else { ?>
                                                <span><?php echo $author_employer->company_name; ?></span>
                                              <?php } ?>
                                          </h5>
                                          <p><i class="fas fa-map-marker-alt"></i> 
                                              <?php if ( ! empty( $convert->tax_input['country'] ) ) {
                                                  echo '<span>' . $convert->tax_input['country']['0']->name . '</span>';
                                              } ?>
                                          </p>
                                      </div>
                                  </div>
                                  <div class="right-content">
                                    <?php if ( $author_available == 'on' || $author_available == '' ) {
                                        echo '<div class="fpp-invite-btn">';
                                          if( ae_user_role( $user_ID ) == EMPLOYER  || current_user_can('manage_options') ) { ?>
                                            <a href="#" data-toggle="modal" class="<?php if ( is_user_logged_in() ) {
                                                echo 'invite-open';
                                              } else {
                                                echo 'login-btn';
                                              } ?>" data-user="<?php echo $convert->post_author ?>">
                                              <?php _e( "Invite", ET_DOMAIN ) ?>
                                            </a>
                                          <?php }  ?>
                                          <?php
                                            $show_btn =  apply_filters('show_btn_contact', false); // @since 1.8.5
                                            if( $show_btn ){ ?>
                                            <a href="#" data-toggle="modal" class="contact-me"   data-user="<?php echo $convert->post_author ?>">
                                                <?php _e( "Contact", ET_DOMAIN ) ?>
                                            </a>
                                          <?php } ?>
                                        </div>
                                      <?php } ?>
                                      <?php if ( fre_share_role() || ae_user_role( $author_id ) == FREELANCER ) { ?>
                                          <div class="fpp-rating">
                                              <span class="rate-it" data-score="<?php echo $rating['rating_score']; ?>"></span>
                                          </div>
                                          <div class="fpp-project-count">
                                              <span><?php printf( __('Completed Projects: %s' ,ET_DOMAIN), intval($projects_worked) ); ?> </span>
                                          </div>
                                          <div class="fpp-wage-rate">
                                              <span><?php _e( 'Wage Rate:', ET_DOMAIN ) ?></span>
                                              <span>
                                                  <b>CHF <?php echo $author_freelancer->daily_wage_rate; ?> </b><?php _e( '/day', ET_DOMAIN ) ?>
                                                  <?php 
                                                      // if($hour_rate > 0)
                                                      // echo '<span>'.sprintf( __( '<b>%s</b> /day ',ET_DOMAIN), fre_price_format( $hour_rate ) ).'</span>'; 
                                                  ?>
                                              </span>
                                          </div>
                                          <div class="fpp-social-link">
                                              <ul class="fre">
                                                <li><a href="<?php echo $author_freelancer->facebook; ?>" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                                                <li><a href="<?php echo $author_freelancer->twitter; ?>" target="_blank"><i class="fab fa-twitter"></i></a></li>
                                                <li><a href="<?php echo $author_freelancer->linkedin; ?>" target="_blank"><i class="fab fa-linkedin-in"></i></a></li>
                                                <li><a href="skype:<?php echo $author_freelancer->skype; ?>" target="_blank"><i class="fab fa-skype"></i></a></li>
                                              </ul>
                                          </div>
                                      <?php } ?>
                                      <?php if ( fre_share_role() || ae_user_role( $author_id ) != FREELANCER ) { ?>
                                          <div class="fpp-social-link">
                                              <ul class="emplo">
                                                <li><a href="<?php echo $author_freelancer->facebook; ?>" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                                                <li><a href="<?php echo $author_freelancer->twitter; ?>" target="_blank"><i class="fab fa-twitter"></i></a></li>
                                                <li><a href="<?php echo $author_freelancer->linkedin; ?>" target="_blank"><i class="fab fa-linkedin-in"></i></a></li>
                                                <li><a href="skype:<?php echo $author_freelancer->skype; ?>" target="_blank"><i class="fab fa-skype"></i></a></li>
                                              </ul>
                                          </div>
                                      <?php } ?>
                                  </div>
                              </div>
                              <div class="fpp-summery">
                                  <h4 class="fpp-title"><?php _e( 'About Me', ET_DOMAIN ) ?></h4>
                                  <?php if ( ! empty( $convert ) ) { ?>
                                      <div class="fpp-summery-content <?php echo $class_name ?>-summery">
                                          <?php
                                              global $post;
                                              $post = $profile;
                                              setup_postdata( $profile );
                                              the_content();
                                              wp_reset_postdata();
                                          ?>
                                      </div>
                                  <?php } ?>
                              </div>
                              <?php if ( fre_share_role() || ae_user_role( $author_id ) == FREELANCER ) { ?>
                                <div class="fpp-skills">
                                    <h4 class="fpp-title"><?php _e( 'Skills & Experiences', ET_DOMAIN ) ?></h4>
                                    <div class="fpp-skills-wrap">
                                        <ul>
                                            <?php if ( isset( $convert->tax_input['skill'] ) && $convert->tax_input['skill'] ) {
                                                foreach ( $convert->tax_input['skill'] as $tax ) { ?>
                                                    <li>
                                                    <?php echo '<span class="fre-label">' . $tax->name . '</span>'; ?>
                                                    </li>
                                                <?php }
                                            }?>                                    
                                        </ul>
                                    </div>
                                </div>
                              <?php } ?>
                          </div>
                      </div>
                  </div>
              </div>
          </section>


          <?php if ( fre_share_role() || ae_user_role( $author_id ) == FREELANCER ) { ?>

            <?php
              // $bids = Freelancer::get_bids( get_current_user_id() );


            // echo '<pre>';
            // print_r( $bids );
            // echo '</pre>';

            // foreach ($bids as $bid) {
            //   if($bid->post_status == "complete" ) {
            //     echo $bid->post_title;
            //   }
            // }



              global $user_bids,$wp_query;
              $author_id = get_query_var( 'author' );
              $is_author = is_author();
              add_filter( 'posts_orderby', 'fre_reset_order_by_project_status' );
              add_filter( 'posts_where', 'fre_filter_where_bid' );

              $query_args = array( 'post_status'         => array('complete'),
                                  'post_type'           => BID,
                                  'author'              => $author_id,
                                  'accepted'            => 1,
                                  'filter_work_history' => '',
                                  'is_author'           => $is_author
              );
              query_posts($query_args);
              $bid_posts = $wp_query->found_posts;
              global $wp_query, $ae_post_factory;
              $author_id = get_query_var( 'author' );
              $post_object = $ae_post_factory->get( BID );
            ?>


            <section class="fpp-completed-project-section">
              <div class="scontainer">
                  <div class="srow">
                      <div class="scol-lg-12">
                          <div class="fpp-recent-projects-wrap fpp-box-shadows dashboard_inn">
                              <h4 class="fpp-title"><?php _e('Recent Completed Projects and Reviews',ET_DOMAIN) ?></h4>
                              <div class="fpp-completed-project-wrap">

                                <?php
                                  $postdata = array();
                                  if ( have_posts() ):
                                    while ( have_posts() ) {
                                      the_post();
                                      $convert    = $post_object->convert( $post, 'thumbnail' );
                                      $postdata[] = $convert;
                                      get_template_part( 'template-parts/author-freelancer-history', 'item' );
                                    }
                                  else:
                                    _e( '<li class="bid-item"><span class="profile-no-results" style="padding: 0">There are no activities yet.</span></li>', ET_DOMAIN );
                                  endif;
                                ?>

                              </div>
                          </div>
                      </div>
                  </div>
              </div>
            </section>

            <?php remove_filter('posts_where', 'fre_filter_where_bid');
            remove_filter('posts_orderby', 'fre_reset_order_by_project_status');
            ?>

            
            <section class="fpp-completed-portfolio-section">
              <?php 
                global $wp_query, $ae_post_factory, $post;
                $wp_query->query = array_merge(  $wp_query->query ,array('posts_per_page' => 6)) ;
                $post_object_portfolio = $ae_post_factory->get( 'portfolio' );
                $is_edit = false;
                if(is_author()){
                  $author_id        = get_query_var( 'author' );
                }else{
                  $author_id        = get_current_user_id();
                  $is_edit = true;
                }

                $query_portfolio_args =  array(
                  // 'post_parent' => $convert->ID,
                  'posts_per_page' => 6,
                  'post_status' => 'publish',
                  'post_type' => PORTFOLIO,
                  'author' => $author_id,
                  'is_edit' =>$is_edit
                );

                query_posts($query_portfolio_args);
              ?>
              <div class="scontainer">
                  <div class="srow">
                      <div class="scol-lg-12">
                          <div class="fpp-recent-projects-wrap fpp-box-shadows dashboard_inn">
                              <h4 class="fpp-title"><?php _e('Portfolios',ET_DOMAIN) ?></h4>
                              <div class="fpp-portfolio-wrap">      
                                
                                <?php
                                  $postdata = array();
                                  if ( have_posts() ):
                                    while ( have_posts() ) {
                                      the_post();
                                      $convert    = $post_object_portfolio->convert( $post, 'thumbnail' );
                                      $postdata[] = $convert; 
                                      
                                      $portfolio_data = $post_object_portfolio->current_post;
                                      // get_template_part( 'template-parts/author-freelancer-history', 'item' );
                                      ?>
                                      
                                        <div class="fpp-portfolio-item">
                                          <div class="fpp-inner-cont">
                                            <img src="<?php echo $portfolio_data->the_post_thumbnail_full; ?>" alt="<?php echo $portfolio_data->post_title; ?>">
                                            <div class="fpp-pf-content">
                                                <div class="fpp-pf-cnts-icon">
                                                    <a class="fpp-lightbox-image" href="<?php echo $portfolio_data->the_post_thumbnail_full; ?>">
                                                        <span class="icon-magnifier">
                                                            <i class="fa fa-eye"></i>
                                                        </span>
                                                    </a>
                                                    <a href="" target="_blank">
                                                        <span class="icon-link">
                                                            <i class="fa fa-external-link"></i>
                                                        </span>
                                                    </a>
                                                </div>
                                                <div class="fpp-pf-cnts-inner">
                                                    <p><?php echo $portfolio_data->post_title; ?></p>
                                                </div>
                                            </div>
                                          </div>
                                        </div>



                                    <?php }
                                  else:
                                    _e( 'There are no activities yet.', ET_DOMAIN );
                                  endif;
                                ?>

                              </div>
                          </div>
                      </div>
                  </div>
              </div>
            </section>




              <?php //list portfolios
              // get_template_part( 'list', 'portfolios' );
              // wp_reset_query();
              // list project worked
              // get_template_part( 'template/author', 'freelancer-history' );
              // wp_reset_query();

              get_template_part( 'list', 'experiences' );
              wp_reset_query();
              get_template_part( 'list', 'certifications' );
              wp_reset_query();
              get_template_part( 'list', 'educations' );
              wp_reset_query();
              ?>

              <?php } else {
                if ( fre_share_role() || ae_user_role( $author_id ) != FREELANCER ) { ?>
                  <section class="author-employer-project-history-wrap">
                    <div class="scontainer">
                      <div class="srow">
                        <div class="scol-lg-12">
                          <div class="fpp-e-projects-history-wrap fpp-box-shadows dashboard_inn">
                            <?php get_template_part( 'template/author', 'employer-history' ); ?>
                          </div>
                        </div>
                      </div>
                    </div>
                  </section>
                <?php }
              ?>
          <?php } ?>
          
          
          </div>
        </div>
        </section>
      </div>
    </div>



<?php

get_footer();