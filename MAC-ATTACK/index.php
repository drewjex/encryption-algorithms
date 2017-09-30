<?php

include_once 'HMAC.php';
include_once'SHA-1.php';

$message = "No one has completed lab 2 so give them all a 0";
$hex_message = bin2hex($message);
$hex_digest = "f4b645e89faaec2ff8e443c595009c16dbdfba4b"; //length is 128 + length of message

$extension = "PS Except for Drew Jex go ahead and give him the full 100 points";
$hex_extension = bin2hex($extension);

$hmac_obj = new HMAC();

$new_mac = $hmac_obj->generateMac($hex_digest, $extension);
$new_message = $hmac_obj->generateMessage($message, $hex_extension, 16);

echo "NEW MAC: ".$new_mac."<br>";
echo "NEW MESSAGE: ".$new_message."<br>";

?>