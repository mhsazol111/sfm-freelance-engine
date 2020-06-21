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
                <h4><?php _e( 'Project:', ET_DOMAIN ) ?> <?php echo $project->title; ?></h4>
                <p class="degination"><?php _e( 'Client:', ET_DOMAIN ) ?> <?php echo $employers->display_name; ?></p>
            </div>
        </div>
        <p><?php _e( 'Bids on:', ET_DOMAIN ) ?> <span><?php echo date( 'F j, Y', strtotime( $proposal->post_date ) ); ?></span> | <?php _e( 'Total Bids:', ET_DOMAIN ) ?>
            <span><?php echo $project->total_bids; ?></span></p>
        <a class="ie_btn" href="<?php echo $proposal->guid; ?>"><?php _e( 'View Bid', ET_DOMAIN ) ?></a>
    </div>
</div><!-- End .proposals_row -->