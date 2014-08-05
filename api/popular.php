<?php
/**
 * Popular API
 *
 * Required parameters: action, post_id
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
if( isset( $query ) && !empty( $query['action'] ) && !empty( $query['post_id'] ) ) :

	$resp = Popular::run_api_action( $query['action'], $query['post_id'] );

else :
	exit( 'You do not have permission to view this page.' );
endif;

// Return JSON response string
echo json_encode( $resp );