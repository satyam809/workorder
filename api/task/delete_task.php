<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');
require_once 'index.php';
$data = json_decode(file_get_contents("php://input"), true);
$result = $obj->delete_task($data['itemId']);
if ($result) {
    echo json_encode(array("message" => "Task is deleted successfully", "status" => true));
} else {
    echo json_encode(array("message" => "Task is not deleted", "status" => false));
}
