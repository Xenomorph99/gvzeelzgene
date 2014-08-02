<?php
/**
 * This model manages the creation and distribution of HTML
 * Emails.
 *
 * @author Colton James Wiscombe <colton@hazardmediagroup.com>
 * @copyright 2014 Hazard Media Group LLC
 * @version 1.0
 */

class Email {

	public static function send_mail( $sender, $subject, $recipient, $template, $data = NULL ) {

		$rn = "\r\n";
		$headers = "From: " . $sender . $rn;
		//$headers .= "Reply-To: " . $sender . $rn;
		$headers .= "Mime-Version: 1.0" . $rn;
		$headers .= "Content-type: text/html; charset=UTF-8" . $rn;
		$headers .= "X-Mailer: PHP/" . phpversion();
		$message = '';

		require_once $template;

		@mail( $recipient, $subject, $message, $headers );

	}

}