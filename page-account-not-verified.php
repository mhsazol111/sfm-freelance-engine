<?php 
    /**
    * Template Name: Account Not Verified
    */
    get_header(); ?>

    <section class="ie-banner" style="background-image:url(<?php echo get_field( 'background_image' ); ?>);">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ie-banner-content">
                        <h1 class="ie-banner-title"><?php echo get_field( 'headline' ); ?></h1>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="not-verified-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="not-verified-messages">
                        <?php echo get_field( 'messages' ); ?>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="not-verified-img">
                        <img src="<?php echo get_field( 'right_vector_image' ); ?>" alt="notify">
                    </div>
                </div>
            </div>
        </div>
    </section>
    

    <?php
    get_footer();