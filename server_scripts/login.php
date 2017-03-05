<?php
require_once 'database_utility.php';
require_once 'encryption_utility.php';
require_once 'decryption_utility.php';

$data = json_decode(file_get_contents('php://input'), true);
if($data["username"] && $data["password"]){//If the username and password has been sent
    if(user_exists($data["username"])){//If the user exists
         $salt = getUserSalt($data["username"]);
         $stretch = getUserStretch($data["username"]);
         $is_correct_user = verifyCredentials($data["username"], $data["password"], $salt, $stretch);
         $return_json["logged_in"] = $is_correct_user;
         echo json_encode($return_json);
         //TODO: Set the session key "logged_in" = true
    }else{//If they dont exist add them to the database
        $return_json["logged_in"] = false;
        echo json_encode($return_json);
    }
}
else{//If the username and password hasn't been sent
    $return_json["logged_in"] = false;
    echo json_encode($return_json);
}
    
?>