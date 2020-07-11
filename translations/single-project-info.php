<style>
    .project-detail-action a {
        margin-right: 10px;
        margin-bottom: 10px;
    }
</style>
<div class="project-detail-box">
	<div class="project-employer-review">
		<span class="employer-avatar-review"><?php echo get_avatar(get_current_user_id(), '125'); ?></span>
		<h2><a href="#" target="_blank">#######</a></h2>
		<p>######</p>
		<a href="#" id="" class="fre-normal-btn btn-complete-project"> <?php _e( 'Review for Company', ET_DOMAIN ); ?></a>
	</div>
</div>

<div class="dashboard_title single-project-top-meta-desc">
	<div class="d_t_info">
		<h2 class="project-detail-title">############</h2>
		<div class="e_nav">
			<i class="fas fa-user-friends"></i><?php _e( ' Number of Bids:', ET_DOMAIN ); ?>
			<span class="secondary-color"> 0</span> |
			<i class="far fa-check-circle"></i><?php _e( 'Project Status: ', ET_DOMAIN ); ?>
			<span>
                <?php
                $status_arr = array(
	                'close'     => __( "Processing", ET_DOMAIN ),
	                'complete'  => __( "Completed", ET_DOMAIN ),
	                'disputing' => __( "Disputed", ET_DOMAIN ),
	                'disputed'  => __( "Resolved", ET_DOMAIN ),
	                'publish'   => __( "Active", ET_DOMAIN ),
	                'pending'   => __( "Pending", ET_DOMAIN ),
	                'draft'     => __( "Draft", ET_DOMAIN ),
	                'reject'    => __( "Rejected", ET_DOMAIN ),
	                'archive'   => __( "Archived", ET_DOMAIN ),
                );
                foreach ($status_arr as $status) {
                	echo $status . ' ';
                }
                ?>
			</span> |
			<i class="far fa-clock"></i><?php _e( 'Posted on: ', ET_DOMAIN ); ?>
			<span class="secondary-color">00-00-0000</span> |
			<i class="fas fa-trophy"></i> <?php _e( 'Winning Bid: ', ET_DOMAIN ); ?>
			<span>######</span> |
			<i class="fas fa-trophy"></i>
			<?php _e( 'Budget: ', ET_DOMAIN ); ?>
			<span>0</span> |
			<i class="fas fa-hourglass-half"></i>
			<?php _e( 'Deadline: ', ET_DOMAIN ); ?>
			<span>00-00-0000</span>
		</div>
	</div>

	<div class="b_t_right">
		<div class="project-detail-action" style="display: block; text-align: left">
			<a class="fre-normal-btn primary-bg-color bid-action" data-action="cancel" data-bid-id=""><i class="fa fa-check-circle-o" aria-hidden="true"></i> <?php _e( 'Cancel', ET_DOMAIN ); ?></a>
			<a class="fre-action-btn" href="#"><i class="fa fa-check-circle-o" aria-hidden="true"></i> <?php _e( 'Send Proposal', ET_DOMAIN ); ?></a>
            <a class="fre-action-btn  project-action" data-action="archive" data-project-id=""> <?php _e( 'Archive This Project', ET_DOMAIN ); ?></a>
            <a href="#" class="fre-normal-btn primary-bg-color"><i class="fa fa-check-circle-o" aria-hidden="true"></i> <?php _e( 'Post Project Like This', ET_DOMAIN ); ?></a>
            <a class="fre-action-btn" href="#"> <?php _e( 'Edit', ET_DOMAIN ); ?></a>
            <a class="fre-normal-btn primary-bg-color project-action" data-action="approve" data-project-id=""><i class="fa fa-check-circle-o" aria-hidden="true"></i> <?php _e( 'Approve', ET_DOMAIN ); ?></a>
            <a class="fre-normal-btn primary-bg-color project-action" data-action="reject" data-project-id=""><i class="fa fa-check-circle-o" aria-hidden="true"></i> <?php _e( 'Reject', ET_DOMAIN ); ?></a>
            <a class="fre-action-btn project-action" data-action="delete" data-project-id=""> <?php _e( 'Delete', ET_DOMAIN ); ?></a>
            <a class="fre-normal-btn primary-bg-color" href="#"><i class="fa fa-check-circle-o" aria-hidden="true"></i> <?php _e( 'Send Proposal', ET_DOMAIN ); ?></a>
            <a title="" href="#" id="" class="fre-action-btn btn-complete-project"> <?php _e( 'Finish', ET_DOMAIN ); ?></a>
            <a title="" href="#" id="" class="fre-action-btn btn-close-project"><?php _e( 'Close', ET_DOMAIN ); ?></a>
		</div>
	</div>
</div>
<hr>