<?php

class Security {
    private $secret = "ECR2022secretKey";
    
    public function encrypt($strToEncrypt) {
        try {
            $key = $this->setKey($this->secret);
            $encrypted = openssl_encrypt(
                $strToEncrypt,
                'AES-128-ECB',
                $key,
                OPENSSL_RAW_DATA
            );
            return base64_encode($encrypted);
        } catch (Exception $e) {
            echo $e->getMessage() . "\n";
            return null;
        }
    }
    
    private function setKey($myKey) {
        $key = hash('sha1', $myKey, true);
        $key = substr($key, 0, 16);
        return $key;
    }
}
