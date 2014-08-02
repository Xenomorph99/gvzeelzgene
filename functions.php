<?php
/**
 * Theme functions & definitions
 *
 * @package WordPress
 * @subpackage Gvzeelzgene
 * @since 1.0
 */

require_once 'config.php';
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