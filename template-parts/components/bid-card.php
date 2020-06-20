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
                <p>Completed Project: <span><?php echo $freelancer->total_projects_worked; ?></span></p>
            </div>
            <div class="info-right">
                <p class="info-price">CHF <?php echo $bid_details->bid_daily_wage; ?>/day</p>
                <p class="info-week">in <?php echo $bid_details->bid_work_days; ?> days</p>
                <p class="info-deadline"><?php echo date("d-M-Y", strtotime($bid_details->bid_deadline)); ?></p>
            </div>
        </div>
        
        <p class="link-title">Project: <?php echo $project->title; ?></p>
        <a class="ie_btn" href="<?php echo $bid->guid; ?>">View Bid</a>
    </div>
</div><!-- End .proposals_row -->