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
    global $post;
    get_header();
    the_post();
?>

<section class="ie-banner"
    style="background-image:url(<?php echo get_stylesheet_directory_uri() . '/inc/images/blog_single_banner.jpg'; ?>);">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="ie-banner-content">
                    <h1 class="ie-banner-title"><?php echo _e( "Blog", ET_DOMAIN ); ?></h1>
                    <p class="ie-banner-description"><?php echo _e( "Lorem Ipsum is simply dummy text of the printing a", ET_DOMAIN ); ?></p>
                    <p class="ie-banner-description"><?php echo _e( "Lorem Ipsum has been the industry's standard dummy text ever since the 1500s", ET_DOMAIN ); ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <a href="#">
        <div class="banner-bottom-coner">
            <div class="bottom-btn-wrapper">
                <p><?php echo _e( 'SPS', ET_DOMAIN ); ?></p>
                <img src="<?= get_site_url(); ?>/wp-content/uploads/2020/04/arrow.svg" alt="arrow">
            </div>
        </div>
    </a>
</section>

<div class="container">
    <!-- block control  -->
    <div class="row block-posts" id="post-control">

        <div class="col-md-12 posts-container">
            <div class="blog-wrapper">

                <div class="blog_title">
                    <h1 class="title-blog"><?php the_title()?></h1><!-- end title -->
                </div>

                <div class="ie-single-post-feature">
                    <img src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>">
                </div>

                <div class="author-wrapper">
                    <span><?php _e( 'By', ET_DOMAIN ) ?> <?php the_author_posts_link();?></span> |
                    <span><?php //the_date( 'F Y' );?></span>

                    <?php
                        $archive_year  = get_the_time( 'Y' );
                        $archive_month = get_the_time( 'm' );
                        $archive_day   = get_the_time( 'd' );
                    ?>
                    <span><a
                            href="<?php echo get_day_link( $archive_year, $archive_month, $archive_day ); ?>"><?php echo the_date( 'F Y' ); ?></a></span>
                </div>
            </div>

            <div class="blog-content">

                <?php
                    the_content();
                    wp_link_pages( array(
                        'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', ET_DOMAIN ) . '</span>',
                        'after'       => '</div>',
                        'link_before' => '<span>',
                        'link_after'  => '</span>',
                    ) );
                ?>

                <span class="tag">
                    <?php the_tags( 'Tags: ', ', ', '<br />' );?>
                </span><!-- end cat -->
            </div>

            <div class="single_blog_social">
                <a href="#"><i class="fa fa-facebook cus_transition"></i></a>
                <a href="#"><i class="fa fa-twitter cus_transition"></i></a>
                <a href="#"><i class="fa fa-linkedin cus_transition"></i></a>
            </div>


        </div>
        <div class="clearfix"></div>

        <div class="col-md-12">
            <?php comments_template();?>
        </div>

        <!-- <span class="cmt">
	        	<i class="fa fa-comments"></i><?php //comments_number(); ?>
	        </span> -->
        <!-- end cmt count -->

        <div class="col-md-12">
            <div class="related_post">
                <div class="related_post_head">
                    <h1><?php _e( 'Related Post', ET_DOMAIN ) ?></h1>
                    <hr>
                </div>
                <div class="related_post_content">



                    <?php
                        $related = array(
                            'post_type'      => 'post',
                            'posts_per_page' => 3,
                            'post_status'    => 'publish',
                            'post__not_in'   => array( get_the_ID() ),
                            'orderby'        => 'rand',
                        );
                        $blog_related = new WP_Query( $related );
                        if ( $blog_related->have_posts() ):
                    ?>
                    <?php while ( $blog_related->have_posts() ): $blog_related->the_post();?>

                    <div class="article_row">
                        <div class="thumb background_position"
                            style="background: url(<?php echo the_post_thumbnail_url(); ?>);">
                            <a class="shadow cus_mod_transition" href="<?php the_permalink();?>"></a>
                        </div>
                        <div class="info">
                            <div class="info_head ie_mod_transition">
                                <h3 class="cus_mod_transition"><a
                                        href="<?php the_permalink();?>"><?php echo get_the_title(); ?></a></h3>
                            </div>
                            <div class="publish_date cus_mod_transition">
                                <?php the_time( "d.m.Y" );?>
                            </div>
                        </div>
                    </div>

                    <?php endwhile;?>
                    <?php endif;?>







                </div>
            </div>
        </div>


    </div>
    <!--// block control  -->
</div>
<?php
get_footer();
?>