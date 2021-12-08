<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

$data = json_decode(file_get_contents("php://input"), true);
require_once 'index.php';
$result = $obj->login($data['username'], $data['password']);
//echo $result;
//die;
if ($result) {
    echo json_encode(array("message" => $result, "status" => true));
} else {
    echo json_encode(array("message" => "Incorrect username or password", "status" => false));
}
