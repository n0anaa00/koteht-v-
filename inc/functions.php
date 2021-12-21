<?php

function openDb(): object {
    $ini= parse_ini_file("../../config.ini", true);
    $host = $ini['host'];
    $database = $ini['database'];
    $user = $ini['user'];
    $password = $ini['password'];
    $db = new PDO("mysql:host=$host;dbname=$database;charset=utf8",$user,$password);
    $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    return $db;
}

function selectAsJson(object $db,string $sql): void {
    $query = $db->query($sql);
    $results = $query->fetchAll(PDO::FETCH_ASSOC);
    header('HTTP/1.1 200 OK');
    echo json_encode($results);
}

function executeInsert(object $db, string $sql): int {
    $query = $db->query($sql);
    return  $db->lastInsertId();
}

function returnError(PDOException $pdoex): void {
    header('HTTP/1.1 500 Internal Server Error');
    $error = array('error' => $pdoex->getMessage());
    echo json_encode($error);
    exit;
}

function checkUser(PDO $dbcon, $username, $passwd){
    
    $username = filter_var($username, FILTER_SANITIZE_STRING);
    $passwd = filter_var($passwd, FILTER_SANITIZE_STRING);

    try{
      
        $sql = "SELECT password FROM user WHERE username=?";
        
        $prepare = $dbcon->prepare($sql);
        $prepare->execute(array($username));
        $rows = $prepare->fetchAll();

       
        foreach($rows as $row){
            $pw = $row["password"];
            if( $pw === $passwd ){
                return true;
            }
        }
        
        return false;
        
    }catch(PDOException $e){
        echo '<br>'.$e->getMessage();
    }
}