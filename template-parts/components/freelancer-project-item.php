<?php
$project    = Employer::get_project( $project->ID );
$categories = Employer::get_project_terms( $project->id );
$employer   = Employer::get_employer( $project->employer_id );
// $bid        = Freelancer::get_bid( $project->project_id );
// pri_dump( $bid );
?>


<div class="project_posts freelancer-my-project" id="<?php echo $project->id; ?>">
    <div class="project_row">
        <div class="d_head">
            <div class="head_left">
                <h3><a href="<?php echo $project->url; ?>"><?php echo $project->title; ?></a></h3>
                <div class="e_nav">
                    Posted on: <span><?php echo date( 'F j, Y', strtotime( $project->post_date ) ); ?></span> &nbsp;|&nbsp;
                    Categories:
                    <div class="cats">
						<?php
						$categories = Employer::get_project_terms( $project->id, 'project_category', true, '', true );
						echo $categories;
						?>
                    </div>
				</div>
				<div class="e_nav nav2">
					Posted By: <span><?php echo $employer->display_name; ?></span> &nbsp;|&nbsp;
					Company: <span><?php echo $employer->company_name; ?></span> &nbsp;|&nbsp;
					Budget: <span>$<?php echo $project->et_budget; ?></span> &nbsp;|&nbsp;
					Deadline: <span><?php echo date( 'F j, Y', strtotime( $project->project_deadline ) ); ?></span>
				</div>
            </div>
            <div class="head_right">
				<?php
				if ( 'close' == $project->status ) {
					echo '<span class="ie_btn_small ie_btn_green">Active</span>';
				} elseif ( 'complete' == $project->status ) {
					echo '<span class="ie_btn_small ie_btn_purple">Completed</span>';
				} elseif ( 'publish' == $project->status ) {
					echo '<span class="ie_btn_small ie_btn_yellow">Pending</span>';
				} elseif ( 'unaccept' == $project->status ) {
					echo '<span class="ie_btn_small ie_btn_orange">Unaccepted</span>';
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
            </div>
            <div class="footer_right">
				<?php if ( ( 'close' == $project->status ) || ( 'complete' == $project->status ) || ( 'disputing' == $project->status ) || ( 'disputed' == $project->status ) ) : ?>
                    <a class="ie_btn ie_btn_blue" href="/messages<?php //echo $project->url . '?workspace=1'; ?>">
                        <i class="far fa-eye" aria-hidden="true"></i> Go to Workspace
                    </a>
				<?php else : ?>
                    <a class="ie_btn ie_btn_blue" href="<?php echo $project->url ?>">
                        <i class="far fa-eye" aria-hidden="true"></i> View Project
                    </a>
				<?php endif; ?>
            </div>
        </div>
    </div><!-- End .project_row -->
</div>