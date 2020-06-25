<?php
if( ! defined( 'ABSPATH' ) ) die( "You can't access this file directly" );
require_once dirname( __FILE__ ) . '/PM_ListTable.php';
/**
 * Class LAPrivateMessaging
 * @package LAPrivateMessaging
 * @author Ainal Haq
 * @since version 1.0.92.
 */
class LAPrivateMessaging{
	/**
	 * @var wpdb
	 */
	private $db;
	/**
	 * @var string
	 */
	public $tbl_messages;
	/**
	 * LAPrivateMessaging constructor.
	 */
	public function __construct() {
		global $wpdb;
		$this->db = $wpdb;
		$this->tbl_messages = $wpdb->prefix . 'la_private_messages';

		if( is_admin() ) {
			// Create Table if not exits
			$this->create_db();
			// Action for Admin
			add_action( 'admin_menu', array( $this, 'create_menu_page' ) );
			add_action( 'acf/init', array( $this, 'create_option_page' ) );
		}
		// Adding Actions
		add_action( 'wp_enqueue_scripts', array( $this, 'load_assets') );
		//Enqueue script style in messaging page
		add_action( 'wp_enqueue_scripts', array( $this, 'load_assets_for_dashboard') );
		// Ajax: Message reply from author or CM
		add_action( 'wp_ajax_la_submit_reply_message', array( $this, 'la_submit_reply_message') );
		add_action( 'wp_ajax_nopriv_la_submit_reply_message', array( $this, 'la_submit_reply_message') );
	}

