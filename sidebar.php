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
	<?php foreach( Popular::get_popular() as $post_id ) : ?>
		<li class="popular-post"><a href="<?php echo get_permalink( $post_id ); ?>"><?php echo get_the_title( $post_id ); ?></a></li>
	<?php endforeach; ?>
	</ul><!--#popular-posts-->
</div><!--#sidebar-->