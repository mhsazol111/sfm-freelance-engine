<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( "You can't access this file directly" );
}

$project_title     = isset( $project ) ? $project->post_title : '';
$project_url       = isset( $project ) ? get_permalink( $project->ID ) : '#';
$author            = get_userdata( $author_id );
$author_profile_id = get_user_meta( $author_id, 'user_profile_id', true );
$country           = get_the_terms( $author_profile_id, 'country' );
?>


    <div class="la_messages_container message_content" id="la_project_<?= $project->ID; ?>_<?= $author_id; ?>">

        <div class="m_c_row">
            <div class="thumb background_position" style="">
				<?php echo get_avatar( $author_id, 50 ); ?>
            </div>
            <div class="info">
                <h3><?php echo get_the_author_meta( 'display_name', $author_id ); ?></h3>
                <p><?php _e( $country[0]->name, ET_DOMAIN ); ?>, <?php echo get_the_author_meta( 'city_name', $author_id ); ?></p>
            </div>
            <div class="btn_div">
                <a class="ie_btn" href="<?= esc_url( $project_url ); ?>">
                    <i class="fa fa-check-circle-o"></i>
	                <?php
	                $current_language = get_locale();
	                if( $current_language == 'en_EN' ){
		                _e('Go to Workroom', ET_DOMAIN);
	                } elseif( $current_language == 'fr_FR' ){
		                _e('Aller à la salle de travail', ET_DOMAIN);
	                } else {
		                _e('Go to Workroom', ET_DOMAIN);
                    }
	                ?>
                </a>
            </div>
        </div><!-- End .m_c_row -->

		<?php
		$messages = isset( $messages ) ? $messages : [];
		foreach ( $messages as $message ) {
			include dirname( __FILE__ ) . '/ajax-single-message-item.php';
		}
		?>
    </div>
<?php //include_once dirname( __FILE__ ) . '/modals/author-profile.php'; ?>