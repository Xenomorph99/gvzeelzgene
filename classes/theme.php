<?php
/**
 * This model runs the setup and initialization of the theme.  Database
 * tables are defined here.
 *
 * @package WordPress
 * @subpackage Gvzeelzgene
 * @since 1.0
 */

class Theme {

	public function __construct() {

		// Run Wordpress hooks
		$this->wp_hooks();

	}

	protected function wp_hooks() {

		// Setup theme
		add_action( 'after_setup_theme', array( &$this, 'setup_theme' ) );

		// Enqueue global scripts and styles
		add_action( 'wp_enqueue_scripts', array( &$this, 'enqueue' ) );

		// Enqueue admin scripts and styles
		add_action( 'admin_enqueue_scripts', array( &$this, 'admin_enqueue' ) );

		// Register navigation menus
		add_action( 'init', array( &$this, 'setup_nav_menus' ) );

		// Register widgetable areas
		add_action( 'widgets_init', array( &$this, 'setup_widgetable_areas' ) );

		// Modify how the excerpt is truncated
		add_filter( 'excerpt_more', array( &$this, 'excerpt' ) );

	}

	public static function setup_theme() {

		// Add RSS feed links to <head>
		add_theme_support( 'automatic-feed-links' );

		// Add thumbnail images
		add_theme_support( 'post-thumbnails' );

		// Register custom post types
		static::register_custom_post_types();

		// Register admin menus
		static::register_admin_menus();

		// Register custom meta boxes
		static::register_custom_meta_boxes();

		// Register mailing list
		static::register_mailing_list();

		// Register popular tracking (views & likes)
		static::register_popular_tracking();

	}

	protected static function register_custom_post_types() {

		$products = array(
			'post_type' => 'products',
			'name_singular' => 'Product',
			'name_plural' => 'Products'
		);

		new Post_Type( $products );

	}

	protected static function register_admin_menus() {

		// new Admin_Menu();

	}

	protected static function register_custom_meta_boxes() {

		// new Meta_Box();

	}

	protected static function register_mailing_list() {

		$args = array();

		$Mailing_List = new Mailing_List( $args );

	}

	protected static function register_popular_tracking() {

		$args = array(
			'inflate' => true
		);

		$Popular = new Popular( $args );

	}

	public static function enqueue() {

		// Stylesheets
		wp_enqueue_style( 'primary-style', get_template_directory_uri() . '/css/adv.css', array(), '1.0' );

		// Global Scripts
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'easing', get_template_directory_uri() . '/js/jquery.easing.js', array( 'jquery' ), '1.3' );
		wp_enqueue_script( 'cycle', get_template_directory_uri() . '/js/jquery.cycle.all.js', array( 'jquery', 'easing' ), '2.9' );

		// Minified scripts (non minified scripts will only be displayed on the local install)
		if( $_SERVER['HTTP_HOST'] === LOCAL_INSTALL || $_SERVER['HTTP_HOST'] === CODEKIT_SERVER ) {
			wp_enqueue_script( 'device', get_template_directory_uri() . '/js/device.js', array( 'jquery' ), '1.0' );
			wp_enqueue_script( 'query', get_template_directory_uri() . '/js/query.js', array( 'jquery' ), '1.0' );
			wp_enqueue_script( 'js', get_template_directory_uri() . '/js/js.js', array( 'jquery', 'easing', 'cycle', 'device', 'query' ), '1.0' );
		} else {
			wp_enqueue_script( 'device', get_template_directory_uri() . '/js/min/device-min.js', array( 'jquery' ), '1.0' );
			wp_enqueue_script( 'query', get_template_directory_uri() . '/js/min/query-min.js', array( 'jquery' ), '1.0' );
			wp_enqueue_script( 'js', get_template_directory_uri() . '/js/min/js-min.js', array( 'jquery', 'easing', 'cycle' ), '1.0' );
		}

	}

	public static function admin_enqueue() {

		// Stylesheets
		wp_enqueue_style( 'primary-admin-style', get_template_directory_uri() . '/css/admin.css', array(), '1.0' );

		// Scripts
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'admin', get_template_directory_uri() . '/js/admin.js', array( 'jquery' ), '1.0' );

	}

	public static function setup_nav_menus() {

		$menus = array(
			'primary_nav' => 'Primary Nav',
			'secondary_nav' => 'Secondary Nav',
			'footer_nav' => 'Footer Nav'
		);

		register_nav_menus( $menus );

	}

	public static function setup_widgetable_areas() {

		// Do nothing

	}

	public static function excerpt( $more ) {

		return '...';

	}

}