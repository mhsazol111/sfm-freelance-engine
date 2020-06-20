<?php

// Blog Shortcode New Design
//  [news_slider posts_per_page="-1"]
function sfm_news_function( $atts = array(), $content = '' ) {
    $atts = shortcode_atts( array(
        'posts_per_page' => '-1',
    ), $atts, 'news_slider' );

    $args = array(
        'post_type'      => 'post',
        'post_status'    => 'publish',
        'posts_per_page' => $atts['posts_per_page'],
    );

    $blog_posts = new WP_Query( $args );
    ob_start();

    if ( $blog_posts->have_posts() ): ?>
        <div class="sfm-blog-post-wrap home-blog-slide owl-carousel" id="news-slider">
            <?php while ( $blog_posts->have_posts() ): $blog_posts->the_post();?>
                <div class="sfm-blog-post-items">
                    <?php if ( has_post_thumbnail() ): ?>
                    <a href="<?php the_permalink();?>">
                        <div class="sfm-blog-thumbnail news-thumb"
                            style="background-image: url('<?php the_post_thumbnail_url()?>');">
                        </div>
                    </a>
                    <?php else: ?>
                    <div class="sfm-blog-thumbnail">
                        <a href="<?php the_permalink();?>">
                            <img width="360" height="251" src="/wp-content/uploads/2020/04/dummy.jpg"
                                class="attachment-post-thumbnail size-post-thumbnail wp-post-image" alt=""
                                srcset="/wp-content/uploads/2020/04/dummy.jpg 360w, /wp-content/uploads/2020/04/dummy.jpg 300w"
                                sizes="(max-width: 360px) 100vw, 360px">
                        </a>
                    </div>
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

        <?php
        wp_reset_postdata();
    endif;
    return ob_get_clean();
}
add_shortcode( 'news_slider', 'sfm_news_function' );







    // Blog Shortcode New Design
    //  [ie_blogs posts_per_page="-1"]
    function sfm_blogs_function( $atts = array(), $content = '' ) {
        $atts = shortcode_atts( array(
            'pagination'     => 'false',
            'posts_per_page' => '4',
        ), $atts, 'blog_slider' );

        $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

        $args = array(
            'post_type'      => 'post',
            'post_status'    => 'publish',
            'posts_per_page' => $atts['posts_per_page'],
            'paged'          => $paged,
        );

        $blog_posts = new WP_Query( $args );
        ob_start();

    if ( $blog_posts->have_posts() ): ?>
<div class="sfm-blog-post-wrap" id="blog">
    <?php while ( $blog_posts->have_posts() ): $blog_posts->the_post();?>
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

<?php if ( $atts['pagination'] == 'true' ): ?>
<div class="blog-pagination">
    <?php
        $big = 999999999;

            $paginate_args = array(
                'base'               => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                'format'             => '?paged=%#%',
                'total'              => $blog_posts->max_num_pages,
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
<?php
    wp_reset_postdata();
        endif;

        return ob_get_clean();
    }
    add_shortcode( 'blog_shortcode', 'sfm_blogs_function' );

    // featured shortcode
    function sfm_featured_function( $atts = array(), $content = '' ) {
        $atts = shortcode_atts( array(
            'pagination'     => 'false',
            'posts_per_page' => '1',
        ), $atts, 'featured_shortcode' );

        $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

        $args = array(
            'post_type'      => 'post',
            'post_status'    => 'publish',
            'posts_per_page' => $atts['posts_per_page'],
            'paged'          => $paged,
            'meta_key'       => 'blog_featured',
        );

        $blog_posts = new WP_Query( $args );
        ob_start();

    if ( $blog_posts->have_posts() ): ?>
<div class="sfm-feature-post-wrap" id="blog-feature">
    <?php while ( $blog_posts->have_posts() ): $blog_posts->the_post();?>
    <div class="sfm-feature-post-items">
        <?php if ( has_post_thumbnail() ): ?>
        <div class="sfm-featured-thumbnail">
            <a href="<?php the_permalink();?>">
                <?php the_post_thumbnail();?>
            </a>
        </div>
        <?php else: ?>
        <div class="sfm-blog-thumbnail">
            <a href="<?php the_permalink();?>">
                <img width="360" height="251" src="/wp-content/uploads/2020/04/dummy.jpg"
                    class="attachment-post-thumbnail size-post-thumbnail wp-post-image" alt=""
                    srcset="/wp-content/uploads/2020/04/dummy.jpg 360w, /wp-content/uploads/2020/04/dummy.jpg 300w"
                    sizes="(max-width: 360px) 100vw, 360px">
            </a>
        </div>
        <?php endif;?>
        <div class="sfm-feature-content">
            <div class="author-wrapper">
                <div class="a-left">
                    <span><?php echo _e( "By " ) . get_the_author(); ?></span>
                    <span><?php echo get_the_date( 'j | F Y' ); ?></span>
                </div>
                <div class="a-right">
                    <a target="_blank"
                        href="https://www.facebook.com/sharer/sharer.php?u=<?php echo get_the_permalink(); ?>">
                        <i class="fa fa-facebook"></i>
                    </a>
                    <a target="_blank" href="https://twitter.com/home?status=<?php echo get_the_permalink(); ?>">
                        <i class="fa fa-dribbble"></i>
                    </a>
                    <a target="_blank" href="https://twitter.com/home?status=<?php echo get_the_permalink(); ?>">
                        <i class="fa fa-instagram"></i>
                    </a>
                </div>

            </div>
            <a href="<?php the_permalink();?>">
                <h3><?php the_title();?></h3>
            </a>
            <div class="content">
                <p><?php echo get_the_excerpt(); ?></p>
            </div>
        </div>
    </div>

    <?php endwhile;?>
</div>

<?php if ( $atts['pagination'] == 'true' ): ?>
<div class="blog-pagination">
    <?php
        $big = 999999999;

            $paginate_args = array(
                'base'               => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                'format'             => '?paged=%#%',
                'total'              => $blog_posts->max_num_pages,
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
<?php
    wp_reset_postdata();
        endif;

        return ob_get_clean();
}
add_shortcode( 'featured_shortcode', 'sfm_featured_function' );