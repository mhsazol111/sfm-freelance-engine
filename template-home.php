<?php
/**
 * Template Name: Home
 */

get_header();
$enable_social_icons        = get_field( 'enable_social_icons', 'option' );

if ( is_user_logged_in() && ! current_user_can( 'administrator' ) ) {
	wp_redirect( esc_url( get_site_url() . '/dashboard' ) );
}
?>


<?php
if ( have_rows( 'home_layout' ) ):
	while ( have_rows( 'home_layout' ) ): the_row();
		?>

		<?php if ( 'top_banner' == get_row_layout() ):
			$button_freelancer = get_sub_field( 'i_am_a_freelancer' );
			$button_company = get_sub_field( 'i_am_a_company' ); ?>
            <div class="fre-background sfm-top-banner" id="background_banner"
                 style="background-image: url(<?php the_sub_field( 'background_banner' ); ?>);">
                <div class="fre-bg-content">
                    <div class="container">
                        <h1 id="title_banner"><?php the_sub_field( 'title' ); ?></h1>
                        <p class="banner-content"><?php the_sub_field( 'content' ); ?></p>
                        <a class="banner-button freeelancer cus_mod_transition"
                           href="<?php echo $button_freelancer['url']; ?>"><?php echo $button_freelancer['title']; ?></a>
                        <a class="banner-button company cus_mod_transition"
                           href="<?php echo $button_company['url']; ?>"><?php echo $button_company['title']; ?></a>
                    </div>

                </div>
                <div class="container">
                    <div class="smf-social-links top-social-link" style="visibility: hidden;">
                        <ul>
                            <li><a class="cus_mod_transition" href="#"><i class="fa fa-instagram"></i></a></li>
                            <li><a class="cus_mod_transition" href="#"><i class="fa fa-facebook"></i></a></li>
                            <li><a class="cus_mod_transition" href="#"><i class="fa fa-twitter"></i></a></li>
                        </ul>
                    </div>
                    <div class="banner-moreinfo">
                        <a href="#home-section-two">
                            <img src="<?= get_site_url(); ?>/wp-content/uploads/2020/04/arrow.svg" alt="">
                            <p><?php echo _e( 'more info' ); ?> </p>
                        </a>
                    </div>
                    <a href="#">
                        <div class="banner-bottom-coner">
                            <div class="bottom-btn-wrapper">
                                <p><a href="https://www.switzerland-payroll.ch" style="color:#FFF">SPS</a></p>
                                <a href="https://www.switzerland-payroll.ch"><img src="<?= get_site_url(); ?>/wp-content/uploads/2020/04/arrow.svg" alt="SPS"></a>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
		<?php endif; ?>

		<?php if ( 'work_categories' == get_row_layout() ): ?>
            <section id="home-section-two">
                <div class="container">
                    <div class="sfm-heading">
                        <h2 class="headling-48"><?php the_sub_field( 'title' ); ?></h2>
                        <div class="title-divider"></div>
                    </div>

                    <div class="sfm-categories">
                        <ul>
							<?php
							$project_category = get_sub_field( 'items' );
							if ( $project_category ):
								foreach ( $project_category as $item ): ?>
                                    <!--<li class="cus_mod_transition"><a href="/projects/?category_project=<?php echo $item->slug ?>"><span><?php echo $item->name; ?></span></a>-->
                                    <li class="cus_mod_transition"><a><span><?php echo $item->name; ?></span></a>
                                    </li>
								<?php endforeach;
							endif; ?>
                        </ul>
                    </div>
                </div>
            </section>
		<?php endif; ?>
		<?php if ( 'fullwidth_left' == get_row_layout() ): ?>
            <section id="home-section-three">

				<?php if ( have_rows( 'content_left' ) ): ?>
				<?php while ( have_rows( 'content_left' ) ):
				the_row(); ?>
				<?php
				$attachment_id = get_sub_field( 'image' );
				$size          = "full"; // (thumbnail, medium, large, full or custom size)
				wp_get_attachment_image( $attachment_id, 'size' );
				?>
                <div class="col-md-6 three-left" style="background-image: url('<?php echo $attachment_id['url']; ?>');">
					<?php endwhile; ?>
					<?php endif; ?>
                </div>
                <div class="col-md-6 three-right">
					<?php if ( have_rows( 'content_right' ) ):
						while ( have_rows( 'content_right' ) ): the_row(); ?>
                            <div class="stwo-right">
                                <h2 class="headling-54 margin-l"><?php the_sub_field( 'title' ); ?></h2>
                                <div class="title-divider left"></div>
                                <p class="content">
									<?php if ( get_sub_field( 'content' ) ): ?>
										<?php echo get_sub_field( 'content' ); ?>
									<?php endif; ?>
                                </p>
                                <div class="cus-btn">
									<?php if ( get_sub_field( 'button' ) ):
										$button = get_sub_field( 'button' );
										?>
                                        <!--<a class="cus_mod_transition" href="<?php echo $button['url']; ?>"><?php echo $button['title']; ?></a>-->
									<?php endif; ?>
                                </div>
                            </div>
						<?php endwhile;
					endif; ?>
                </div>
            </section>
		<?php endif; ?>

		<?php if ( 'fullwidth_right' == get_row_layout() ): ?>
            <section id="home-section-four">

                <div class="col-md-6 three-left">
					<?php if ( have_rows( 'content_left' ) ): ?>
						<?php while ( have_rows( 'content_left' ) ): the_row(); ?>
                            <div class="stwo-right two">
                                <h2 class="headling-54 margin-r"><?php the_sub_field( 'title' ); ?></h2>
                                <div class="title-divider left"></div>
                                <p class="content">
									<?php if ( get_sub_field( 'content' ) ): ?>
										<?php echo get_sub_field( 'content' ); ?>
									<?php endif; ?>
                                </p>
                                <div class="cus-btn">
									<?php if ( get_sub_field( 'button' ) ):
										$button = get_sub_field( 'button' );
										?>
                                        <!--<a class="cus_mod_transition" href="<?php echo $button['url']; ?>"><?php echo $button['title']; ?></a>-->
									<?php endif; ?>
                                </div>
                            </div>
						<?php endwhile; ?>
					<?php endif; ?>
                </div>
				<?php if ( have_rows( 'content_right' ) ):
					while ( have_rows( 'content_right' ) ): the_row(); ?>
						<?php if ( get_sub_field( 'image' ) ):
							$attachment_id = get_sub_field( 'image' );
							$size = "full"; // (thumbnail, medium, large, full or custom size)
							wp_get_attachment_image( $attachment_id, 'size' );
							?>
                            <div class="col-md-6 three-right" style="background-image:url('<?php echo $attachment_id['url']; ?>')">
						<?php endif; ?>
                        </div>
					<?php endwhile;
				endif; ?>
            </section>
		<?php endif; ?>

		<?php if ( 'company_budget' == get_row_layout() ): ?>
            <section id="home-section-five"
                     style=" background-image: url(<?php the_sub_field( 'background_banner' ); ?>);">
                <div class="container">
                    <div class="company-title">
                        <h2 class="headling-48">
							<?php if ( get_sub_field( 'title' ) ): ?>
								<?php echo get_sub_field( 'title' ); ?>
							<?php endif; ?>
                        </h2>
                        <div class="title-divider"></div>
                        <p class="content">
							<?php if ( get_sub_field( 'content' ) ): ?>
								<?php echo get_sub_field( 'content' ); ?>
							<?php endif; ?>
                        </p>
                        <div class="cus-btn">
							<?php if ( get_sub_field( 'button' ) ):
								$button = get_sub_field( 'button' );
								?>
                                <!--<a class="cus_mod_transition" href="<?php echo $button['url']; ?>"><?php echo $button['title']; ?></a>-->
							<?php endif; ?>
                        </div>
                    </div>
                </div>
            </section>
		<?php endif; ?>
		<?php
           // changement de la var pour ne pas afficher les news (news en news1) if ( 'news' == get_row_layout() ): 
         if ( 'news1' == get_row_layout() ): ?>
            <section id="home-section-six">
                <div class="container">
                    <div class="company-title">
                        <h2 class="headling-54">
							<?php if ( get_sub_field( 'title' ) ): ?>
								<?php echo get_sub_field( 'title' ); ?>
							<?php endif; ?>
                        </h2>
                        <div class="title-divider left"></div>
						<?php if ( get_sub_field( 'content' ) ): ?>
							<?php echo get_sub_field( 'content' ); ?>
						<?php endif; ?>
                    </div>
                </div>

            </section>
		<?php endif; ?>
        <div class="clearfix"></div>

	<?php endwhile;
endif;
?>

<?php
get_footer();