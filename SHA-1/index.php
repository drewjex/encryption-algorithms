<?php

ini_set('max_execution_time', 500);

include_once 'SHA.php';

$sha = new SHA();

$tries = 50;
$bit_length = 18;

$total_collision = 0;
for ($i=0; $i<$tries; $i++) {
    $total_collision += $sha->collisionAttack($bit_length);
}
$result_collision = $total_collision/$tries;

echo "COLLISION ATTACK: <strong>".$result_collision."</strong><br>";

$total_preimage = 0;
for ($i=0; $i<$tries; $i++) {
    $total_preimage += $sha->preImageAttack($bit_length);
}
$result_preimage = $total_preimage/$tries;

echo "PRE-IMAGE ATTACK: <strong>".$result_preimage."</strong><br>";