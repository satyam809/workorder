<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');


$data = json_decode(file_get_contents("php://input"), true);
require_once 'index.php';
$result = $obj->delete_comment($data['itemCommentId']);
if ($result == true) {
    echo json_encode(array('message' => 'Comment is deleted successfully', 'status' => true));
} else {
    echo json_encode(array('message' => 'something wrong happened', 'status' => false));
}
