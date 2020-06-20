<?php
if( ! defined( 'ABSPATH' ) ) die( 'No kidding!' );

$extraClass = isset( $extraClass ) ? $extraClass : '';
if( $author->ID == $message->sender_id ){
	$sender = $author;
} else {
	$sender = get_userdata( $message->sender_id );
}
$rating = get_gf_user_ratings( $sender->ID );
?>
<div class="m_c_row <?= $extraClass; ?>">

    <div class="thumb background_position">
	    <?php echo get_avatar( $sender->ID, 50 ); ?>
    </div>
    <div class="info">
        <h3><?php echo get_the_author_meta( 'display_name', $sender->ID ); ?></h3>
        <?php
			$time = mysql2date('U', $message->send_date, false);
			$send_time = date( 'h:ia @ M d', $time );
			$send_time = str_replace( '@', 'on', $send_time);
		?>
        <p class="time"><?php echo $send_time; ?></p>
        <?php echo wpautop( stripslashes( $message->message ) ); ?>
    </div>

    <hr>

	
</div>