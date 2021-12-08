<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

$data = json_decode(file_get_contents("php://input"), true);
require_once 'index.php';
$result = $obj->update_task($data['title'], $data['description'], $data['deadlineDate'], $data['priority'],  $data['context'], $data['projectId'], $data['memberId'], $data['showPrivate'], $data['authorId'], $data['statusKey'], $data['itemId'], $data['statusDate']);
//echo $result;
//die;
if ($result) {
    echo json_encode(array("message" => "Task is updated successfully", "status" => true));
} else {
    echo json_encode(array("message" => "something error occurred", "status" => false));
}
