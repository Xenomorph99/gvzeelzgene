<?php
/**
 * This model contains custom encryption methods used for
 * encrypting and decrypting sensitive data.  By default,
 * encryption will run using the SECURE_AUTH_SALT defined
 * in the WP config file.
 *
 * @author Colton James Wiscombe <colton@hazardmediagroup.com>
 * @copyright 2014 Hazard Media Group LLC
 * @version 1.0
 */

class Encryption {

	protected static $salt = SECURE_AUTH_SALT;

	public static function encrypt( $data ) {

		$encodedData = json_encode( $data );
		$encryptedData = trim( base64_encode( mcrypt_encrypt( MCRYPT_RIJNDAEL_256, md5( Encryption::$salt ), $encodedData, MCRYPT_MODE_ECB, mcrypt_create_iv( mcrypt_get_iv_size( MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB ), MCRYPT_RAND ) ) ) );
		return $encryptedData;

	}

	public static function decrypt( $data ) {

		$decryptedArray = trim( mcrypt_decrypt( MCRYPT_RIJNDAEL_256, md5( Encryption::$salt ), base64_decode( $data ), MCRYPT_MODE_ECB, mcrypt_create_iv( mcrypt_get_iv_size( MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB ), MCRYPT_RAND ) ) );
		$decryptedData = json_decode( $decryptedArray, true );
		return $decryptedData;

	}

	public static function generate_key( $name ) {

		if( !get_option( $name ) ) {

			$rand = rand(10000000, 999999999);
			$val = static::encrypt( $rand );
			$val = str_replace( '/', '_', $val );
			$val = str_replace( '+', '_', $val );
			$val = str_replace( '=', '_', $val );
			add_option( $name, $val );

		}

	}

}