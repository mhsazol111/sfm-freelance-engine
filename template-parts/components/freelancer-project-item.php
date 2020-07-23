<?php
$project    = Employer::get_project( $project->ID );
$categories = Employer::get_project_terms( $project->id );
$employer   = Employer::get_employer( $project->employer_id );
// $bid        = Freelancer::get_bid( $project->project_id );
// pri_dump( $bid );
$languages     = get_the_terms( $project->id, 'language' );
$language_list = [];
if ( $languages ) {
	foreach ( $languages as $lang ) {
		$language_list[] = $lang->name;
	}
	$language_list = implode( ' | ', $language_list );
}
?>


<div class="project_posts freelancer-my-project" id="<?php echo $project->id; ?>">
    <div class="project_row">
        <div class="d_head">
            <div class="head_left">
                <h3><a href="<?php echo $project->url; ?>"><?php echo $project->title; ?></a></h3>
                <div class="e_nav">
					<?php _e( 'Posted on:', ET_DOMAIN ) ?>
                    <span><?php echo date( 'F j, Y', strtotime( $project->post_date ) ); ?></span> &nbsp;|&nbsp;
					<?php _e( 'Categories:', ET_DOMAIN ) ?>
                    <div class="cats">
						<?php
						$categories = Employer::get_project_terms( $project->id, 'project_category', true, '', true );
						echo $categories;
						?>
                    </div>
                </div>
                <div class="e_nav nav2">
					<?php _e( 'Posted By:', ET_DOMAIN ) ?> <span><?php echo $employer->display_name; ?></span> &nbsp;|&nbsp;
					<?php _e( 'Company:', ET_DOMAIN ) ?> <span><?php echo $employer->company_name; ?></span> &nbsp;|&nbsp;
					<?php _e( 'Budget:', ET_DOMAIN ) ?> <span><?php
						$budgets = $project->et_budget;
						if ( is_numeric( $budgets ) ) { ?>
                            CHF <?php echo $budgets;
						} else {
							echo $budgets;
						}
						?></span> &nbsp;|&nbsp;
					<?php _e( 'Deadline:', ET_DOMAIN ) ?>
                    <span><?php echo date( 'F j, Y', strtotime( $project->project_deadline ) ); ?></span>
                </div>
            </div>
            <div class="head_right">
				<?php
				if ( 'close' == $project->status ) {
					echo '<span class="ie_btn_small ie_btn_green">Ongoing</span>';
				} elseif ( 'complete' == $project->status ) {
					echo '<span class="ie_btn_small ie_btn_purple">Completed</span>';
				} elseif ( 'publish' == $project->status ) {
					$bids = new WP_Query( array(
						'post_type'       => BID,
						'author'          => get_current_user_id(),
						'post_parent__in' => array( $project->id ),
						'post_status'     => 'unaccept',
					) );
					if ( $bids->posts ) {
						echo '<span class="ie_btn_small ie_btn_orange">Declined</span>';
					} else {
						echo '<span class="ie_btn_small ie_btn_yellow">Pending</span>';
					}
				} elseif ( 'unaccept' == $project->status ) {
					echo '<span class="ie_btn_small ie_btn_orange">Declined</span>';
				} elseif ( 'disputing' == $project->status ) {
					echo '<span class="ie_btn_small ie_btn_red">Cancelled</span>';
				}
				?>
            </div>
        </div>
        <div class="content">
			<?php
			$str = strip_tags( $project->content );
			if ( strlen( $str ) > 400 ) {
				$str = substr( $str, 0, 400 ) . '...';
			}
			echo $str;
			?>
        </div>
        <div class="d_footer">
            <div class="footer_left">
				<?php
				$skills = Employer::get_project_terms( $project->id, 'skill', 'true' );
				echo $skills;
				?>
                <p class="country-language">
					<?php echo $language_list ? '<strong>' . __( 'Languages', ET_DOMAIN ) . ': </strong>' . __( $language_list, ET_DOMAIN ) : '' ?>
                </p>
            </div>
            <div class="footer_right">
				<?php if ( ( 'close' == $project->status ) || ( 'complete' == $project->status ) || ( 'disputing' == $project->status ) || ( 'disputed' == $project->status ) ) : ?>
                    <a class="ie_btn ie_btn_blue" href="<?php echo $project->url; ?>">
                        <i class="far fa-eye" aria-hidden="true"></i> <?php _e( 'View Project', ET_DOMAIN ); ?>
                    </a>
				<?php else : ?>
                    <a class="ie_btn ie_btn_blue" href="<?php echo $project->url ?>">
                        <i class="far fa-eye" aria-hidden="true"></i> <?php _e( 'View Project', ET_DOMAIN ) ?>
                    </a>
				<?php endif; ?>
            </div>
        </div>
    </div><!-- End .project_row -->
</div>