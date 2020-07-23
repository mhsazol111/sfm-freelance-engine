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
                    <?php _e( 'Posted on:', ET_DOMAIN ) ?> <span><?php echo date( 'F j, Y', strtotime( $project->post_date ) ); ?></span> &nbsp;|&nbsp;
                    <?php _e( 'Categories:', ET_DOMAIN ) ?>
                    <div class="cats">
						<?php
						$categories = Employer::get_project_terms( $project->id, 'project_category', true, '', true );
						echo $categories;
						?>
                    </div> &nbsp;|&nbsp;
                    <?php _e( 'Bids:', ET_DOMAIN ) ?> <span><?php echo ($project->total_bids ?? 0); ?></span> &nbsp;|&nbsp;
                    <?php _e( 'Budget:', ET_DOMAIN ) ?> <span><?php
                    $budgets = $project->et_budget; 
                    if(is_numeric($budgets)){ ?>
                        CHF <?php echo $budgets;
                    }else{ 
                        echo $budgets;
                    }
                    ?></span> &nbsp;|&nbsp;
                    <?php _e( 'Deadline:', ET_DOMAIN ) ?> <span><?php echo date( 'F j, Y', strtotime( $project->project_deadline ) ); ?></span>
                    <?php
                    $invitations = sfmInvitations::getInvitations( $project->id );
                    if( ! empty( $invitations ) ) {
                        printf(
                                "&nbsp;|&nbsp;%s <span>%d</span>",
                            __('Invited:', ET_DOMAIN ),
                            count( $invitations)
                        );
                    }
                    ?>
                </div>
                <p class="language-list">
		            <?php
		            $languages = get_the_terms($project->id, 'language');
		            $language_list = [];
		            if ($languages) {
			            foreach ($languages as $lang) {
				            $language_list[] = $lang->name;
			            }
		            }
		            $language_list = implode(' | ', $language_list);
		            echo $language_list ? '<strong>' . __( 'Preferred Language', ET_DOMAIN ) . ': </strong>' . __( $language_list, ET_DOMAIN ) : '';
		            ?>
                </p>
            </div>
            <div class="head_right">
                <?php
                    if ( 'close' == $project->status ) {
                        echo '<span class="ie_btn_small ie_btn_green">Ongoing</span>';
                    } elseif ( 'complete' == $project->status ) {
                        echo '<span class="ie_btn_small ie_btn_purple">Completed</span>';
                    } elseif ( 'publish' == $project->status ) {
                        echo '<span class="ie_btn_small ie_btn_yellow">Published</span>';
                    } elseif ( 'archive' == $project->status ) {
                        echo '<span class="ie_btn_small ie_btn_orange">Archived</span>';
                    } elseif ( 'disputing' == $project->status ) {
                        echo '<span class="ie_btn_small ie_btn_red">Cancelled</span>';
                    } elseif ( 'draft' == $project->status ) {
                        echo '<span class="ie_btn_small ie_btn_red">Pending</span>';
                    }
				?>
                <h3><?php
                if(is_numeric($budgets)){ ?>
                    CHF <?php echo $budgets;
                }else{ 
                    echo $budgets;
                }
                ?></h3>
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
                    <i class="far fa-eye" aria-hidden="true"></i> <?php _e( 'View Project', ET_DOMAIN ) ?>
                </a>
                <?php if ( 'publish' == $project->status || 'draft' == $project->status ) { ?>
                    <a class="ie_btn ie_btn_green" href="<?php echo et_get_page_link( 'edit-project' ) ?>?id=<?php echo $project->id; ?>">
                        <i class="far fa-edit" aria-hidden="true"></i> <?php _e( 'Edit', ET_DOMAIN ) ?>
                    </a>
                <?php } ?>
                <!-- <a class="ie_btn ie_btn_green" href="<?php //echo et_get_page_link( 'submit-project' ) ?>?id=<?php //echo $project->id; ?>">
                    <i class="far fa-edit" aria-hidden="true"></i> Edit
                </a> -->
				<?php if ( 'draft' == $project->status ) : ?>
                    <a id="project-delete" class="ie_btn ie_btn_red custom-project-action" data-action="delete" data-project-id="<?php echo $project->id; ?>">
                        <i class="fas fa-archive" aria-hidden="true"></i> <?php _e( 'Delete', ET_DOMAIN ) ?>
                    </a>
				<?php endif; ?>
				<?php if ( 'publish' == $project->status ) : ?>
                    <a id="project-archive" class="ie_btn ie_btn_red custom-project-action" data-action="archive" data-project-id="<?php echo $project->id; ?>">
                        <i class="fas fa-archive" aria-hidden="true"></i> <?php _e( 'Archive', ET_DOMAIN ) ?>
                    </a>
				<?php endif; ?>
            </div>
        </div>
    </div><!-- End .project_row -->
</div>