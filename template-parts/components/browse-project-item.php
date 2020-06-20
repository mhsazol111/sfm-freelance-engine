<?php
$project  = Employer::get_project( get_the_ID() );
$employer = Employer::get_employer( $project->employer_id );
$originalDate = $project->project_deadline;
//pri_dump($employer);
?>

<div class="project_row">
    <div class="d_head">
        <div class="head_left">
            <h3><a href="<?php echo $project->url; ?>"><?php echo $project->title; ?></a></h3>
            <div class="e_nav">
                Posted on: <span><?php echo date( 'F j, Y', strtotime( $project->post_date ) ); ?></span> &nbsp;|&nbsp;
                Categories:
				<?php
				echo Employer::get_project_terms( $project->id, 'project_category', true, '', true );
				?> &nbsp;|&nbsp;
                Bids: <span><?php echo $project->total_bids ?? 0; ?></span>
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
					<?php echo Employer::get_project_terms( $project->id, 'skill', true, '', false ); ?>
                </div>
            </div>
        </div>
        <div class="head_right">
            <div class="freelancer_row">
                <div class="freelancer-top">
                    <div class="thumb_content">
                        <div class="thumb">
                            <img src="<?php echo $employer->et_avatar_url ?>" alt="<?php echo $employer->name; ?>">
                        </div>
                    </div>
                    <div class="person_info">
                        <h4><?php echo $employer->name; ?></h4>
                        <?php
                        $rating = $employer->rating_score;
                        //if( !empty( $rating ) ): ?>
                            <div class="rate-it fpp-rating" data-score="<?php echo $rating ?>"></div>
                        <?php //endif; ?>
                    </div>
                </div>
                <div class="freelancer_info">
                    <p><strong><i class="far fa-money-bill-alt"></i> Budget:</strong> <span>$<?php echo $project->et_budget; ?></span>
                    </p>
                    <p><strong><i class="far fa-clock"></i> Deadline:</strong> <span><?php echo $newDate = date("d-M-Y", strtotime($originalDate)); ?></span></p>
<!--                    <p><strong><i class="fas fa-user-check"></i> Hired So Far:</strong> <span>--><?php //echo $project->total_bids; ?><!--</span>-->
                    <p><strong><i class="far fa-check-circle"></i> Completed Project:</strong>
                        <span><?php echo Custom::query_to_post_count( Employer::get_projects( $project->id, 'complete' ) ); ?></span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div><!-- End .project_row -->