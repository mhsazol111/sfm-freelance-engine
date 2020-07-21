<div class="project_content">
    <h3><?php _e( 'Project Brief', ET_DOMAIN ); ?></h3>
    <p>##############</p>
</div>
<hr>

<div class="project_info">
    <div class="default info_left">
        <div class="skill_req">
            <h4><?php _e( 'Skills Required', ET_DOMAIN ); ?></h4>
			<?php
			$skills = get_terms( array(
				'taxonomy'   => 'skill',
				'hide_empty' => false,
			) );
			foreach ($skills as $skill) {
			    echo '<a class="fre-label secondary-color" href="">'. $skill->name .'</a>';
            }
			?>
            <hr>
            <h4><?php _e( 'Project Category', ET_DOMAIN ); ?></h4>
	        <?php
	        $categories = get_terms( array(
		        'taxonomy'   => 'project_category',
		        'hide_empty' => false,
	        ) );
	        foreach ($categories as $category) {
		        echo '<a href="">'. $category->name .'</a>';
	        }
	        ?>
            <hr>
        </div>
        <h4><?php _e( 'File Attached', ET_DOMAIN ); ?></h4>
        <h4><?php _e( 'Invitation Sent', ET_DOMAIN ); ?></h4>
        <p><?php _e( 'Total invitations sent', ET_DOMAIN ); ?>:
            <strong>000</strong>
            <a href="javascript:void(0)"
               onclick="jQuery('#sfm_invitations_items').slideToggle();"><i><?php _e( 'Expand details', ET_DOMAIN ); ?></i></a>
        </p>
    </div>

    <div class="default info_right">
        <div class="proposals_row">
            <div class="thumb_content">
                <div class="thumb background_position">
                    <a class="" href="#">
                        <div class="thumb background_position">
							<?php echo get_avatar( get_current_user_id(), '125' ); ?>
                        </div>
                    </a>
                </div>
            </div>
            <div class="person_info">
                <h4><a href="#">##########</a></h4>
                <p>############</p>
            </div>
            <hr>
            <div class="proposals_info">
                <p><span>0</span> <?php _e( 'Total posted projects so far', ET_DOMAIN ); ?></p>
                <p><span>0</span> <?php _e( 'Completed Projects so far', ET_DOMAIN ); ?></p>
                <p><span>0</span> <?php _e( 'Declined Project so far', ET_DOMAIN ); ?></p>
            </div>
            <hr class="bottom_hr">
            <div class="open_projects">
                <a href="#"><?php _e( 'Open Projects by this Client', ET_DOMAIN ) ?></a>
            </div>
        </div><!-- End .proposals_row -->
    </div>

</div>


<div class="project-detail-box-01 no-padding-01">
    <div class="project-detail-extend-01">
        <div class="project-detail-milestone">
            <h4><?php _e( "Milestones", ET_DOMAIN ); ?></h4>
        </div>
    </div>
</div>