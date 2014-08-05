<?php
/**
 * Directory and file path definitions
 *
 * @package WordPress
 * @subpackage Gvzeelzgene
 * @since 1.0
 */

// Theme root directory
define( 'THEME_DIR', dirname( __FILE__ ) . '/' );

// General directories
define( 'API_DIR', THEME_DIR . 'api/' );
define( 'CLASSES_DIR', THEME_DIR . 'classes/' );
define( 'CSS_DIR', THEME_DIR . 'css/' );
define( 'CSV_DIR', THEME_DIR . 'csv/' );
define( 'FONTS_DIR', THEME_DIR . 'fonts/' );
define( 'IMAGE_DIR', THEME_DIR . 'images/' );
define( 'INC_DIR', THEME_DIR . 'inc/' );
define( 'JS_DIR', THEME_DIR . 'js/' );
define( 'VIEWS_DIR', THEME_DIR . 'views/' );

// Includes
define( 'ANALYTICS_INC', INC_DIR . 'analytics.php' );

// Classes
define( 'ADMIN_MENU_CLASS', CLASSES_DIR . 'admin-menu.php' );
define( 'DATABASE_CLASS', CLASSES_DIR . 'database.php' );
define( 'EMAIL_CLASS', CLASSES_DIR . 'email.php' );
define( 'ENCRYPTION_CLASS', CLASSES_DIR . 'encryption.php' );
define( 'FORMS_CLASS', CLASSES_DIR . 'forms.php' );
define( 'FUNCTIONS_CLASS', CLASSES_DIR . 'functions.php' );
define( 'LEADS_CLASS', CLASSES_DIR . 'leads.php' );
define( 'MAILING_LIST_CLASS', CLASSES_DIR . 'mailing-list.php' );
define( 'META_BOX_CLASS', CLASSES_DIR . 'meta-box.php' );
define( 'POPULAR_CLASS', CLASSES_DIR . 'popular.php' );
define( 'POST_TYPE_CLASS', CLASSES_DIR . 'post-type.php' );
define( 'QUICK_EDIT_CLASS', CLASSES_DIR . 'quick-edit.php' );
define( 'THEME_CLASS', CLASSES_DIR . 'theme.php' );