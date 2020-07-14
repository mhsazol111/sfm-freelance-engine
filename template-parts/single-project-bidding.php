<?php
global $wp_query, $ae_post_factory, $post, $user_ID, $show_bid_info;
$post_object = $ae_post_factory->get( PROJECT );
$project = $post_object->current_post;
//$number_bids = (int) get_number_bids( get_the_ID() ); // 1.8.5
add_filter( 'posts_orderby', 'fre_order_by_bid_status' );
$bid_query = new WP_Query( array(
		'post_type'      => BID,
		'post_parent'    => get_the_ID(),
		'post_status'    => array(
			'publish',
			'complete',
			'accept',
			'unaccept',
			'disputing',
			'disputed',
			'archive',
			'hide',
		),
		'posts_per_page' => -1,
	)
);
remove_filter( 'posts_orderby', 'fre_order_by_bid_status' );
$bid_data = array();
?>
<div class="proposals_freelancers">
    <div class="dashboard_inn">
        <div class="freelancer-bidding <?php if ( USER_ROLE == 'freelancer' ) : ?>freelancer-bidding-free<?php endif; ?>">
			<?php if ( USER_ROLE == 'employer' || current_user_can( 'administrator' ) ) : ?>
                <div class="dashboard_title">
                    <h2><?php printf( __( 'Proposals from Freelancers (%s)', ET_DOMAIN ), $bid_query->found_posts );?></h2>
                    <hr>
                </div> <?php
				if ( $bid_query->have_posts() ) {
					global $wp_query, $ae_post_factory, $post;
					$post_object = $ae_post_factory->get( BID );
					while ( $bid_query->have_posts() ) {
						$bid_query->the_post();
						$convert = $post_object->convert( $post );
						$show_bid_info = can_see_bid_info( $convert, $project );
						include( locate_template( 'template-parts/components/bidding-item.php' ) );
					}
				} else {
					get_template_part( 'template/bid', 'not-item' );
				}
			else : ?>
                <div class="dashboard_title">
                <h2><?php printf( __( 'My Proposals', ET_DOMAIN ) );?></h2>
                <hr>
                </div><?php
				$freelancer_bid = Freelancer::get_bids( get_current_user_id(), array( get_the_ID()) );
				if ( $freelancer_bid->have_posts() ) {
					while ($freelancer_bid->have_posts()) {
						$freelancer_bid->the_post();
						include(locate_template('template-parts/components/bidding-item.php'));
					}
				} else {
					get_template_part( 'template/bid', 'not-item' );
				}
			endif;
			?>
        </div>
		<?php
		wp_reset_postdata();
		wp_reset_query();
		?>

    </div><!-- End .dashboard_inn -->
</div><!-- End .proposals_freelancers -->