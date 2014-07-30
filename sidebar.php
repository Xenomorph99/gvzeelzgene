<?php
/**
 * The Sidebar
 *
 * @package WordPress
 * @subpackage Gvzeelzgene
 * @since 1.0
 */

?>

<div id="sidebar">
	<h2>Sidebar</h2>
	<ul id="popular-posts">
	<?php

		$popular_posts = get_posts( array( 'include' => Popular::get_popular( 5 ) ) );
		foreach( $popular_posts as $popular ) { ?>
			<li class="popular-post"><a href="<?php echo get_permalink( $popular->ID ); ?>"><?php echo $popular->post_title; ?></a></li>
		<?php }

	?>
	</ul><!--#popular-posts-->
</div><!--#sidebar-->