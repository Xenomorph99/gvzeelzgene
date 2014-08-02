<?php
/**
 * This model manages all functionality associated with the subscriber
 * mailing list.
 *
 * Required models: Database, Encryption
 *
 * Future:
 * - Add unsubscribe functionality
 * - Add MailChimp & other 3rd party integrations
 * - Add stats (number of subscribers, unsubscribers, etc)
 * - Add ability to send out email to members of the subscription list
 * - Shortcode and function capability to pull a subscribe form into any view
 * - Extract into Wordpress plugin format
 * - Create generic HTML email templates
 * - Create ability to add custom HTML email templates
 * - Add additional layers of security
 *
 * @author Colton James Wiscombe <colton@hazardmediagroup.com>
 * @copyright 2014 Hazard Media Group LLC
 * @version 1.2
 */

class Mailing_List {

	public $settings = array();

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

	public function __construct( $args ) {

		$this->settings = Functions::merge_array( $args, $this->settings );

		$this->setup_mailing_list();
		$this->wp_hooks();

	}

	protected function setup_mailing_list() {

		Encryption::generate_key( 'mailing_list_key' );
		Database::install_table( static::$table );

	}

	protected function wp_hooks() {

		// Setup the mailing list admin menu
		add_action( 'admin_menu', array( &$this, 'register_admin_menu' ) );

	}

	public function register_admin_menu() {

		add_menu_page( 'Mailing List', 'Mailing List', 'manage_options', 'mailing_list', array( &$this, 'mailing_list_admin_menu' ), '', 100 );

	}

	public function mailing_list_admin_menu() {

		// Update the status of checked rows in the mailing list view
		$this->update_mailing_list();

		$data = Database::get_results( static::$table, array( 'id', 'email', 'status', 'timestamp' ) );
		require_once VIEWS_DIR . 'admin-menu/mailing-list.php';

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
						Database::update_row( static::$table, 'id', $row_id, array( 'status' => 'active' ) );
						break;

					case 'trash' :
						Database::update_row( static::$table, 'id', $row_id, array( 'status' => 'trash' ) );
						break;

					case 'delete' :
						Database::delete_row( static::$table, 'id', $row_id );
						break;

				}
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

			case 'unsubscribe' :
				$resp = static::delete_email( $email );
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
			$status = static::save_to_database( strtolower( $email ) );

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

	protected static function save_to_database( $email ) {

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

	protected static function delete_email( $email ) {

		$resp = array();

		// Scrub out invalid email addresses
		if( preg_match( '/^[A-Za-z0-9._%\-]+@[A-Za-z0-9.\-]+\.[A-Za-z]{2,4}$/', $email ) ) :

			// Remove email from mailing list
			$status = static::remove_from_database( strtolower( $email ) );

			switch( $status ) {

				case "success" :
					$resp['status'] = 'success';
					$resp['desc'] = 'removed';
					$resp['message'] = 'The submitted email address has successfully been removed from the mailing list.';
					break;

				case "not-found" :
					$resp['status'] = 'error';
					$resp['desc'] = 'not-found';
					$resp['message'] = 'The submitted email address was not found on the mailing list.';
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

	protected static function remove_from_database( $email ) {

		$data = Database::get_row( static::$table, 'email', $email );

		if( !empty( $data ) ) :

			Database::delete_row( static::$table, 'email', $email );
			//Email::send_mail( ... );
			return $status = 'success';

		else :

			return $status = 'not-found';

		endif;

	}

}