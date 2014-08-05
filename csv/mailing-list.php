<?php
/**
 * Mailing List CSV Generation File
 *
 * @package WordPress
 * @subpackage Gvzeelzgene
 * @since 1.0
 */

require_once dirname( dirname( __FILE__ ) ) . '/config.php';

// Verify encryption key
if( $_GET['key'] == get_option( 'mailing_list_key' ) ) :

	// Verify action is set to export
	if( $_GET['action'] == 'export' ) :

		// Define variables
		$csv = fopen( 'php://memory', 'w' );
		$data = ( !empty( $_GET['status'] ) ) ? Mailing_List::get_mailing_list( $_GET['status'] ) : Mailing_List::get_mailing_list();
		$delimiter = ( !empty( $_GET['delimiter'] ) ) ? $_GET['delimiter'] : ',';

		// Generate CSV lines
		foreach( $data as $line ) {
			fputcsv( $csv, $line, $delimiter );
		}

		// Rewind the CSV file
		fseek( $csv, 0 );

		// Set CSV file headers
		header( 'Content-Type: application/csv' );
		header( 'Content-Disposition: attachement; filename="' . $_GET['file'] . '"' );

		// Send the generated CSV to the browser
		fpassthru( $csv );

	else :

		die( "Defined action is not supported." );

	endif;

else :

	die( "You do not have permission to access this page." );

endif;