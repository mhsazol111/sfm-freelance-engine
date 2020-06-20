<?php
$project    = Employer::get_project( $project->ID );
$categories = Employer::get_project_terms( $project->id );
$employer   = Employer::get_employer( $project->employer_id );
?>
<div class="project_posts employer-my-project" id="<?php echo $project->id; ?>">
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
                    </div> &nbsp;|&nbsp;
                    Bids: <span><?php echo ($project->total_bids ?? 0); ?></span> &nbsp;|&nbsp;
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
                    } elseif ( 'archive' == $project->status ) {
                        echo '<span class="ie_btn_small ie_btn_orange">Archived</span>';
                    } elseif ( 'disputing' == $project->status ) {
                        echo '<span class="ie_btn_small ie_btn_red">Disputed</span>';
                    } elseif ( 'draft' == $project->status ) {
                        echo '<span class="ie_btn_small ie_btn_red">Drafted</span>';
                    }
				?>
                <h3>$<?php echo $project->et_budget; ?></h3>
                <span><?php echo date( 'F j, Y', strtotime( $project->project_deadline ) ); ?></span>
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
                <a class="ie_btn ie_btn_blue" href="<?php echo $project->url ?>">
                    <i class="far fa-eye" aria-hidden="true"></i> View Project
                </a>
                <?php if ( 'publish' == $project->status || 'draft' == $project->status ) { ?>
                    <a class="ie_btn ie_btn_green" href="<?php echo et_get_page_link( 'edit-project' ) ?>?id=<?php echo $project->id; ?>">
                        <i class="far fa-edit" aria-hidden="true"></i> Edit
                    </a>
                <?php } ?>
                <!-- <a class="ie_btn ie_btn_green" href="<?php //echo et_get_page_link( 'submit-project' ) ?>?id=<?php //echo $project->id; ?>">
                    <i class="far fa-edit" aria-hidden="true"></i> Edit
                </a> -->
				<?php if ( 'draft' == $project->status ) : ?>
                    <a id="project-delete" class="ie_btn ie_btn_red custom-project-action" data-action="delete" data-project-id="<?php echo $project->id; ?>">
                        <i class="fas fa-archive" aria-hidden="true"></i> Delete
                    </a>
				<?php endif; ?>
				<?php if ( 'publish' == $project->status ) : ?>
                    <a id="project-archive" class="ie_btn ie_btn_red custom-project-action" data-action="archive" data-project-id="<?php echo $project->id; ?>">
                        <i class="fas fa-archive" aria-hidden="true"></i> Archive
                    </a>
				<?php endif; ?>
            </div>
        </div>
    </div><!-- End .project_row -->
</div>