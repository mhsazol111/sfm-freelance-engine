<?php
if( ! defined( 'ABSPATH' ) ) die( "You can't access this file directly" );
// WP_List_Table is not loaded automatically so we need to load it in our application
if( ! class_exists( 'WP_List_Table' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}
/**
 * List Table for PrivateMessage
 */

class PM_ListTable extends WP_List_Table {
	/**
	 * @var $db
	 */
	private $db;
	/**
	 * @var $pm_table
	 */
	public $pm_table;
	/**
	 * PM_ListTable constructor.
	 *
	 * @param array $args
	 */
	public function __construct( $args = array() ) {
		parent::__construct( $args );
		global $wpdb;
		$this->db = $wpdb;
		$this->pm_table = $wpdb->prefix . 'la_private_messages';
	}

	/**
	 * Prepare the items for the table to process
	 *
	 * @return Void
	 */
	public function prepare_items()
	{
		$columns = $this->get_columns();
		$hidden = $this->get_hidden_columns();
		$sortable = $this->get_sortable_columns();
		$this->_column_headers = array($columns, $hidden, $sortable);
		$data = $this->table_data();
		$this->items = $data;
	}
	/**
	 * Override the parent columns method. Defines the columns to use in your listing table
	 *
	 * @return Array
	 */
	public function get_columns()
	{
		$columns = array(
			'project_id' => 'Project',
			'sender_id'  => 'Sender',
			'author_id'  => 'Author',
			'message'    => 'Message',
			'status'     => 'Status',
			'send_date'  => 'Send Date'
		);
		return $columns;
	}
	/**
	 * Define which columns are hidden
	 *
	 * @return Array
	 */
	public function get_hidden_columns() {
		return array();
	}
	/**
	 * Define the sortable columns
	 *
	 * @return Array
	 */
	public function get_sortable_columns() {
		return array(
			'send_date' => array('send_date', false),
			'status' => array('status', false)
		);
	}
	/**
	 * Get the table data
	 *
	 * @return Array
	 */
	private function table_data() {
		global $wpdb;
		$per_page = 10;
		$table_name = $this->pm_table;

		$paged = isset($_REQUEST['paged']) ? max(0, intval($_REQUEST['paged'] - 1) * $per_page) : 0;
		$orderby = (isset($_REQUEST['orderby']) && in_array($_REQUEST['orderby'], array_keys($this->get_sortable_columns()))) ? $_REQUEST['orderby'] : 'send_date';
		$order = (isset($_REQUEST['order']) && in_array($_REQUEST['order'], array('asc', 'desc'))) ? $_REQUEST['order'] : 'asc';

		$qry = "SELECT ms.* FROM $table_name ms 
    			LEFT JOIN $wpdb->posts ps ON ms.project_id = ps.ID 
    			";
		$tot_qry = "SELECT COUNT(id) FROM $table_name";
		// Search check
		if( isset( $_REQUEST['s'] ) && ! empty( $_REQUEST['s'] )){
			$search_key = sanitize_text_field( $_REQUEST['s'] );
			$qry .= "WHERE (ms.`message` LIKE '%{$search_key}%' 
			OR ps.post_title LIKE '%{$search_key}%') ";
		}
		// Filter Check
		if( isset( $_REQUEST['filter_status'] ) && ! empty( $_REQUEST['filter_status'] ) ) {
			$filter_status = strtolower( sanitize_text_field( $_REQUEST['filter_status'] ) );
			$qry .= "WHERE ms.`status` = '$filter_status' ";
			$tot_qry = "SELECT COUNT(id) FROM $table_name WHERE `status` = '$filter_status';";
		}
		$qry .= "ORDER BY $orderby $order LIMIT $per_page OFFSET $paged";
		// Full Data
		$data = $this->db->get_results( $qry, ARRAY_A );
		$total_items = $this->db->get_var( $tot_qry );



		$this->set_pagination_args(array(
			'total_items' => $total_items,
			'per_page' => $per_page,
			'total_pages' => ceil($total_items / $per_page)
		));

		return $data;
	}
	/**
	 * Define what data to show on each column of the table
	 *
	 * @param  $item        array  - Data
	 * @param  $column_name string - Current column name
	 *
	 * @return Mixed
	 */
	public function column_default( $item, $column_name )
	{
		switch( $column_name ) {
			case 'project_id':
				$project_id = $item[ $column_name ];
				$project = get_post( $project_id );
				return '<a href="'. get_permalink( $project->ID ).'" target="_blank"><strong>' . $project->post_title . '</strong></a>';
			case 'sender_id':
				$sender = get_userdata( $item[ $column_name ] );
				return get_username( $sender );
			case 'author_id':
				$author_id = $item[ $column_name];
				$author = get_userdata( $author_id );
				return get_username( $author );
			case 'message':
				$msg = stripslashes( wp_strip_all_tags( $item[ $column_name ], true) );
				$url = admin_url('admin.php?page=la-private-messages') . '&message_id=' . $item['id'];
				return '<a href="'.$url.'">' . substr( $msg, 0, 50 ) . '...</a>';
			case 'status':
				return strtoupper( $item[ $column_name ] );
			case 'send_date':
				return date('d M, Y @ h:i a', strtotime( $item[ $column_name ] ) );
			default:
				return '' ;
		}
	}
	/**
	 * Allows you to sort the data by the variables set in the $_GET
	 *
	 * @return Mixed
	 */
	private function sort_data( $a, $b )
	{
		// Set defaults
		$orderby = 'send_date';
		$order = 'asc';
		// If orderby is set, use this as the sort column
		if(!empty($_GET['orderby']))
		{
			$orderby = $_GET['orderby'];
		}
		// If order is set use this as the order
		if(!empty($_GET['order']))
		{
			$order = $_GET['order'];
		}
		$result = strcmp( $a[$orderby], $b[$orderby] );
		if($order === 'asc')
		{
			return $result;
		}
		return -$result;
	}

	/**
	 * Added filters.
	 * @param string $which
	 */
	protected function extra_tablenav( $which ) { ?>
		<div class="actions alignleft">
			<form method="get">
			<select name="filter_status" id="filter_author">
				<option value=""><?php esc_html_e('Show All Status', ET_DOMAIN ); ?></option>
				<option value="read" <?= isset( $_REQUEST['filter_status'] ) && $_REQUEST['filter_status'] == 'read' ? 'selected' : ''; ?>><?php esc_html_e('Read', ET_DOMAIN ); ?></option>
				<option value="unread" <?= isset( $_REQUEST['filter_status'] ) && $_REQUEST['filter_status'] == 'unread' ? 'selected' : ''; ?>><?php esc_html_e('Unread', ET_DOMAIN ); ?></option>
			</select>
				<?php submit_button( __('Filter', ET_DOMAIN), 'button', 'filter_submit', false ); ?>
				<input type="hidden" name="page" value="<?= esc_attr($_REQUEST['page']) ?>"/>
			</form>
		</div>
		<?php
	}

	public function single_item ( $item ) {
		$table_name = $this->pm_table;
		$itemObj = $this->db->get_results(
			$this->db->prepare("SELECT * FROM $table_name 
			WHERE id = %d",
				$item));
		return $itemObj;
	}
}