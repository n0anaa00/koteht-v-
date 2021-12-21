<?php
// firebase\JWT käyttöön.
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

require_once '../../inc/functions.php';
require_once '../../inc/headers.php';


$requestHeaders =  apache_request_headers();


if( isset( $requestHeaders['authorization'] ) ){

    
    $auth_value = explode(' ', $requestHeaders['authorization']);

    
    if( $auth_value[0] === 'Bearer' ){

        
        $token = $auth_value[1];

        try{
           
            $decoded = JWT::decode($token, new Key(base64_encode('mysecret'), 'HS256')  );

            
            $username = $decoded->sub;

            
            echo  json_encode( array("message"=>"Moi ".$username ."!") ); 
            
        }catch(Exception ){
            echo  json_encode( array("message"=>"Ei käyttöoikeutta!") );
        }

    }

}
