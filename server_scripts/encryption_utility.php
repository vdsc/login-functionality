<?php
$r = 450000;//This r-value was tested by me as the approzimate value that will take the server approximately 1-second

function stretch_me($password, $salt, $iterations){
  $temp = "0";
  for($i = 0; $i < $iterations; $i++){
     $temp = hash("sha256", $temp.$password.$salt);
  }
  return $temp;
}

function getSalt(){
    $salt = openssl_random_pseudo_bytes(40, $was_strong);
    if (!$was_strong){
     die("Oh no...");
    }
    return bin2hex($salt);
}

function getStretch(){
    global $r;
    return $r + fudgeFactor($r);
}

function fudgeFactor($scalar){
    $scale = rand(0, 0.01*$scalar);//Scale = 1%*scalar
    $scale *= rand(0,1) > 0 ? (-1) : 1;//Scale = (+or-)*1%*scalar
    return $scale;
}

function generate_hash($pass, $salt, $strecth){
    $password = stretch_me($pass,$salt, $strecth);
    return $password;
}
?>