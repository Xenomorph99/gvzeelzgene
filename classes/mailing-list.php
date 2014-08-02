<?php
/**
 * This model manages all functionality associated with the subscriber
 * mailing list.
 *
 * Required models: Database, Encryption
 *
 * @author Colton James Wiscombe <colton@hazardmediagroup.com>
 * @copyright 2014 Hazard Media Group LLC
 * @version 1.1
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
		require_once VIEWS_DIR . 'admin/mailing-list.php';

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

		$data = Database::get_results( static::$table, array( 'id', 'email' ) );

		foreach( $data as $row => $col ) {
			if( $col['email'] == $email ) {
				Database::delete_row( static::$table, 'id', $col['id'] );
			}
		}

	}

	public function get_mailing_list( $status = 'all' ) {

		$data = array();
		$list = Database::get_results( static::$table, array( 'id', 'email', 'status', 'timestamp' ) );
		$count = count( $list );

		// Filter and return retrieved data
		switch( $status ) {

			case 'all' :
				return $data = $list;
				break;

			default :
				$data = $list;
				foreach( $list as $row ) {
					if( $row['status'] !== $status ) {
						unset( $data[$count] );
					}
					$count--;
				}
				return $data;
				break;

		}

	}

	public static function run_api_action( $action, $email ) {

		$resp = array();

		switch( $action ) {

			case 'save' :
				$resp = static::save_email( $email );
				break;

			default :
				$resp['status'] = 'error';
				$resp['desc'] = 'invalid-action';
				$resp['message'] = 'Defined API action cannot be performed';
				break;

		}

		return $resp;

	}

	protected static function save_email( $email ) {

		$resp = array();

		// Scrub out invalid email addresses
		if( preg_match( '/^[A-Za-z0-9._%\-]+@[A-Za-z0-9.\-]+\.[A-Za-z]{2,4}$/', $email ) ) :

			// Save email to mailing list
			$status = static::process_email( strtolower( $email ) );

			switch( $status ) {

				case "success" :
					$resp['status'] = 'success';
					$resp['desc'] = 'submitted';
					$resp['message'] = 'The submitted email address has successfully been added to the mailing list.';
					break;

				case "duplicate" :
					$resp['status'] = 'error';
					$resp['desc'] = 'duplicate';
					$resp['message'] = 'The submitted email address is already on the mailing list.';
					break;

				case "error" :
					$resp['status'] = 'error';
					$resp['desc'] = 'database-connection-error';
					$resp['message'] = 'An error occured connecting to the database.  Try again later.';
					break;

			}

		else :
			$resp['status'] = 'error';
			$resp['desc'] = 'invalid-format';
			$resp['message'] = 'The submitted email address does not match the required format.';
		endif;

		return $resp;

	}

	protected static function process_email( $email ) {

		$data = array(
			'email' => $email,
			'timestamp' => date( 'Y-m-d H:i:s', time() )
		);
		$match = false;

		// Check for duplicates
		$list = Database::get_results( static::$table, array( 'email' ) );
		foreach( $list as $item ) {
			if( $item['email'] === $data['email'] ) {
				$match = true;
			}
		}

		// Take appropriate action
		if( $match ) {
			return $status = 'duplicate';
		} else {
			Database::insert_row( static::$table, $data );
			//Email::send_mail( "no-reply@" . get_bloginfo( 'url' ) );
			return $status = 'success';
		}

	}

}