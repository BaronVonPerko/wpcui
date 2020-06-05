<?php

namespace PerkoCustomizerUI\Tables;

if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class SectionManagerTable extends \WP_List_Table {
	private $sections;

	public function __construct( $sections ) {
		$this->sections = $sections;

		parent::__construct( [
			'singular' => 'Section',
			'plural'   => 'Sections',
			'ajax'     => false
		] );
	}

	public function get_columns() {
		return [
			'title'    => 'Title',
			'priority' => 'Priority',
			'visible'  => 'Visible'
		];
	}

	public function prepare_items() {
		$columns               = $this->get_columns();
		$hidden                = [];
		$sortable              = [];
		$this->_column_headers = [ $columns, $hidden, $sortable ];
		$this->items           = $this->sections;
	}

	function column_default( $item, $column_name ) {
		switch ( $column_name ) {
			case 'title':
				return $item->title;
			case 'priority':
				return $item->priority;
			default:
				return true;
		}
	}
}