<?php
/**
 * Template Name: Contact Us
 */

get_header();
?>

<?php
if ( have_rows( 'contact_us' ) ):
	while ( have_rows( 'contact_us' ) ): the_row();
		?>

		<?php if ( 'banner_section' == get_row_layout() ): ?>
            <section class="ie-banner"
                     style="background-image:url(<?php echo get_sub_field( 'background_image' ); ?>);">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="ie-banner-content">
                                <h1 class="ie-banner-title"><?php echo get_sub_field( 'title' ); ?></h1>
                                <p class="ie-banner-description"><?php echo get_sub_field( 'description' ); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <a href="#">
                    <div class="banner-bottom-coner">
                        <div class="bottom-btn-wrapper">
                            <p><?php echo _e( 'SPS', ET_DOMAIN ); ?></p>
                            <img src="/wp-content/uploads/2020/04/arrow.svg"
                                    alt="<?php echo _e( 'arrow', ET_DOMAIN ); ?>">
                        </div>
                    </div>
                </a>
            </section>
		<?php endif; ?>


		<?php if ( 'contact_section' == get_row_layout() ): ?>
            <section class="contact_section">
                <div class="container">
                    <div class="row contact_top_section">
                        <div class="col-lg-12">
							<?php $section_title = get_sub_field( 'title' );
							if ( ! empty( $section_title ) ): ?>
                                <h3 class="title"><?php echo $section_title; ?></h3>
							<?php endif; ?>

							<?php $section_description = get_sub_field( 'description' );
							if ( ! empty( $section_description ) ): ?>
                                <p class="description"><?php echo $section_description; ?></p>
							<?php endif; ?>
                        </div>
                    </div>

                    <div class="row contact_content">
                        <div class="contact_form col-md-8">
							<?php echo do_shortcode( get_sub_field( 'left_content' )['contact_shortcode'] ); ?>
                        </div>
                        <div class="right_sidebar col-md-4">
                            <div class="bar_row">
                                <div class="left_info">
									<?php echo get_sub_field( 'right_content' )['address_content']; ?>
                                </div>
                                <div class="icon">
                                    <img src="<?php echo get_sub_field( 'right_content' )['address_icon']; ?>">
                                </div>
                            </div>

                            <div class="bar_row">
                                <div class="left_info">
									<?php echo get_sub_field( 'right_content' )['phone_numners']; ?>
                                </div>
                                <div class="icon">
                                    <img src="<?php echo get_sub_field( 'right_content' )['phone_icon']; ?>">
                                </div>
                            </div>

                            <div class="bar_row">
                                <div class="left_info email_address">
									<?php echo get_sub_field( 'right_content' )['email_address']; ?>
                                </div>
                                <div class="icon">
                                    <img src="<?php echo get_sub_field( 'right_content' )['email_icon']; ?>">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </section>
		<?php endif; ?>

		<?php if ( 'contact_map' == get_row_layout() ) : ?>
            <section class="contact_map_section">
				<?php $location = get_field( 'maps' );
				if ( $location ) : ?>
                    <div class="contact-map" data-zoom="16">
                        <div class="contact-marker" data-lat="<?php echo esc_attr( $location['46.9547232'] ); ?>"
                             data-lng="<?php echo esc_attr( $location['7.3598507'] ); ?>"></div>
                    </div>
				<?php endif; ?>
            </section>
		<?php endif; ?>

	<?php
	endwhile;
endif;
?>

<?php
get_footer();