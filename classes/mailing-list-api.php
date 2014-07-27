<?php
/**
 * This model manages all functionality associated with the
 * mailing list API.
 *
 * Required models: Database, Encryption, Mailing_List, Email
 *
 * @author Colton James Wiscombe <colton@hazardmediagroup.com>
 * @copyright 2014 Hazard Media Group LLC
 * @version 1.0
 */

class Mailing_List_API {

	public function save_email( $email ) {

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
			//Email::send_mail( "no-reply@" )
			return $status = 'success';
		}

	}

	public function get_mailing_list( $status = 'all' ) {

		$data = array();
		$list = Database::get_results( Mailing_List::$table, array( 'id', 'email', 'status', 'timestamp' ) );
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

}