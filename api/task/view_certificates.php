<?php
require_once 'index.php';

$result = $obj->view_certificates();
if ($result != '') {
    echo json_encode(array("message" => $result, "status" => true));
} else {
    echo json_encode(array("message" => "something wrong", "status" => false));
}
