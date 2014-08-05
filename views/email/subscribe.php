<?php
/**
 * HTML Email template sent to new subscribers when they first
 * subscribe.
 *
 * @version 1.0
 */

require_once dirname( dirname( dirname( __FILE__ ) ) ) . '/config.php';

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
	<p>View in <a href="<?php echo $template; ?>?sender=<?php echo $sender; ?>&reply_to=<?php echo $reply_to; ?>&recipient=<?php echo $recipient; ?>&subject=<?php echo $subject; ?>&template=<?php echo $template; ?>">Web Browser</a> | <a href="<?php echo get_template_directory_uri(); ?>/api/mailing-list.php?action=unsubscribe&email=<?php echo $recipient; ?>">Unsubscribe</a></p>
	<table>

		<thead>
			<tr><td>Subscribed</td></tr>
		</thead>

		<tbody>
			<tr><td>tBody</td></tr>
		</tbody>

	</table>
	<p>View in <a href="<?php echo $template; ?>?sender=<?php echo $sender; ?>&reply_to=<?php echo $reply_to; ?>&recipient=<?php echo $recipient; ?>&subject=<?php echo $subject; ?>&template=<?php echo $template; ?>">Web Browser</a> | <a href="<?php echo get_template_directory_uri(); ?>/api/mailing-list.php?action=unsubscribe&email=<?php echo $recipient; ?>">Unsubscribe</a></p>
</body>

</html>