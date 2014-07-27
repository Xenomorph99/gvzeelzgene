<?php
/**
 * The Header
 *
 * @package WordPress
 * @subpackage Gvzeelzgene
 * @since 1.0
 */

?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

	<title><?php wp_title( '|', true, 'right' ); ?><?php bloginfo( 'blogname' ); ?></title>

	<!--[if lt IE 9]>
	<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/images/favicon.ico">

	<link href="<?php echo get_template_directory_uri(); ?>/images/apple-touch-icon.png" rel="apple-touch-icon">
	<link href="<?php echo get_template_directory_uri(); ?>/images/apple-touch-icon-76x76.png" rel="apple-touch-icon" sizes="76x76">
	<link href="<?php echo get_template_directory_uri(); ?>/images/apple-touch-icon-120x120.png" rel="apple-touch-icon" sizes="120x120">
	<link href="<?php echo get_template_directory_uri(); ?>/images/apple-touch-icon-152x152.png" rel="apple-touch-icon" sizes="152x152">

	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

	<link href='http://fonts.googleapis.com/css?family=Muli|Roboto:300,500,300italic,500italic' rel='stylesheet' type='text/css'>

	<?php wp_head(); ?>

	<?php get_template_part( 'inc/analytics' ); ?>
</head>

<body <?php body_class(); ?>>

	<header id="global-header">

	</header><!--#global-header-->