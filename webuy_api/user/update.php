<?php
//include_once '../config/functions.php.php';
//include_once '../objects/User.php';
//
//header("Access-Control-Allow-Origin: *");
//header("Content-Type: application/json; charset=UTF-8");
//header("Access-Control-Allow-Methods: POST");
//header("Access-Control-Max-Age: 3600");
//header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
//
//$database = new Database();
//$db = $database->getConnection();
//
//$user = new User($db);
//
//$data = json_decode(file_get_contents("php://input"));
//
//$jwt = isset($data->jwt) ? $data->jwt : "";
//
//if ($jwt) {
//
//    try {
//
//        $decoded = decodeJWT($jwt);
//
//        if ($user->update($data)) {
//
//            $jwt = makeToken($user);
//
//            http_response_code(200);
//
//            echo json_encode(
//                array(
//                    "message" => "User was updated.",
//                    "jwt" => $jwt
//                )
//            );
//
//        }
//        else {
//            http_response_code(401);
//
//            echo json_encode(array("message" => "Unable to update user."));
//        }
//
//    } catch (Exception $e) {
//
//        http_response_code(401);
//
//        echo json_encode(array(
//            "message" => "Access denied.",
//            "error" => $e->getMessage()
//        ));
//    }
//
//}