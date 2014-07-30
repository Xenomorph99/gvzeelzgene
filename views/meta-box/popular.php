<?php
/**
 * Custom meta box to display popularity (likes & views)
 *
 * @package WordPress
 * @subpackage Gvzeelzgene
 * @since 1.0
 */

$inflated = $array['inflate'];
extract( $data[0] );

?>

<p>Views: <strong style="font-size: 1.1em;"><?php echo $views; ?></strong></p>

<?php if( $inflated ) : ?>
	<p>Likes: <strong style="font-size: 1.1em;"><?php echo $likes; ?></strong> (+<?php echo $infl; ?> = <?php echo ( $likes + $infl ); ?>)</p>
<?php else : ?>
	<p>Likes: <strong style="font-size: 1.1em;"><?php echo $likes; ?></strong></p>
<?php endif;