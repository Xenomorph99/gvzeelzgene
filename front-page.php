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
			<?php $mailing_list_form_args = array(
				'id' => 'hello',
				'label' => 'Enter your <em>email</em> below to subscribe',
				'label_tag' => 'h3'
			); ?>
			<?php Mailing_List::form( $mailing_list_form_args ); ?>
		</div><!--#main-->

		<?php get_sidebar(); ?>

	</div><!--#content-->

<?php get_footer();