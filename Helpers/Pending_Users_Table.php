<?php


if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class Pending_Users_Table extends WP_List_Table {

	public function __construct( $args = array() ) {
		parent::__construct( $args );
	}

	public function set_data( $data ) {
		$this->items = $data;
	}

	public function get_columns() {
		return [
			'name'     => __( 'Name', ET_DOMAIN ),
			'email'    => __( 'Email', ET_DOMAIN ),
			'username' => __( 'Username', ET_DOMAIN ),
			'company'  => __( 'Company', ET_DOMAIN ),
			'status'   => __( 'Status', ET_DOMAIN ),
			'action'   => __( 'Action', ET_DOMAIN ),
		];
	}

	public function prepare_items() {
		$this->_column_headers = array( $this->get_columns() );
	}

	public function column_default( $item, $column_name ) {
		return $item[$column_name];
	}
}