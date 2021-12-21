<?php
require_once '../../inc/headers.php';
require_once '../../inc/functions.php';


$input = json_decode(file_get_contents('php://input'));
$asetunimi = filter_var($input->asetunimi,FILTER_SANITIZE_STRING);
$assukunimi = filter_var($input->assukunimi,FILTER_SANITIZE_STRING);
$asosoite = filter_var($input->asosoite,FILTER_SANITIZE_STRING);
$postinro = filter_var($input->postinro,FILTER_SANITIZE_STRING);
$postitmp = filter_var($input->postitmp,FILTER_SANITIZE_STRING);
$puhelin = filter_var($input->puhelin,FILTER_SANITIZE_STRING);
$email = filter_var($input->email,FILTER_SANITIZE_STRING);
$cart = $input->cart;


$db = null;
try {
    
    $db = openDb();
    
    $db->beginTransaction();
    
    $sql = "insert into asiakas (asetunimi, assukunimi ,asosoite,postinro,postitmp,puhelin,email) values
    ('" .
        filter_var($asetunimi,FILTER_SANITIZE_STRING) . "','" .
        filter_var($assukunimi,FILTER_SANITIZE_STRING) . "','" .
        filter_var($asosoite,FILTER_SANITIZE_STRING) . "','" .
        filter_var($postinro,FILTER_SANITIZE_STRING) . "','" .
        filter_var($postitmp,FILTER_SANITIZE_STRING) . "','" .
        filter_var($puhelin,FILTER_SANITIZE_STRING) . "','" .
        filter_var($email,FILTER_SANITIZE_STRING)
    . "')";

    $asid = executeInsert($db,$sql);

    
    $sql = "insert into tilaus (asid) values ($asid)";
    $tilausnro = executeInsert($db,$sql);

    
    foreach ($cart as $product) {
        $sql = "insert into tilausrivi (tilausnro,kirjaid,kpl) values ("
        .
            $tilausnro . "," .
            $product->kirjaid . "," .
            $product->amount
        . ")";
        executeInsert($db,$sql);
    }

    
    $db->commit();

    
    header('HTTP/1.1 200 OK');
    $data = array('id' => $asid);
    print json_encode($data);
}
catch (PDOException $pdoex) {
    
    $db->rollback();
    
    returnError($pdoex);
}

