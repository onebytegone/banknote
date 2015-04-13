<?php

/**
 * Allows import and export of encrypted data
 *
 * @copyright 2015 Ethan Smith
 */

class EncryptedDataProcessor {

    public $algorithm = MCRYPT_RIJNDAEL_256;

    public function encryptData($data, $key) {
        $iv = mcrypt_create_iv(mcrypt_get_iv_size($this->algorithm, MCRYPT_MODE_ECB), MCRYPT_RAND);
        $encryptedData = mcrypt_encrypt($etype, $key, $data, MCRYPT_MODE_CBC, $iv);
        $output = bin2hex($encryptedData);

        return $output;
    }

    public function decryptData($data, $key) {
        $iv = mcrypt_create_iv(mcrypt_get_iv_size($this->algorithm, MCRYPT_MODE_ECB), MCRYPT_RAND);
        return mcrypt_decrypt($this->algorithm, $key, $data, MCRYPT_MODE_CBC, $iv);
    }
}
