<?php
$freelancer  = Freelancer::get_freelancer( $bid->post_author );
$bid_details = Freelancer::get_bid( $bid->ID );
$project     = Employer::get_project( $bid_details->project_id );
?>

<div class="proposals_row sfm-dashboard-bids">
    <div class="thumb_content">
        <div class="thumb background_position">
            <?php echo get_avatar($bid->post_author, '50'); ?>
            <div class="rate-it fpp-rating" data-score="<?php echo $freelancer->rating_score; ?>"></div>
        </div>
    </div>
    <div class="p_info">
        <div class="p-info-wraper">
            <div class="info-left">
                <h4><?php echo $freelancer->name; ?></h4>
                <p class="degination"><?php echo $freelancer->et_professional_title; ?></p>
                <p><?php _e( "Completed Project:", ET_DOMAIN ); ?> <span><?php echo isset($freelancer->total_projects_worked) ? $freelancer->total_projects_worked : 0; ?></span></p>
            </div>
            <div class="info-right">
                <p class="info-price">CHF <?php echo $bid_details->bid_daily_wage; ?><?php _e( "/day", ET_DOMAIN ); ?></p>
                <p class="info-week"><?php _e( "in {$bid_details->bid_work_days} days", ET_DOMAIN ); ?></p>
                <p class="info-deadline"><?php echo date("d-M-Y", strtotime($bid_details->bid_deadline)); ?></p>
            </div>
        </div>
        
        <p class="link-title"><?php _e( "Project:", ET_DOMAIN ); ?> <?php echo $project->title; ?></p>
        <a class="ie_btn" href="<?php echo $bid->guid; ?>"><?php _e( "View Bid", ET_DOMAIN ); ?></a>
    </div>
</div><!-- End .proposals_row -->