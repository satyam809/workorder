<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');


$data = json_decode(file_get_contents("php://input"), true);
require_once 'index.php';
$result = $obj->edit_profile($data['email'], $data['title'], $data['firstName'], $data['middleName'],  $data['lastName'], $data['zipCode'], $data['city'], $data['stateCode'], $data['countryId'], $data['phone'], $data['mobile'], $data['fax'], $data['password'], $data['salt'], $data['autoLogin'], $data['timeZone'], $data['expirationDate'], $data['lastLoginDate'], $data['lastLoginAddress'], $data['creationDate'], $data['lastChangeDate'], $data['visits'], $data['badAccess'], $data['level'], $data['activation'], $data['authorId'], $data['enabled'], $data['username'], $data['memberId']);

if ($result) {
    echo json_encode(array("message" => "Profile is updated successfully", "status" => true));
} else {
    echo json_encode(array("message" => "something error occurred", "status" => false));
}
