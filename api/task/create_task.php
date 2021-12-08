<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');


$data = json_decode(file_get_contents("php://input"), true);
require_once 'index.php';
$result = $obj->create_task($data['title'], $data['description'], $data['deadlineDate'], $data['priority'],  $data['context'], $data['projectId'], $data['memberId'], $data['showPrivate'], $data['authorId'], $data['statusKey'], $data['statusDate']);
if ($result) {
    echo json_encode(array('message' => 'Task is created', 'status' => true));
} else {
    echo json_encode(array('message' => 'Task is not created', 'status' => false));
}
