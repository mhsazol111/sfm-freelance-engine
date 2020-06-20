<?php
$project   = Employer::get_project( $proposal->post_parent );
$employers = Employer::get_employer( $project->employer_id );
?>

<div class="proposals_row sfm-dashboard-bids">
    <div class="thumb_content">
        <div class="thumb background_position">
            <?php echo get_avatar($project->employer_id, '50'); ?>
            <div class="rate-it fpp-rating" data-score="<?php echo $employers->rating_score; ?>"></div>
        </div>
    </div>
    <div class="p_info">
        <div class="p-info-wraper">
            <div class="info-left">
                <h4>Project: <?php echo $project->title; ?></h4>
                <p class="degination">Client: <?php echo $employers->display_name; ?></p>
            </div>
        </div>
        <p>Bids on: <span><?php echo date( 'F j, Y', strtotime( $proposal->post_date ) ); ?></span> | Total Bids:
            <span><?php echo $project->total_bids; ?></span></p>
        <a class="ie_btn" href="<?php echo $proposal->guid; ?>">View Bid</a>
    </div>
</div><!-- End .proposals_row -->