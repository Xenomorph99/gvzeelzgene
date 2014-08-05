<?php
/**
 * Theme configuration
 *
 * @package WordPress
 * @subpackage Gvzeelzgene
 * @since 1.0
 */

// Wordpress config file (defines ABSPATH and includes 'wp-settings.php', etc.)
require_once $_SERVER['DOCUMENT_ROOT'] . '/wp-config.php';

// General theme definitions
define( 'THEME_VERSION', '1.0' );

// Server definitions
define( 'REMOTE_INSTALL', '' );
define( 'LOCAL_INSTALL', 'gvzeelzgene.local' );
define( 'CODEKIT_SERVER', 'colton.local:5757' );

// Define file and directory paths
require_once 'paths.php';

// Include required models
require_once ADMIN_MENU_CLASS;
require_once DATABASE_CLASS;
require_once EMAIL_CLASS;
require_once ENCRYPTION_CLASS;
require_once FORMS_CLASS;
require_once FUNCTIONS_CLASS;
require_once LEADS_CLASS;
require_once MAILING_LIST_CLASS;
require_once META_BOX_CLASS;
require_once POPULAR_CLASS;
require_once POST_TYPE_CLASS;
require_once QUICK_EDIT_CLASS;
require_once THEME_CLASS;

// Setup and run the theme
$Theme = new Theme();