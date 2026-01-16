<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SmsCounter extends Controller
{
    const GSM_7BIT_ONEPART = 160;
	const GSM_7BIT_MULTIPART = 153;
	const GSM_UCS2_ONEPART = 70;
	const GSM_UCS2_MULTIPART = 67;

	// Basic GSM character set (each char encodes to one 7-bit value)
	const GSM_7BIT_BASIC = "@£\$¥èéùìòÇ\nØø\rÅåΔ_ΦΓΛΩΠΨΣΘΞÆæßÉ !\"#¤%&'()*+,-./0123456789:;<=>?¡ABCDEFGHIJKLMNOPQRSTUVWXYZÄÖÑÜ§¿abcdefghijklmnopqrstuvwxyzäöñüà";

	// Extended set (requires escape code before character thus 2x7-bit encodings per)
	const GSM_7BIT_EXTENDED = "^{}\\[~]|€";

	/**
	 * Calculate the number of SMS messages required to send this message, taking into account
	 * character encodings of the message (7-bit vs UCS2)
	 *
	 * @param string $string UTF-8 message string
	 * @return int Number of SMS parts required to send this message
	 */
	public static function multipartLength($string)
	{
		$limitOne = self::GSM_7BIT_ONEPART;
		$limitMulti = self::GSM_7BIT_MULTIPART;

		$length = static::gsm7bitLength($string);
		if($length === -1) {
			$length = static::gsmUcs2Length($string);
			$limitOne = self::GSM_UCS2_ONEPART;
			$limitMulti = self::GSM_UCS2_MULTIPART;
		}

		if($length <= $limitOne) {
			return 1;
		}

		return (int) ceil($length / $limitMulti);
	}

	public static function isGsm7bitEncodable($string, $encoding = 'UTF-8')
	{
		return static::gsm7bitLength($string, $encoding) !== -1;
	}

	/**
	 * Calculates the length (in 7-bit characters) of the given string
	 *
	 * @param string $string String to use
	 * @param string $encoding Encoding of the input string (one of mb_string supported encodings)
	 * @return int Length in GSM 03.38 7-bit characters, or -1 if the string cannot be encoded in 7-bit
	 */
	public static function gsm7bitLength($string, $encoding = 'UTF-8')
	{
		$len = 0;

		for($i = 0; $i < mb_strlen($string, $encoding); $i++) {
			$char = mb_substr($string, $i, 1);
			if(mb_strpos(self::GSM_7BIT_BASIC, $char, 0, $encoding) !== FALSE) {
				$len++;
			} else if(mb_strpos(self::GSM_7BIT_EXTENDED, $char, 0, $encoding) !== FALSE) {
				$len += 2;
			} else {
				return -1; // cannot be encoded as GSM, immediately return -1
			}
		}

		return (int) $len;
	}

	/**
	 * Calculates the length (in 16-bit characters) of the given string
	 *
	 * Note: GSM uses UCS2 encoding. Some carriers and phones however, support UTF-16 characters,
	 *       so we have to calculate the number of 16-bit units present, even if they can't be
	 *       correctly coded with UCS2.
	 *
	 * @param string $string String to use
	 * @param string $encoding Encoding of the input string (one of mb_string supported encodings)
	 * @return int Length in 16-bit characters
	 */
	public static function gsmUcs2Length($string, $encoding = 'UTF-8')
	{
		// convert the string into 16-bit representation
		$utf16str = mb_convert_encoding($string, 'UTF-16', $encoding);

		// count the number of bytes in the string
		// note: not using strlen as may be overloaded,
		//       not using mb_strlen($utf16str, 'UCS-2') as may be lossy in future
		//       not using mb_strlen($utf16str, '8bit') as again, may be lossy
		$byteArray = unpack('C*', $utf16str);
		$bytes = count($byteArray);

		// return byte count / 2 - note as a 16-bit string byte count should always be divisible by two
		return (int) ($bytes / 2);
	}
}
