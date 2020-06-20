<?php

/**
    * The template for displaying 404 pages (Not Found)
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
    get_header();
?>
<section class="ie-banner" style="background-image:url(/wp-content/uploads/2020/04/symbol-virtual-screen-blue-matrix-5000747.jpg);">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="ie-banner-content title-four-zero">
                    <h1 class="ie-banner-title"><?php echo _e( 'Page Not Found', ET_DOMAIN ); ?></h1>
                </div>
            </div>
        </div>
    </div>

    <div class="banner-bottom-coner">
        <a href="#">
            <div class="bottom-btn-wrapper">
                <p><?php echo _e( 'SPS', ET_DOMAIN ); ?></p>
                <img src="/wp-content/uploads/2020/04/arrow.svg" alt="<?php echo _e( 'arrow', ET_DOMAIN ); ?>">
            </div>
        </a>
    </div>
</section>

<section class="blog_shortcode">
    <div class="container">
        <div class="error-page-wrapper">
            <div class="col-md-4">
                <div class="sfm-error-wrap">
                    <h1 class="error-title"><?php echo _e( "Oops!", ET_DOMAIN ); ?></h1>
                    <h3 class="error-title-one">
                        <?php echo _e( "we can't seem to find the page you're looking for.", ET_DOMAIN ); ?></h3>
                    <P class="error-pragraph"><?php echo _e( "Error code: 404", ET_DOMAIN ); ?></P>
                </div>
            </div>
            <div class="col-md-8 error-img">
                <img src="/wp-content/uploads/2020/04/image-404.png" alt="">
            </div>
        </div>
    </div>
</section>
<?php
get_footer();