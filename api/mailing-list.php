<?php
/**
 * API configuration
 *
 * Required parameters: action, email
 *
 * @package WordPress
 * @subpackage Gvzeelzgene
 * @since 1.0
 */

// Define as JSON application
header( 'Content-type: application/json' );
require_once 'config.php';

// Set the default API response
$resp = array(
	'status' => 'error',
	'desc' => 'missing-parameters',
	'message' => 'Warning: required parameters not found',
);

// Verify action
$query = $_POST;
if( isset( $query ) && !empty( $query['action'] ) && !empty( $query['email'] ) ) :

	$resp = Mailing_List_API::run_action( $query['action'], $query['email'] );

endif;

// Return JSON response string
echo json_encode( $resp );