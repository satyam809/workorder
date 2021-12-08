<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

$data = json_decode(file_get_contents("php://input"), true);
require_once 'index.php';
if ($obj->logout($data['username'])) {
    echo json_encode(array("message" => "You are logged out", "status" => true));
} else {
    echo json_encode(array("message" => "something error occurred", "status" => false));
}
