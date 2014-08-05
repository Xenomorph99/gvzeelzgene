<?php
/**
 * Mailing list API
 *
 * Required parameters: action, email
 *
 * @package WordPress
 * @subpackage Gvzeelzgene
 * @since 1.0
 */

// Define as JSON application
header( 'Content-type: application/json' );
require_once dirname( dirname( __FILE__ ) ) . '/config.php';

// Set the default API response
$resp = array(
	'status' => 'error',
	'desc' => 'missing-parameters',
	'message' => 'Warning: required parameters not found',
);

// Verify action
//$query = $_POST;
$query = $_GET;
if( isset( $query ) && !empty( $query['action'] ) && !empty( $query['email'] ) ) :

	$resp = Mailing_List::run_api_action( $query['action'], $query['email'] );

else :
	exit( 'You do not have permission to view this page.' );
endif;

// Return JSON response string
echo json_encode( $resp );