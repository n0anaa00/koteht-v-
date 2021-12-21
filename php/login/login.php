<?php

use Firebase\JWT\JWT;

require_once '../../inc/functions.php';
require_once '../../inc/headers.php';


if (isset($_SERVER['PHP_AUTH_USER'])) {
    
    if (checkUser(openDb(), $_SERVER['PHP_AUTH_USER'], $_SERVER["PHP_AUTH_PW"])) {

        
        $payload = array(
            "iat" => time(),
            "sub" => $_SERVER['PHP_AUTH_USER']
        );

        
        $jwt = JWT::encode($payload, base64_encode('mysecret'), 'HS256');

        
        echo  json_encode(array("info" => "Kirjauduit sisään", "token" => $jwt));
        header('Content-Type: application/json');
        exit;
    }
}


echo '{"info":"Kirjautuminen epäonnistui"}';
header('Content-Type: application/json');
header('HTTP/1.1 401');
exit;
