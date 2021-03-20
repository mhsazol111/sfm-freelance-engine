<?php
    /**
     * Template Name: CG
     */

    get_header();
?>

<?php
    if ( have_rows( 'blog' ) ):
        while ( have_rows( 'blog' ) ): the_row(); ?>

        <?php if ( 'banner_section' == get_row_layout() ): ?>
            <section class="ie-banner" style="background-image:url(<?php echo get_sub_field( 'background_image' ); ?>);">
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
                            <img src="<?= get_site_url(); ?>/wp-content/uploads/2020/04/arrow.svg" alt="<?php echo _e( 'arrow', ET_DOMAIN ); ?>">
                        </div>
                    </div>
                </a>
            </section>
        <?php endif;?>

<?php if ( 'featured_shortcode' == get_row_layout() ): ?>
<section class="blog-featured">
    <div class="container">
        <div class="row faq_head">
            <div class="col-md-12">
                <?php if ( get_sub_field( 'shortcode' ) ): ?>
                <?php echo get_sub_field( 'shortcode' ); ?>
                <?php endif;?>
            </div>
        </div>

    </div>
</section>
<?php endif;?>

<?php if ( 'blog_shortcode' == get_row_layout() ): ?>
<section class="blog_shortcode">
    <div class="container">
        <div class="row faq_head">
            <div class="col-md-12">
                <?php if ( get_sub_field( 'shortcode' ) ): ?>
                <?php echo get_sub_field( 'shortcode' ); ?>
                <?php endif;?>
            </div>
        </div>
    </div>
</section>

<?php endif;?>

<?php

    endwhile;
    endif;
?>

<?php
get_footer();