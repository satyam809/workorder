<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');


$data = json_decode(file_get_contents("php://input"), true);
require_once 'index.php';
$result = $obj->registration($data['email'], $data['title'], $data['firstName'], $data['middleName'],  $data['lastName'], $data['zipCode'], $data['city'], $data['stateCode'], $data['countryId'], $data['phone'], $data['mobile'], $data['fax'], $data['username'], $data['password'], $data['salt'], $data['autoLogin'], $data['timeZone'], $data['expirationDate'], $data['lastLoginDate'], $data['lastLoginAddress'], $data['creationDate'], $data['lastChangeDate'], $data['visits'], $data['badAccess'], $data['level'], $data['activation'], $data['authorId'], $data['enabled']);
if ($result == true) {
    echo json_encode(array('message' => 'Registration successful', 'status' => true));
} else {
    echo json_encode(array('message' => 'Registration fail', 'status' => false));
}
