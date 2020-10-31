<?php
$fre_id          = get_the_author_meta( 'ID' );
$freelancer      = Freelancer::get_freelancer( $fre_id );
$profile_post_id = get_user_meta( $fre_id, 'user_profile_id', true );
$country         = get_the_terms( $profile_post_id, 'country' );
$languages       = get_the_terms( $profile_post_id, 'language' );
$language_list   = [];
if ( $languages ) {
	foreach ( $languages as $lang ) {
		$language_list[] = $lang->name;
	}
}
$language_list = implode( ' | ', $language_list );

$s_a_permalink   = $freelancer->slug;
$s_a_thumb_id    = $freelancer->et_avatar;
$s_a_thumb       = $freelancer->et_avatar_url;
$s_a_d_name      = $freelancer->display_name;
$s_a_designation = $freelancer->job_title;
$s_a_experience  = isset( $freelancer->et_experience ) ? $freelancer->et_experience : '';
$s_a_t_projects  = isset( $freelancer->total_projects_worked ) ? $freelancer->total_projects_worked : 0;
$s_a_rate        = $freelancer->daily_wage_rate;
$s_a_details     = $freelancer->describe_more;
$s_a_rating      = isset( $freelancer->rating_score ) ? $freelancer->rating_score : '';
?>

<div class="single-archive-profile-wrapper">
    <div class="s-a-left-thumbnail">
        <a href="<?php echo $s_a_permalink; ?>">
			<?php echo get_avatar( $fre_id, 150 ); ?>
        </a>
    </div>
    <div class="s-a-right-content">
        <h4><a href="<?php echo $s_a_permalink; ?>"><?php echo $s_a_d_name ?></a></h4>
        <h5><?php echo $s_a_designation; ?></h5>
        <p class="country-language">
			<?php echo $country ? '<strong>' . __( 'Country', ET_DOMAIN ) . ': </strong>' . __( $country[0]->name, ET_DOMAIN ) : '' ?><?php echo $language_list ? ', <strong>' . __( 'Languages', ET_DOMAIN ) . ': </strong>' . __( $language_list, ET_DOMAIN ) : '' ?>
        </p>
        <ul>
            <li class="s-a-rating">
                <span class="rate-it" data-score="<?php echo $s_a_rating; ?>"></span>
            </li>
            <li><span><?php echo intval( $s_a_t_projects ) . ' ' . __( 'projects worked', ET_DOMAIN ); ?></span></li>
            <li>
				<?php if ( $s_a_rate && $s_a_rate != 'agreed' ) : ?>
                    <span><strong>CHF <?php echo intval( $s_a_rate ) . ' /' . __( 'day', ET_DOMAIN ); ?></strong></span>
				<?php elseif ( $s_a_rate == 'agreed' ) : ?>
                    <span><strong><?php _e( 'To be agreed', ET_DOMAIN ); ?></strong></span>
				<?php else : ?>
                    <span><strong>CHF <?php echo intval( $s_a_rate ) . ' /' . __( 'day', ET_DOMAIN ); ?></strong></span>
				<?php endif; ?>
            </li>
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