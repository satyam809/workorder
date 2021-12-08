<?php

require_once 'index.php';
$result = $obj->view_rform();

if ($result) {
    echo json_encode(array("message" => $result, "status" => true));
} else {
    echo json_encode(array("message" => "No Data", "status" => false));
}