	/**
	 * Create necessary tables for Private Messaging
	 */
	private function create_db() {
		$table_name = $this->tbl_messages;
		$charset_collate = $this->db->get_charset_collate();
		$table_exists = $this->db->get_var( "SHOW TABLES LIKE '{$table_name}'" );
		if( $table_exists !== $table_name ) {
			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			$sql = "CREATE TABLE " . $table_name ." ( 
				id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY, 
				project_id INT(11) NOT NULL, 
			    author_id INT(11) NOT NULL, 
			    sender_id INT(11) NOT NULL, 
			    message TEXT, 
			    status ENUM('read', 'unread', 'delete') DEFAULT 'unread', 
			    send_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, 
			    read_date TIMESTAMP DEFAULT '0000:00:00 00:00' 
			) " . $charset_collate . ";";
			dbDelta( $sql );
		}
	}

	/**
	 * Load JavaScripts and Styles for the frontend.
	 */
	public function load_assets(){
		wp_enqueue_style( 'highlight_textarea', get_stylesheet_directory_uri() . '/messaging/assets/highlight_textarea.css' );
		wp_enqueue_script( 'highlight_textarea', get_stylesheet_directory_uri() . '/messaging/assets/highlight_textarea.js', array('jquery'), null, true );
		$popupMessage = FREELANCER == ae_user_role() ? get_messaging_option( 'popup_warning_for_authors' ) : get_messaging_option( 'popup_warning_for_cm' );
		wp_localize_script('highlight_textarea', 'la_pm', array(
			'popupMessage' => $popupMessage
		));
	}

	/**
	 * Load JavaScripts and Styles for the frontend.
	 */
	public function load_assets_for_dashboard(){
		if( is_page_template( 'page-messages.php') ) {
			wp_enqueue_style( 'messages_dashboard', get_stylesheet_directory_uri() . '/messaging/assets/messages.css' );
			wp_enqueue_script( 'messages_dashboard', get_stylesheet_directory_uri() . '/messaging/assets/messages.js', array('jquery'), null, true);
			wp_localize_script( 'messages_dashboard', 'pmObj', array(
				'ajax_url' => admin_url( 'admin-ajax.php' )
			));
		}
	}

	/**
	 * Create Private Messages Menu
	 */
	public function create_menu_page() {
		add_menu_page(
			__( 'Private messages', ET_DOMAIN ),
			'Private Messages',
			'manage_options',
			'la-private-messages',
			array( $this, 'private_message_view' ),
			'dashicons-format-status',
			6
		);
	}

	/**
	 * Private Messages View
	 */
	public function private_message_view() {
		$pm_list_table = new PM_ListTable();
		$pm_list_table->prepare_items();
		include_once dirname( __FILE__ ) . '/parts/private-messages.php';
	}

	/**
	 * Create settings page for Private Message
	 * ACF is required to show this page
	 */
	public function create_option_page() {
		// Check function exists.
		if( !function_exists('acf_add_options_page') ) return;
		// register options page.
		$option_page = acf_add_options_sub_page(array(
			'page_title'    => __('Private Message Settings'),
			'menu_title'    => __('Private Message Settings'),
			'menu_slug'     => 'private-message-settings',
			'parent_slug'   => 'la-private-messages',
			'capability'    => 'edit_posts',
			'redirect'      => false
		));
	}

	/**
	 * Create new message
	 * @param $args array of message_object project_id, author_id, sender_id, message
	 * @param $raw_msg bool
	 * @return boolean|integer
	 */
	public function create_message( $args, $raw_msg = false ) {
		$project_id = isset( $args['project_id'] ) ? sanitize_text_field( $args['project_id'] ) : '';
		$author_id = isset( $args['author_id'] ) ? sanitize_text_field( $args['author_id'] ) : '';
		$sender_id = isset( $args['sender_id'] ) ? sanitize_text_field( $args['sender_id'] ) : '';
		$message = isset( $args['message'] ) ? sanitize_textarea_field( $args['message'] ) : '';
		if($raw_msg){
			$message = isset( $args['message'] ) ? $args['message'] : '';
		}
		// If required fields are missing return
		if( empty( $project_id ) || empty( $author_id ) || empty( $sender_id ) || empty( $message ) ) {
			return false;
		}
		$data = [
			'project_id' => $project_id,
			'author_id'  => $author_id,
			'sender_id'  => $sender_id,
			'message'    => $message,
			'send_date'  => current_time( 'mysql' )
		];
		$status = $this->db->insert(
			$this->tbl_messages,
			$data,
			[ '%d', '%d', '%d', '%s', '%s' ]
		);

		if( false === $status ) {
			return false;
		} else {
			$last_id = $this->db->insert_id;
			do_action( 'la_inquiry_message_saved', $data, $last_id);
			return $last_id;
		}
	}

	public function change_message_status( $args, $status = 'read' ) {
		if( ! is_user_logged_in() ) {
			return false;
		}
		$project_id = isset( $args['project_id'] ) ? sanitize_text_field( $args['project_id'] ) : '';
		$author_id = isset( $args['author_id'] ) ? sanitize_text_field( $args['author_id'] ) : '';
		// If required fields are missing return
		if( empty( $project_id ) || empty( $author_id ) || ! in_array( $status, ['read', 'unread', 'delete']) ) {
			return false;
		}
//		$data = [ 'status' => $status ];
//		$where = [ 'project_id' => $project_id, 'author_id' => $author_id ];
//		$status = $this->db->update( $this->tbl_messages, $data, $where, ['%s'], ['%d', '%d'] );
		$current_user = get_current_user_id();
		$sql = $this->db->prepare(
			"UPDATE $this->tbl_messages 
					SET `status` = %s 
					WHERE `project_id` = %d AND 
					author_id = %d AND sender_id <> %d;",
			$status, $project_id, $author_id, $current_user
		);
		$return = $this->db->query( $sql );
		return $return;
	}

	public function la_submit_reply_message() {
		header( 'Content-Type: application/json' );
		$data = $_POST;
		if( ! wp_verify_nonce( $data['reply_nonce'], '_la_message_reply' ) ) {
			echo 'Check if you are in right place, please reload the page and try again.';
			die();
		}
		$project_id = isset( $data['project_id'] ) ? sanitize_text_field( $data['project_id'] ) : '';
		$author_id = isset( $data['author_id'] ) ? sanitize_text_field( $data['author_id'] ) : '';
		$reply_message = isset( $data['reply_message'] ) ? sanitize_textarea_field( $data['reply_message'] ) : '';
		if( empty( $project_id ) || empty( $author_id ) || empty( $reply_message ) ) {
			echo "Required field is empty, please try again from the right page!";
			die();
		}
		do_action( 'la_inquiry_message_submit', $project_id, $reply_message, $author_id  );
		echo wp_json_encode([
			'project_id' => $project_id,
			'author' => $author_id
		]);
		die();
	}
}
// Init Core
function la_load_private_messaging() {
	new LAPrivateMessaging();
}
la_load_private_messaging();