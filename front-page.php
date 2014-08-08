<?php
/**
 * Front page (home page)
 *
 * @package WordPress
 * @subpackage Gvzeelzgene
 * @since 1.0
 */

get_header(); ?>

	<div id="content">

		<div id="main">
			<h1>Front Page</h1>
			<?php Mailing_List::form( 'Enter your email below to subscribe', 'h3' ); ?>
		</div><!--#main-->

		<?php get_sidebar(); ?>

	</div><!--#content-->

<?php get_footer();