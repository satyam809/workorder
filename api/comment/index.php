<?php
session_start();
require '../config.php';
class API
{
    public $con;
    public function __construct()
    {
        try {
            $this->con = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
            $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //echo "Connected successfully";
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }


    public function reply_comment($itemId, $memberId, $postDate, $body)
    {
        $sql = "insert into frk_itemComment(itemId, memberId, postDate, body) 
                    values('$itemId', '$memberId', '$postDate', '$body')";

        if ($this->con->query($sql)) {

            return true;
        } else {

            return false;
        }
    }
    public function get_comments($memberId,$itemId)
    {
        $query = "select * from frk_itemComment where memberId = '$memberId' and itemId = '$itemId'";
        $result = $this->con->query($query);
        $row = $result->fetchAll(PDO::FETCH_ASSOC);
        return $row;
    }
    public function edit_comment($itemCommentId, $itemId, $memberId, $postDate, $body)
    {
        $query = "update frk_itemComment set itemId='$itemId',memberId='$memberId',postDate='$postDate',body='{$body}' where itemCommentId = '$itemCommentId'";
        if ($this->con->query($query)) {
            return true;
        }
    }
    public function delete_comment($itemCommentId)
    {
        $sql = "delete from frk_itemComment where itemCommentId='$itemCommentId'";
        if ($this->con->query($sql)) {
            return true;
        }
    }
}
$obj = new API();
