<?php
/**
 * 加密解密类
 * @author renhai <540693750@qq.com>
 * @version 1.0
 */
class Crypt {
	
    public static function encrypt($text, $key = '') {
		if (!$text) {
			return '';
		}
		return @bin2hex(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $text, MCRYPT_MODE_ECB));
	}

    public static function decrypt($text, $key = '') {
		if (!$text) {
			return '';
		}
		return @mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, pack("H*", $text), MCRYPT_MODE_ECB);
	}
}