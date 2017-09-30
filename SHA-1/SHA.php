<?php

class SHA {
    
    public $db = array();
    
    public function getDigest($string, $n) {
        $hash = sha1($string);
        $binary = "";
        for ($i=0; $i<strlen($hash); $i++) {
            $binary .= str_pad(base_convert($hash[$i], 16, 2), 4, '0', STR_PAD_LEFT);
        }
        $truncate =  substr($binary, 0, $n);
        return dechex(bindec($truncate));
    }
    
    public function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    
    public function addToDatabase($digest) {
        $this->db[] = $digest;
    }
    
    public function exists($digest) {
        return in_array($digest, $this->db);
    }
    
    public function collisionAttack($bit_length=24) {
        $found = false;
        $counter = 0;

        while (!$found) {
            $str = $this->generateRandomString();
            $digest = $this->getDigest($str, $bit_length);
            if ($this->exists($digest)) {
                //echo "DIGEST WAS: <strong>".$digest."</strong><br>";
                $found = true;
            } else {
                $this->addToDatabase($digest);
            }
            $counter++;
        }
        
        $this->db = array();
        
        return $counter;
    }
    
    public function preImageAttack($bit_length=24) {
        $found = false;
        $counter = 0;
        
        $hash = $this->getDigest("Hello", $bit_length);
        
        while (!$found) {
            $str = $this->generateRandomString();
            $digest = $this->getDigest($str, $bit_length);
            if ($digest == $hash) {
                //echo "MESSAGE WAS: <strong>".$str."</strong><br>";
                $found = true;
            }
            $counter++;
        }
        return $counter;
    }
}