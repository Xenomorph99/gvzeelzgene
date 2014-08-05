<?php
/**
 * This model manages the creation and distribution of HTML Emails.
 *
 * @author Colton James Wiscombe <colton@hazardmediagroup.com>
 * @copyright 2014 Hazard Media Group LLC
 * @version 1.1
 */

class Email {

	public $settings = array(
		'sender' => get_bloginfo( 'admin_email' ),
		'reply_to' => get_bloginfo( 'admin_email' ),
		'recipient' => '',
		'subject' => '',
		'message' => '',
		'template' = '',
		'data' => array()
	);

	public function __construct( $args ) {

		$this->settings = Functions::merge_array( $args, $this->settings );
		$this->send_mail();

	}

	protected function send_mail() {

		extract( $this->settings );

		$rn = "\r\n";
		$headers = "From: " . $sender . $rn;
		//$headers .= "Reply-To: " . $reply_to . $rn;
		$headers .= "Mime-Version: 1.0" . $rn;
		$headers .= "Content-type: text/html; charset=UTF-8" . $rn;
		$headers .= "X-Mailer: PHP/" . phpversion();

		require_once $template;

		@mail( $recipient, $subject, $message, $headers );

	}

}