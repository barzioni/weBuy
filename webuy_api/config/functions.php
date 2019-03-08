<?php
require '../vendor/autoload.php';
include_once __DIR__ . '/core.php';
include_once __DIR__ . '/Database.php';

use \Firebase\JWT\JWT;


function makeToken()
{
    $token = array(
        "iss" => "http://example.org", // Issuer | who created and singed this token
        "aud" => "http://example.com", // Audience | what is this token for
        "iat" => 1356999524, // issued at
        "nbf" => 1357000000, // not valid before
//        "data" => array()
    );

    return JWT::encode($token, getJWTkey());

}

function decodeJWT($jwt)
{
    return JWT::decode($jwt, getJWTkey(), array('HS256'));
}


function validToken($token)
{

    if ($token) {
        $userToken = decodeJWT($token);
        if ($userToken) {
            return true;
        }
    }
    return false;
}


function dd($arg)
{
    var_dump($arg);
    die();
}

function response($message = '', $data = null, $status_code = null)
{

    header('Content-type:application/json;charset=utf-8');

    if ($status_code) {
        http_response_code($status_code);
    } else {
        http_response_code(200);
    }

    echo json_encode(array(
        "message" => $message,
        "data" => $data,
    ));

}

