<?php
if( ! defined( 'ABSPATH' ) ) die( "You can't access this file directly" );

function la_debug( $object, $die = false ) {
	ob_start();
	print_r( $object );
	$me = ob_get_clean();
	file_put_contents( get_stylesheet_directory() . '/messaging/debug.log', $me);
	if($die) die();
}

/**
 * Get Field from options page.
 *
 * @param $name
 *
 * @return bool|string
 */
function get_messaging_option( $name ) {
	if( ! function_exists( 'get_field' ) ) return false;
	return get_field( $name, 'option' );
}

/**
 * Send Email to Specific Person
 * @param $to        string
 * @param $subject   string
 * @param $content   string
 * @param $ccToAdmin boolean
 */
function la_send_email( $to, $subject, $content, $ccToAdmin = false ) {
	$from_name = get_messaging_option( 'from_name' );
	$from_email = get_messaging_option( 'from_email' );
	$admin_email = get_option( 'admin_email' );
	$headers = array(
		"Content-Type: text/html; charset=UTF-8",
		"From: {$from_name} <{$from_email}>"
	);
	if( $ccToAdmin ) {
		$headers[] = "Cc: {$admin_email}";
	}
	wp_mail( $to, $subject, $content, $headers );
}

/**
 * Get formatted user name by user id.
 *
 * @param $userdata
 * @return string
 */
function get_username( $userdata ) {

	$user_name = $userdata->first_name . ' ' . $userdata->last_name;
	if( empty( $user_name ) || ' ' == $user_name ) {
		$user_name = $userdata->display_name;
	}
	return $user_name;
}

/**
 * Get formatted short user name by user id.
 *
 * @param $userdata
 * @return string
 */
function get_short_username( $userdata ) {

	$user_name = $userdata->first_name . ' ' . strtoupper( substr( $userdata->last_name, 0, 1 ) );
	if( empty( $user_name ) || ' ' == $user_name ) {
		$user_name = $userdata->display_name;
	}
	return $user_name . '.';
}

/**
 * Check if there any unread messages.
 * @param int $user_id
 * @param string $type
 *
 * @return int|array
 */
