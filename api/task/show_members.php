<?php

require_once 'index.php';
$result = $obj->show_members();
if ($result) {
    echo json_encode(array('message' => $result, 'status' => true));
} else {
    echo json_encode(array('message' => 'something wrong', 'status' => false));
}
