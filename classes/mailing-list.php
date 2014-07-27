<?php
/**
 * This model manages all functionality associated with the subscriber
 * mailing list.
 *
 * Required models: Database, Encryption
 *
 * @author Colton James Wiscombe <colton@hazardmediagroup.com>
 * @copyright 2014 Hazard Media Group LLC
 * @version 1.0
 */

class Mailing_List {

	public static $table = array(
		'name' => 'mailing_list',
		'prefix' => 'ml',
		'version' => '1.0',
		'structure' => array(
			'email' => array( 'VARCHAR(255)', true ),
			'status' => array( 'VARCHAR(255)', false, 'active' ),
			'timestamp' => array( 'TIMESTAMP' )
		)
	);

	public function __construct() {

		// Run setup
		$this->setup_mailing_list();

		// Run Wordpress hooks
		$this->wp_hooks();

	}

	protected function setup_mailing_list() {

		// Generate encryption key
		if( !get_option( 'mailing_list_key' ) ) {
			$rand = rand(10000000, 999999999);
			$key = Encryption::encrypt( $rand );
			$key = str_replace( '/', '_', $key );
			$key = str_replace( '+', '_', $key );
			$key = str_replace( '=', '_', $key );
			add_option( 'mailing_list_key', $key );
		}

		// Install mailing list table
		Database::install_table( Mailing_List::$table );

	}

	protected function wp_hooks() {

		// Run mailing list setup
		add_action( 'admin_menu', array( &$this, 'register_admin_menu' ) );

	}

	public function register_admin_menu() {

		add_menu_page( 'Mailing List', 'Mailing List', 'manage_options', 'mailing_list', array( &$this, 'mailing_list_admin_menu' ), '', 100 );

	}

	public function mailing_list_admin_menu() {

		// Update the status of checked rows in the mailing list view
		$this->update_mailing_list();

		$data = Database::get_results( Mailing_List::$table, array( 'id', 'email', 'status', 'timestamp' ) );
		require_once VIEWS_PATH . 'admin/mailing-list.php';

	}

	public function update_mailing_list() {

		// Retrieve action to be taken
		if( !empty( $_GET['action1'] ) ) {
			$action = $_GET['action1'];
		} elseif( !empty( $_GET['action2'] ) ) {
			$action = $_GET['action2'];
		} else {
			$action = '';
		}

		// Execute action
		if( !empty( $action ) ) {
			$selected = ( !empty( $_GET['ckd'] ) ) ? $_GET['ckd'] : array();
			foreach( $selected as $row_id ) {
				switch( $action ) {

					case 'active' :
						Database::update_row( Mailing_List::$table, 'id', $row_id, array( 'status' => 'active' ) );
						break;

					case 'trash' :
						Database::update_row( Mailing_List::$table, 'id', $row_id, array( 'status' => 'trash' ) );
						break;

					case 'delete' :
						Database::delete_row( Mailing_List::$table, 'id', $row_id );
						break;

				}
			}
		}

	}

	public function unsubscribe( $email ) {

		if( empty( $email ) )
			return false;

		$data = Database::get_results( Mailing_List::$table, array( 'id', 'email' ) );

		foreach( $data as $row => $col ) {
			if( $col['email'] == $email ) {
				Database::delete_row( Mailing_List::$table, 'id', $col['id'] );
			}
		}

	}

}