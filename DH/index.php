<?php

$prime = exec("openssl prime -generate -bits 512");

/*if (isPrime(($prime-1)/2)) {
    echo "PRIME";
}

echo $prime;

echo "<br>Hello<br>";

function isPrime($n) {
  $i = 2;
 
  if ($n == 2) {
   return true;	
  }
 
  $sqrtN = sqrt($n);
  while ($i <= $sqrtN) {
   if ($n % $i == 0) {
    return false;
   }
   $i++;
  }
 
  return true;
 }*/

?>