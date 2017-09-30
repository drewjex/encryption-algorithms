<?php

include_once 'SHA-1.php';

class HMAC {
    
    public function generateMac($mac, $extension) { 
        
        $sha = new SHA1();
        
        $h0 = hexdec(substr($mac, 0, 8));
        $h1 = hexdec(substr($mac, 8, 8));
        $h2 = hexdec(substr($mac, 16, 8));
        $h3 = hexdec(substr($mac, 24, 8));
        $h4 = hexdec(substr($mac, 32, 8));
        
        //"f4b645e89faaec2ff8e443c595009c16dbdfba4b"
        
        return $sha->hash_sha1($extension, $h0, $h1, $h2, $h3, $h4);
        //return $sha->hash_sha1($extension, 0xF4B645E8, 0x9FAAEC2F, 0xF8E443C5, 0x95009C16, 0xDBDFBA4B);
    }
    
    public function generateMessage($original, $extension, $key_length) {
        
        $sha = new SHA1();
        
        $padding = $sha->preProcessKeyLength($original, $key_length);
        echo "<br>Original Length: ".((strlen(bin2hex($original).$padding)*4)+128)."<br><br>";
        return bin2hex($original).$padding.$extension;
        
    }
    
}

?>