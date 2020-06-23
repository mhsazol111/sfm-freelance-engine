<?php
$fre_id = get_the_author_meta( 'ID' );
$freelancer = Freelancer::get_freelancer( $fre_id );

$s_a_permalink = $freelancer->slug;
$s_a_thumb_id = $freelancer->et_avatar;
$s_a_thumb = $freelancer->et_avatar_url;
$s_a_d_name = $freelancer->display_name;
$s_a_designation = $freelancer->job_title;
$s_a_experience = isset($freelancer->et_experience) ? $freelancer->et_experience : '';
$s_a_t_projects = isset($freelancer->total_projects_worked) ? $freelancer->total_projects_worked : 0;
$s_a_rate = $freelancer->daily_wage_rate;
$s_a_details = $freelancer->describe_more;
$s_a_rating = isset($freelancer->rating_score) ? $freelancer->rating_score : '';
?>

<div class="single-archive-profile-wrapper">
    <div class="s-a-left-thumbnail">
        <a href="<?php echo $s_a_permalink; ?>">
            <img src="<?php echo wp_get_attachment_image_url($s_a_thumb_id, 'thumbnail'); ?>" alt="<?php echo $s_a_d_name; ?>">
        </a>
    </div>
    <div class="s-a-right-content">
        <h4><a href="<?php echo $s_a_permalink; ?>"><?php echo $s_a_d_name ?></a></h4>
        <h5><?php echo $s_a_designation; ?></h5>
        <ul>
            <li class="s-a-rating">
                <span class="rate-it" data-score="<?php echo $s_a_rating; ?>"></span>
            </li>
            <li><span><?php printf( __('%s projects worked' ,ET_DOMAIN), intval($s_a_t_projects) ); ?></span></li>
            <li><span><strong><?php printf( __('CHF %s /day' ,ET_DOMAIN), intval($s_a_rate) ); ?></strong></span></li>
        </ul>
        <div class="deccription">
            <p>
            <?php
                $str = strip_tags( $s_a_details );
                if ( strlen( $str ) > 400 ) {
                    $str = substr( $str, 0, 400 ) . '...';
                }
                echo $str;
            ?>
            </p>
        </div>
    </div>
</div>