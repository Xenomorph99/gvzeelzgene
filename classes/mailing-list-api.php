<?php
/**
 * This model manages all functionality associated with the
 * mailing list API.
 *
 * Required models: Database, Encryption, Mailing_List, Email
 *
 * @author Colton James Wiscombe <colton@hazardmediagroup.com>
 * @copyright 2014 Hazard Media Group LLC
 * @version 1.1
 */

class Mailing_List_API {

	public static function run_action( $action, $email ) {

		$resp = array();

		switch( $action ) {

			case 'save' :
				$resp = Mailing_List_API::save_email( $email );
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
			$status = Mailing_List_API::process_email( strtolower( $email ) );

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
		$list = Database::get_results( Mailing_List::$table, array( 'email' ) );
		foreach( $list as $item ) {
			if( $item['email'] === $data['email'] ) {
				$match = true;
			}
		}

		// Take appropriate action
		if( $match ) {
			return $status = 'duplicate';
		} else {
			Database::insert_row( Mailing_List::$table, $data );
			//Email::send_mail( "no-reply@" . get_bloginfo( 'url' ) );
			return $status = 'success';
		}

	}

}