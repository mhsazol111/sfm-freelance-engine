<?php
global $wpdb;
$messages          = [];
$msg_table         = $wpdb->prefix . 'la_private_messages';

if ( USER_ROLE == 'freelancer' ) {
	$sql_query = $wpdb->prepare( "
        SELECT * FROM {$msg_table} 
        WHERE author_id = %d 
        AND sender_id <> %d  
        ORDER BY send_date DESC LIMIT 3", get_current_user_id(), get_current_user_id()
	);
	$messages  = $wpdb->get_results( $sql_query );
} else {
	$sql_query = $wpdb->prepare( "
        SELECT {$msg_table}.ID,project_id,author_id,sender_id,message,send_date,read_date FROM {$msg_table}
        LEFT JOIN {$wpdb->posts}
        ON {$wpdb->posts}.ID = {$msg_table}.project_id
        WHERE {$wpdb->posts}.post_author = %d
        AND {$msg_table}.sender_id <> %d
        ORDER BY send_date DESC LIMIT 3", get_current_user_id(), get_current_user_id()
	);
	$messages  = $wpdb->get_results( $sql_query );
}

if ( $messages ) :

	foreach ( $messages as $m ) :
		$user = get_userdata( $m->sender_id );
		$time      = mysql2date( 'U', $m->send_date, false );
		$send_time = date( 'h:ia @ M d', $time );
		$send_time = str_replace( '@', 'on', $send_time );
		?>
        <div class="latest_messages_row">
            <div class="thumb_content">
                <div class="thumb align_center background_position" style="border-radius: 50%; overflow: hidden">
					<?php echo get_avatar( $m->sender_id, 50 ); ?>
                </div>
            </div>
            <div class="m_info">
                <h4 class="title"><?php echo $user->display_name; ?></h4>
                <p>
                    <?php
                    $str = $m->message;
                    if ( strlen( $str ) > 80 ) {
	                    $str = substr( $str, 0, 80 ) . '...';
                    }
                    echo $str;
                    ?>
                </p>
                <span><?php echo $send_time; ?></span>
            </div>
        </div>
	<?php
	endforeach;
else :
	?>
    <h5><?php _e( 'No new message found!', ET_DOMAIN ); ?></h5>
<?php endif; ?>
