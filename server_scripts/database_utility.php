<?php
    $dbhandle = new PDO("sqlite:../database/auth.db") or die("Failed to open DB");
    if (!$dbhandle) die ($error);
    
    function createHandler($query){
        global $dbhandle;
        return $dbhandle->prepare($query);
    }
    
    function user_exists($username){
        $statement = createHandler('SELECT username FROM user WHERE username=:username');
        $statement->bindParam(':username',$username, PDO::PARAM_STR);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        //print_r($results);
        return $results[0]["username"] == $username;
    }
    
    function getUserSalt($username){
        $statement = createHandler('SELECT salt FROM user WHERE username=:username');
        $statement->bindParam(':username',$username, PDO::PARAM_STR);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $results[0]["salt"];
    }
    
    function getUserStretch($username){
        $statement = createHandler('SELECT stretch FROM user WHERE username=:username');
        $statement->bindParam(':username',$username, PDO::PARAM_STR);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $results[0]["stretch"];
    }
?>