<?php
require_once 'database_utility.php';
require_once 'encryption_utility.php';
require_once 'decryption_utility.php';

function addUser($username, $pwd){
    $strecth = getStretch();
    $salt = getSalt();
    $hash = generate_hash($pwd,$salt,$strecth);
    $sth = createHandler('INSERT INTO user VALUES(:username,:salt,:stretch,:hash)');
    $sth->bindParam(':username', $username, PDO::PARAM_STR);
    $sth->bindParam(':salt', $salt, PDO::PARAM_STR);
    $sth->bindParam(':stretch', $strecth, PDO::PARAM_INT);
    $sth->bindParam(':hash', $hash, PDO::PARAM_STR);
    $sth->execute();
}

//This data is retrieved unencrypted, but it doesnt have to be. As long as it remains a standard in the database
$data = json_decode(file_get_contents('php://input'), true);
if($data["username"] && $data["password"]){//If the username and password has been sent
    if(user_exists($data["username"])){//If the user exists
        $return_json["error"] = true;
        $return_json["reason"] = "User already exists";
        echo json_encode($return_json);
    }else{//If they dont exist add them to the database
        addUser($data["username"], $data["password"]);
        $return_json["error"] = false;
        echo json_encode($return_json);
    }
}
else{//If the username and password hasn't been sent
    $return_json["error"] = true;
    $return_json["reason"] = "Incorrect Format";
    echo json_encode($return_json);
}

?>