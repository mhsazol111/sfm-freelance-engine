<?php

    /**

     * The tag template file

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
<section class="top-banner-section" style="background-image:url(/wp-content/uploads/2020/04/blog-page-banner-min.jpg);">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="contact-banner-content">
                    <h1><?php echo single_tag_title(); ?></h1>
                    <p><?php echo _e( "Lorem Ipsum is simply dummy text of the printing a Lorem Ipsum has been the industry's standard dummy text ever since the 1500s", ET_DOMAIN ); ?>
                    </p>
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

<section class="blog_shortcode" id="archive-section">
    <div class="container">
        <div class="row faq_head">
            <div class="col-md-12">
                <?php if ( have_posts() ): ?>
                <div class="sfm-blog-post-wrap" id="blog">
                    <?php while ( have_posts() ): the_post();?>
                    <div class="sfm-blog-post-items">
                        <?php if ( has_post_thumbnail() ): ?>
                        <a href="<?php the_permalink();?>">
                            <div class="sfm-blog-thumbnail">
                                <?php the_post_thumbnail();?>
                            </div>
                        </a>
                        <?php else: ?>
                        <a href="<?php the_permalink();?>">
                            <div class="sfm-blog-thumbnail">
                                <img width="360" height="251" src="/wp-content/uploads/2020/04/dummy.jpg"
                                    class="attachment-post-thumbnail size-post-thumbnail wp-post-image" alt=""
                                    srcset="/wp-content/uploads/2020/04/dummy.jpg 360w, /wp-content/uploads/2020/04/dummy.jpg 300w"
                                    sizes="(max-width: 360px) 100vw, 360px">
                            </div>
                        </a>
                        <?php endif;?>
                        <div class="sfm-blog-content">
                            <a href="<?php the_permalink();?>">
                                <h3 class="cus_mod_transition"><?php the_title();?></h3>
                            </a>
                            <div class="date cus_mod_transition"><?php echo get_the_date( 'd.m.Y' ); ?></div>
                        </div>
                    </div>

                    <?php endwhile;?>
                </div>


                <div class="blog-pagination">
                    <?php
                        global $wp_query;
                        $big = 999999999;

                        $paginate_args = array(
                            'base'               => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                            'format'             => '?paged=%#%',
                            'total'              => $wp_query->max_num_pages,
                            'current'            => max( 1, get_query_var( 'paged' ) ),
                            'show_all'           => false,
                            'end_size'           => 1,
                            'mid_size'           => 2,
                            'prev_next'          => false,
                            'prev_text'          => __( '<' ),
                            'next_text'          => __( '>' ),
                            'type'               => 'plain',
                            'add_args'           => false,
                            'add_fragment'       => '',
                            'before_page_number' => '',
                            'after_page_number'  => '',
                        );

                        echo paginate_links( $paginate_args );
                    ?>
                </div>
                <?php endif;?>
            </div>
        </div>
    </div>
</section>
<?php
get_footer();