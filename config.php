<?php
/**
 * Theme configuration
 *
 * @package WordPress
 * @subpackage Gvzeelzgene
 * @since 1.0
 */

// General theme definitions
define( 'THEME_VERSION', '1.0' );

// Server definitions
define( 'REMOTE_INSTALL', '' );
define( 'LOCAL_INSTALL', 'gvzeelzgene.local' );
define( 'CODEKIT_SERVER', 'colton.local:5757' );

// Include the Intoor Library
require_once dirname( __FILE__ ) . '/lib/config.php';

// Include the Gvzeelzgene theme class
require_once dirname( __FILE__ ) . '/theme.php';

// Setup and run the theme
$Theme = new Theme();