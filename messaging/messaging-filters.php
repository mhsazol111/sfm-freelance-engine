<?php
if( ! defined( 'ABSPATH' ) ) die( "You can't access this file directly" );

/**
 * Add our message notification to the notification center.
 *
 * @param $content
 * @param $notify
 *
 * @return mixed
 */
function la_new_private_message_notification( $content, $notify ) {
	//type=la_private_message&amp;project=5169&amp;author=449
	$post_excerpt = str_replace( '&amp;', '&', $notify->post_excerpt );
	parse_str( $post_excerpt );

	if( isset( $type ) && isset( $project ) && isset( $author ) ) {
		if( 'la_private_message' == $type ) {
			$message_url = get_site_url() . '/messages/?a_id='. $author .'&p_id=' . $project;
			$message     = sprintf( __( 'You have a new message for %s', ET_DOMAIN ),
				   '<strong>'. get_the_title($project) . '</strong>');
			$content    .= '<a class="fre-notify-wrap" href="' . $message_url . '">
		                    <span class="notify-avatar"><i class="fa fa-exclamation-circle"></i></span>
		                    <span class="notify-info">' . $message . '</span>
		                    <span class="notify-time">' . sprintf( __( "%s on %s", ET_DOMAIN ), get_the_time( '', $notify->ID ), get_the_date( '', $notify->ID ) ) . '</span>
	                    </a>';
		}

	}
	return $content;
}
add_filter( 'fre_notify_item', 'la_new_private_message_notification', 10, 2 );