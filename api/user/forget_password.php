<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

$data = json_decode(file_get_contents("php://input"), true);
require_once 'index.php';
$result = $obj->forget_password($data['memberId'], $data['code'], $data['password']);
//echo $result;
//die;
if ($result) {
    echo json_encode(array("message" => "Password has been changed", "status" => true));
} else {
    echo json_encode(array("message" => "Password didn't match", "status" => false));
}
