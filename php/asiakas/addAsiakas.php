<?php

require_once '../../inc/headers.php';
require_once '../../inc/functions.php';




$input = json_decode(file_get_contents('php://input'));

$asosoite = filter_var($input->asosoite,FILTER_SANITIZE_STRING);
$postinro = filter_var($input->postinro,FILTER_SANITIZE_NUMBER_INT);
$postitmp  = filter_var($input->postitmp,FILTER_SANITIZE_STRING);
$puhelin = filter_var($input->puhelin,FILTER_SANITIZE_NUMBER_INT);
$email = filter_var($input->email,FILTER_SANITIZE_STRING);
$assukunimi = filter_var($input->assukunimi,FILTER_SANITIZE_STRING);
$asetunimi = filter_var($input->asetunimi,FILTER_SANITIZE_STRING);
$astunnus = filter_var($input->astunnus,FILTER_SANITIZE_STRING);

try {
    $db= openDb();    
    $query = $db->prepare('insert into asiakas (astunnus, asetunimi, assukunimi,
    asosoite, postinro, postitmp, puhelin, email) 
    values (:astunnus, :asetunimi, :assukunimi, :asosoite, :postinro, 
    :postitmp, :puhelin, :email)');
    $query->bindValue(':astunnus',$astunnus, PDO::PARAM_STR);
    $query->bindValue(':asetunimi',$asetunimi, PDO::PARAM_STR);
    $query->bindValue(':assukunimi',$assukunimi, PDO::PARAM_STR);
    $query->bindValue(':asosoite', $asosoite, PDO::PARAM_STR);
    $query->bindValue(':postinro',$postinro, PDO::PARAM_STR);
    $query->bindValue(':postitmp',$postitmp, PDO::PARAM_STR);
    $query->bindValue(':puhelin', $puhelin, PDO::PARAM_STR);
    $query->bindValue(':email',$email, PDO::PARAM_STR);
    $query->execute();
    header('HTTP/1.1 200 OK');
    $data = array('asid' => $db->lastInsertId(),'astunnus' => $astunnus, 'asetunimi' => $asetunimi,'assukunimi' => $assukunimi, 'asosoite' => $asosoite, 'postinro' => $postinro, 'postitmp' => $postitmp, 'puhelin' => $puhelin, 'email' => $email);
    print json_encode($data);

} catch (PDOException $pdoex) {
    returnError($pdoex);
}