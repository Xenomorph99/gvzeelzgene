<?php
/**
 * HTML Email template sent to new subscribers when they first
 * subscribe.
 *
 * @version 1.0
 */

require_once dirname( dirname( dirname( __FILE__ ) ) ) . '/config.php';

$prefix = 'mailing_list_settings_';
$settings = array(
	'sender' => '',
	'reply_to' => '',
	'recipient' => '',
	'subject' => '',
	'template' => '',
	'data' => ''
);

if( isset( $this ) ) :
	$settings = Functions::merge_array( $this->settings, $settings );
elseif( !empty( $_GET['sender'] ) && !empty( $_GET['reply_to'] ) && !empty( $_GET['recipient'] ) && !empty( $_GET['subject'] ) && !empty( $_GET['template'] ) ) :
	$settings = Functions::merge_array( $_GET, $settings );
else :
	exit( 'You do not have permission to view this page.' );
endif;

extract( $settings );

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<title><?php echo $subject . ' | ' . get_bloginfo( 'blogname' ); ?></title>
</head>

<body>
	<p>View in <a href="<?php echo get_template_directory_uri(); ?>/views/email/subscribe.php?sender=<?php echo $sender; ?>&reply_to=<?php echo $reply_to; ?>&recipient=<?php echo $recipient; ?>&subject=<?php echo $subject; ?>&template=<?php echo $template; ?>">Web Browser</a> | <a href="<?php echo get_template_directory_uri(); ?>/api/mailing-list.php?action=unsubscribe&email=<?php echo $recipient; ?>">Unsubscribe</a></p>
	<table>

		<thead>
			<tr>
				<table>
					<tr>
						
						<td>LOGO</td>

						<?php if( get_option( $prefix . 'facebook' ) ) { ?>
						<td><a href="<?php echo get_option( $prefix . 'facebook' ); ?>">Facebook</a></td>
						<?php } ?>

						<?php if( get_option( $prefix . 'twitter' ) ) { ?>
						<td><a href="<?php echo get_option( $prefix . 'twitter' ); ?>">Twitter</a></td>
						<?php } ?>

					</tr>
				</table>
			</tr>
			<tr><td>Women</td></tr>
			<tr><td>Thanks for Subscribing!</td></tr>
			<tr><td>Check out these special offers:</td></tr>
		</thead>

		<tbody>
			<tr>

				<?php $posts = wp_get_recent_posts( array( 'numberposts' => 3 ), OBJECT ); ?>
				<?php foreach( $posts as $post ) : ?>
				<td>
					<table>
						<tr>
							<td>
								<?php if( has_post_thumbnail( $post->ID ) ) : ?>
									<?php echo get_the_post_thumbnail( $post->ID, 'thumbnail' ); ?>
								<?php else : ?>
									<img src="#" alt="">
								<?php endif; ?>
							</td>
							<td>
								<h1><?php echo $post->post_title; ?></h1>
								<p><?php echo $post->post_excerpt . '... <a href="' . get_permalink( $post->ID ) . '">learn more</a>'; ?></p>
							</td>
						</tr>
					</table>
				</td>
				<?php endforeach; ?>
				
			</tr>
		</tbody>

		<tfoot>
			<tr>
				<td>

					<?php if( get_option( $prefix . 'facebook' ) ) { ?>
					<span><a href="<?php echo get_option( $prefix . 'facebook' ); ?>">Facebook</a></span>
					<?php } ?>

					<?php if( get_option( $prefix . 'twitter' ) ) { ?>
					<span><a href="<?php echo get_option( $prefix . 'twitter' ); ?>">Twitter</a></span>
					<?php } ?>

				</td>
			</tr>
		</tfoot>

	</table>
	<p>Copyright &copy; <?php echo date("Y"); ?>,&nbsp;<a href="<?php echo home_url(); ?>"><?php bloginfo( 'blogname' ); ?></a>. All Rights Reserved.</p>
	<p>View in <a href="<?php echo $template; ?>?sender=<?php echo $sender; ?>&reply_to=<?php echo $reply_to; ?>&recipient=<?php echo $recipient; ?>&subject=<?php echo $subject; ?>&template=<?php echo $template; ?>">Web Browser</a> | <a href="<?php echo get_template_directory_uri(); ?>/api/mailing-list.php?action=unsubscribe&email=<?php echo $recipient; ?>">Unsubscribe</a></p>
</body>

</html>