function get_message_notifications( $user_id = 0, $type = 'cm') {
	if ( ! is_user_logged_in() ) {
		return '';
	}
	if( ! $user_id ) {
		$user_id = get_current_user_id();
	}
	global $wpdb;
	$table = $wpdb->prefix . 'la_private_messages';

	if( ae_user_role() == EMPLOYER ) {
		$sql = $wpdb->prepare("SELECT ps.ID, ps.post_title, count(ps.ID) as `total` FROM  $table pm  
			LEFT JOIN $wpdb->posts ps 
			ON pm.project_id = ps.ID
			WHERE ps.`post_author` = %d 
			AND ps.`post_type` = 'project' 
			AND pm.`status` = 'unread'
			GROUP BY ps.ID 
			ORDER BY pm.send_date;
		", $user_id);
	} else {
		$sql = $wpdb->prepare("SELECT ps.ID, ps.post_title, count(ps.ID) as `total` FROM  $table pm 
			LEFT JOIN $wpdb->posts ps ON pm.project_id = ps.ID 
			WHERE pm.`author_id` = %d 
			AND pm.`sender_id` <> %d 
			AND ps.`post_type` = 'project' 
			AND pm.`status` = 'unread' 
			GROUP BY ps.ID 
			ORDER BY pm.send_date;",
			$user_id, $user_id);
	}
	$qry = $wpdb->get_results( $sql );
	if( is_array( $qry) && count ( $qry ) > 0 ) {
		return $qry;
	} else {
		return [];
	}
}

/**
 * Create a New notification for user
 *
 * @param $args array [author, project, notify_to]
 *
 * @return bool|int|WP_Error
 */
function send_message_notification( $args ) {
    if( ! isset( $args['notify_to'] ) && ! isset( $args['project'] ) ) {
        return false;
    }
	$author = isset( $args['author'] ) ? $args['author'] : 0;
    $project_title = get_the_title( $args['project'] );
	//add notification
	$notification_array = array(
		'post_title'   => 'You have a new message for ' .$project_title,
		'post_content' => 'type=la_private_message&amp;project=' . $args['project'] . '&author=' . $author,
		'post_author'  => isset( $args['notify_to'] ) ?  $args['notify_to'] : 0,
		'post_excerpt' => 'type=la_private_message&amp;project=' . $args['project'] . '&author=' . $author,
		'post_type'    => 'notify',
		'post_status'  => 'publish'
	);

	$status = wp_insert_post( $notification_array );
	return $status;
}

/**
 * Get user's message titles
 * @param int $user_id
 *
 * @return array|object|null
 */
function get_user_messages( $user_id = 0  ) {
	if(! $user_id ) {
		$user_id = get_current_user_id();
	}
	global $wpdb;
	$msg_table = $wpdb->prefix . 'la_private_messages';
    $current_user = get_current_user_id();
	if( ae_user_role() == EMPLOYER ) {
		$sql = $wpdb->prepare("
            SELECT ps.ID, x.id, ps.post_title, 
            IF(
                x.`status` = 'unread' AND x.sender_id = %d, 'read', x.`status`
                ) AS `status`, 
            x.author_id, x.sender_id AS sender, x.send_date
            FROM (SELECT * FROM {$msg_table} ORDER BY id desc) x
            LEFT JOIN {$wpdb->posts} ps 
            ON ps.ID = x.project_id
            WHERE ps.post_author = %d
            GROUP BY x.author_id
            ORDER BY x.id DESC
        ", $current_user, $user_id );
		// echo $sql;
	} else {
		$sql = $wpdb->prepare("SELECT ps.ID, ps.post_title, pm.status2 as `status`, pm.author_id, pm.sender_id as sender 
            FROM (
                    SELECT id, author_id, sender_id, project_id, IF(status = 'unread' AND sender_id = %d, 'read', status) as status2 FROM {$msg_table}
                    WHERE 1
                    ORDER BY send_date DESC
                ) pm 
			LEFT JOIN $wpdb->posts ps 
			ON pm.project_id = ps.ID 
			WHERE ps.`post_type` = 'project' 
			AND pm.author_id = %d
			GROUP BY ps.ID, pm.author_id  
			ORDER BY pm.id DESC;",
			$current_user, $user_id);
	}

	$qry = $wpdb->get_results( $sql );
	if( is_array( $qry) && count ( $qry ) > 0 ) {
		return $qry;
	} else {
		return [];
	}
}

/**
 * Get project messages
 * @param int $project_id
 * @param int $author_id
 * @param bool $unread
 * @return array
 */
function get_project_messages ( $project_id, $author_id = 0, $unread = false ) {
    $current_user = get_current_user_id();
	if( ! $author_id ) {
		$author_id = $current_user;
	}
	global $wpdb;
	$msg_table = $wpdb->prefix . 'la_private_messages';

	$sql = $wpdb->prepare("
	    SELECT * FROM $msg_table WHERE project_id = %d AND author_id = %d ORDER BY send_date;
	", $project_id, $author_id);
	if( $unread ) {
		$sql = $wpdb->prepare("
	    SELECT * FROM $msg_table 
	    WHERE project_id = %d 
	      AND author_id = %d 
	      AND sender_id <> %d 
	      AND `status` = 'unread' 
	    ORDER BY send_date;
	", $project_id, $author_id, $current_user);
    }
	$projects = $wpdb->get_results( $sql );
	if( is_array( $projects ) && count ( $projects ) > 0 ) {
		return $projects;
	} else {
		return [];
	}
}

/**
 * Mark project as read
 * @param $project_id integer
 * @param $author_id integer
 * @return void|boolean
 */
function la_mark_project_read( $project_id, $author_id ) {
	if( empty( $project_id ) || empty( $author_id ) ) {
		return false;
	}
	$args = array(
		'project_id' => $project_id,
		'author_id' => $author_id,
	);
	$pm = new LAPrivateMessaging();
	$status = $pm->change_message_status($args);
	return $status;
}

/**
 * Generate Ratings based on given number.
 * @param float $rating
 * @param integer $max
 * @return string Generated Ratings html.
 */
function generate_ratings( $rating, $max = 5 ) {
	$rate = number_format($rating, '1');
	$blankStar = $max - $rate;
	$fullStar = floor( $rating );
	$halfStar = ( $fullStar + floor( $blankStar ) ) < $max;
	// Full star: 
	// Half star: 
	// Blank star: 
	ob_start(); ?>
	<span class="la_ratings" title="<?php echo $rate; ?>">
		<?php
		echo str_repeat('<i class="fa fa-star"></i>', $fullStar);
		if ( $halfStar ) echo '<i class="fa fa-star-half-full"></i>';
		echo str_repeat('<i class="fa fa-star-o"></i>', floor( $blankStar ));
		?>
	</span>
	<?php
	return ob_get_clean();
}

/**
 * Get User rating count
 * @param $user_ID integer
 * @return integer
 */
function get_gf_user_ratings($user_ID) {
	$rating        = Fre_Review::employer_rating_score( $user_ID );
	if ( fre_share_role() || ae_user_role( $user_ID ) == FREELANCER ) {
		$rating        = Fre_Review::freelancer_rating_score( $user_ID );
	}
	return isset( $rating['rating_score'] ) && !empty( $rating['rating_score'] ) ? $rating['rating_score'] : 0;
}

/**
 * Get Rating Title [Excellent, Good, Moderate, Bad and Very Bad]
 * @param $rating
 *
 * @return string|void
 */
function get_rating_title( $rating ) {
	$rating_title = 'Not yet rated!';
	if( $rating >= 4.5 ) {
		$rating_title = __('Excellent');
	}
	else if( $rating > 2.5 && $rating < 4.5 ) {
		$rating_title = __('Good');
    }
	else if( $rating >= 1.5 && $rating <= 2.5 ) {
		$rating_title = __('Moderate');
    }
	else if( $rating >= 0.5 && $rating < 1.5 ) {
		$rating_title = __('Bad');
    }
	else if( $rating > 0 && $rating < 0.5 ) {
		$rating_title = __('Very Bad');
    }
	return $rating_title;
}

/**
 * Get Latest Feedback from client.
 * @param $freelancer_id
 * @param string $type
 * @param int $limit
 *
 * @return array
 */
function get_latest_feedback( $freelancer_id, $type= 'freelancer', $limit = 5 ) {
	global $wpdb;
    $sql = $wpdb->prepare("SELECT p.ID, M.meta_key, M.meta_value
                FROM $wpdb->posts as p
                LEFT JOIN $wpdb->postmeta AS M
                ON M.post_id = p.ID
                WHERE p.post_author = %d
                AND (M.meta_key = 'rating_score' 
                    OR M.meta_key = 'rating_feedback'
                    OR M.meta_key = 'rating_project_id' ) 
                ",
            $freelancer_id
            );
	$results = $wpdb->get_results( $sql );
	if( false === $results ){
	    return [];
    }
	$new_results = [];
	if( count( $results ) > 0 ) {
	    foreach ( $results as $result ) {
	        $new_results[$result->ID][$result->meta_key] = $result->meta_value;
        }
    }
	return $new_results;
}

/**
 * Get Author Tag name
 * @param $author object
 * @return string
 */
function get_author_tag_name ( $author ) {
    $profile_title = get_user_meta( $author->ID, 'et_professional_title', true );
    if( empty( $profile_title ) ) {
        return __( 'Author', 'linkable' );
    }
	return $profile_title;
}

/**
 * Get Content Marketer Tag Name
 * @param $cm object
 * @return string
 */
function get_cm_tag_name( $cm ) {
	return ucfirst( ae_user_role($cm->ID) );
}

/**
 * Get DA from Moz API
 * @param $domain
 * @return mixed
 */
function get_da_from_moz_api( $domain ) {
	/* MOZ API CALL */

	// Get your access id and secret key here: https://moz.com/products/api/keys
	$accessID  = "mozscape-d19b96ee83";
	$secretKey = "c8d7a78da00e772bc8257143f9d38972";

	// Set your expires times for several minutes into the future.
	// An expires time excessively far in the future will not be honored by the Mozscape API.
	$expires = time() + 300;

	// Put each parameter on a new line.
	$stringToSign = $accessID . "\n" . $expires;

	// Get the "raw" or binary output of the hmac hash.
	$binarySignature = hash_hmac( 'sha1', $stringToSign, $secretKey, true );

	// Base64-encode it and then url-encode that.
	$urlSafeSignature = urlencode( base64_encode( $binarySignature ) );

	// Specify the URL that you want link metrics for.


	// Add up all the bit flags you want returned.
	// Learn more here: https://moz.com/help/guides/moz-api/mozscape/api-reference/url-metrics
	$cols = "68719476736";

	// Put it all together and you get your request URL.
	// This example uses the Mozscape URL Metrics API.
	$requestUrl = "http://lsapi.seomoz.com/linkscape/url-metrics/" . urlencode( $domain ) . "?Cols=" . $cols . "&AccessID=" . $accessID . "&Expires=" . $expires . "&Signature=" . $urlSafeSignature;

	// Use Curl to send off your request.
	$options = array(
		CURLOPT_RETURNTRANSFER => true
	);

	$ch = curl_init( $requestUrl );
	curl_setopt_array( $ch, $options );
	$content = curl_exec( $ch );
	curl_close( $ch );

	$b                = json_decode( $content, true );
	$domain_authority = $b['pda'];
	return $domain_authority;
}

/**
 * Get Pricing by DA
 *
 * @param $da
 * @param $domain
 * @param $follow
 * @return boolean|array
 */
function get_pricing_from_da ( $da, $domain, $follow ) {

	$price_from_da     = 0; //price based on pricing grid on options page
	$follow_multiplier = 1;
	$commission        = get_field( 'commission_rate_%', 'option' );

	//get multipliers
	if ( have_rows( 'follow_type_calculation', 'option' ) ):
        while ( have_rows( 'follow_type_calculation', 'option' ) ):
            the_row();
			// vars
			$no_follow_mult = get_sub_field( 'nofollow_multiplier' );
			$do_follow_mult = get_sub_field( 'dofollow_multiplier' );
		endwhile;
	endif;

	//get price from grid based on DA
	$override_exists = false;

	//first see if domain has an override
	if ( have_rows( 'domain_overrides', 'option' ) ) {
		while ( have_rows( 'domain_overrides', 'option' ) ): the_row();
			$domain_name = get_sub_field( 'domain_override_field' );
			$domain_name = parse_url( $domain_name );
			$domain_name = $domain_name['host'];
			$domain_name = str_replace( 'www.', '', $domain_name );
			$domain_name = strtolower( $domain_name );

			//echo $domain_name;

			$entered_domain = $domain;
			$entered_domain = parse_url( $entered_domain );
			$entered_domain = $entered_domain['host'];
			$entered_domain = str_replace( 'www.', '', $entered_domain );
			$entered_domain = strtolower( $entered_domain );

			//echo $entered_domain;

			if ( $domain_name == $entered_domain ) {
				$override_exists = true;
				//here we need to get the price
				$price_from_da = get_sub_field( 'price' );
				break;
			}
		endwhile;
	}

	if ( $override_exists ) {
	    // Nothing
	} else {
		if ( have_rows( 'domain_authority_pricing_schedule', 'option' ) ):
            while ( have_rows( 'domain_authority_pricing_schedule', 'option' ) ): the_row();
				// vars
				$low   = get_sub_field( 'range_low' );
				$high  = get_sub_field( 'range_high' );
				$price = get_sub_field( 'dollar_value' );

				if ( ( $da >= $low ) && ( $da <= $high ) ) {
					$price_from_da = $price;
				}
			endwhile;
		endif;
	}

	//get domain authority selection
    if ( $follow == "NoFollow" ) {
        $follow_multiplier = $no_follow_mult;
    } else {
        $follow_multiplier = $do_follow_mult;
    }

    // Calc
	$owner_price = $price_from_da * $follow_multiplier;
	$paid_price  = ( 1 - ( $commission / 100 ) ) * $owner_price;
	$paid_price  = number_format( (float) $paid_price, 2, '.', '' );

	return ['owner_price' => $owner_price, 'paid_price' => $paid_price ];

}