<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');


$data = json_decode(file_get_contents("php://input"), true);
require_once 'index.php';
$result = $obj->reply_comment($data['itemId'], $data['memberId'], $data['postDate'], $data['body']);
if ($result == true) {
    echo json_encode(array('message' => 'Comment is added successfully', 'status' => true));
} else {
    echo json_encode(array('message' => 'something wrong happened', 'status' => false));
}
