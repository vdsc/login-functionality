<?php
    require_once 'database_utility.php';
    require_once 'encryption_utility.php';
    
function verifyCredentials($username, $password, $salt, $stretch){
    $hash = generate_hash($password, $salt, $stretch);
    $sth = createHandler('SELECT COUNT(*) AS MyCount FROM user WHERE username=:username AND hash=:hash');
    $sth->bindParam(':hash', $hash, PDO::PARAM_STR);
    $sth->bindParam(':username', $username, PDO::PARAM_STR);
    $sth->execute();
    $results = $sth->fetchAll(PDO::FETCH_ASSOC);
    return $results[0]["MyCount"] > 0 ? true : false;
}
?>