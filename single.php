<?php
/**
 * Individual blog posts
 *
 * @package WordPress
 * @subpackage Gvzeelzgene
 * @since 1.0
 */

get_header(); ?>

	<div id="content">

		<div id="main">
			<h1>Single</h1>
			<?php Social::social_media_share_buttons( array('facebook', 'twitter', 'pinterest') ); ?>
			<?php if( have_posts() ) : while( have_posts() ) : the_post(); ?>

				<?php the_content(); ?>

			<?php endwhile; endif; ?>
		</div><!--#main-->

		<?php get_sidebar(); ?>

	</div><!--#content-->

<?php get_footer();