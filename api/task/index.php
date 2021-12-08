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

    public function create_task($title, $description, $deadlineDate, $priority, $context, $projectId, $memberId, $showPrivate, $authorId, $statusKey, $statusDate)
    {
        $sql = "insert into frk_item(title, description, deadlineDate, priority,context, projectId, memberId, showPrivate, authorId) 
                    values('$title', '$description', '$deadlineDate', '$priority', '$context', '$projectId', '$memberId', '$showPrivate', '$authorId')";

        
        if ($this->con->query($sql)) {
            $lastInsertId = $this->con->lastInsertId();
            $sql2 = "insert into frk_itemStatus(itemId,statusDate,statusKey,memberId)values('$lastInsertId','$statusDate','$statusKey','$memberId')";
            if ($this->con->query($sql2)) {
                return true;
            }
        } else {

            return false;
        }
    }
    public function single_task($itemId, $memberId, $projectId)
    {
        $query = "select frk_item.itemId,frk_member.memberId,frk_item.title,frk_item.description,frk_item.deadlineDate,frk_item.priority,frk_item.showPrivate,frk_item.context,frk_member.username,frk_project.name,frk_itemStatus.statusKey from (((frk_item left join frk_member on frk_member.memberId=frk_item.memberId)
         left join frk_project on frk_project.projectId=frk_item.projectId)
         left join frk_itemStatus on frk_item.itemId=frk_itemStatus.itemId
         ) where (frk_item.itemId='$itemId' and frk_item.memberId='$memberId') and (frk_item.projectId='$projectId')";
        //  echo $query; die;
        $result = $this->con->query($query);
        $row = $result->fetch(PDO::FETCH_ASSOC);
        return $row;
    }
    public function view_task($memberId)
    {
        $query = "select frk_item.itemId,frk_item.projectId,frk_item.title,frk_item.deadlineDate,frk_item.priority,frk_item.showPrivate,frk_item.context,frk_member.username,frk_project.name,frk_itemStatus.statusKey,count(frk_itemComment.itemCommentId) as comment from ((((frk_item left join frk_member on frk_member.memberId=frk_item.itemId)
        left join frk_project on frk_project.projectId=frk_item.projectId)
        left join frk_itemStatus on frk_item.itemId=frk_itemStatus.itemId)
        left join frk_itemComment on frk_item.itemId=frk_itemComment.itemId) where frk_item.memberId=$memberId GROUP BY frk_item.itemId ORDER BY frk_item.itemId desc";
        $result = $this->con->query($query);
        $row = $result->fetchAll(PDO::FETCH_ASSOC);
        return $row;
    }
    public function update_task($title, $description, $deadlineDate, $priority, $context, $projectId, $memberId, $showPrivate, $authorId, $statusKey, $itemId, $statusDate)
    {
        $query = "update frk_item set title='{$title}', description='{$description}', deadlineDate='{$deadlineDate}',priority='{$priority}',context='{$context}',projectId='{$projectId}',memberId='{$memberId}',showPrivate='{$showPrivate}',authorId='{$authorId}' where itemId = '$itemId'";
        if ($this->con->query($query)) {
            $query1 = "update frk_itemStatus set statusDate='{$statusDate}',statusKey='{$statusKey}',memberId='{$memberId}' where itemId = '$itemId'";
            if ($this->con->query($query1)) {
                return true;
            }
        }
    }
    public function delete_task($itemId)
    {
        $sql = "DELETE FROM frk_item WHERE itemId='$itemId'";
        if ($this->con->query($sql)) {
            $sql1 = "DELETE FROM frk_itemStatus WHERE itemId='$itemId'";
            if ($this->con->query($sql1)) {
                return true;
            }
        }
    }
    public function view_certificates()
    {
        $query = "select * from `frk_certificates`";
        $result = $this->con->query($query);
        $row = $result->fetchAll(PDO::FETCH_ASSOC);

        foreach ($row as $val) {
            $query = "select subcatname from `frk_certificates_subcat` where id=" . $val['subcategory'];
            $result = $this->con->query($query);
            $sub = $result->fetch(PDO::FETCH_ASSOC);
            $val['subcategory']  = $sub['subcatname'];
            $newArra[] = $val;
        }
        return $newArra;
    }
    public function view_equipment()
    {
        $query = "select * from `frk_equipment`";
        $result = $this->con->query($query);
        $row = $result->fetchAll(PDO::FETCH_ASSOC);
        foreach ($row as $val) {
            $query = "select subcatname from `frk_equipment_subcat` where id=" . $val['subcategory'];
            $result = $this->con->query($query);
            $sub = $result->fetch(PDO::FETCH_ASSOC);
            $val['subcategory']  = $sub['subcatname'];
            $newArra[] = $val;
        }
        return $newArra;
    }
    public function view_manning()
    {
        $query = "select * from `frk_manning`";
        $result = $this->con->query($query);
        $row = $result->fetchAll(PDO::FETCH_ASSOC);
        foreach ($row as $val) {
            $query = "select rank_name from `frk_manning_rank` where id=" . $val['subcat'];
            $result = $this->con->query($query);
            $sub = $result->fetch(PDO::FETCH_ASSOC);
            $val['subcategory']  = $sub['rank_name'];
            $newArra[] = $val;
        }
        return $newArra;
    }
    public function view_survey()
    {
        $query = "select * from `frk_survey`";
        $result = $this->con->query($query);
        $row = $result->fetchAll(PDO::FETCH_ASSOC);
        foreach ($row as $val) {
            $query = "select subcatname from `frk_survey_subcat` where id=" . $val['subcat'];
            $result = $this->con->query($query);
            $sub = $result->fetch(PDO::FETCH_ASSOC);
            $val['subcategory']  = $sub['subcatname'];
            $newArra[] = $val;
        }
        return $newArra;
        //return $row;
    }
    public function show_members()
    {
        $sql = "select memberId,title,firstName,middleName from `frk_member`";
        $result = $this->con->query($sql);
        $row = $result->fetchAll(PDO::FETCH_ASSOC);
        return $row;
    }
}
$obj = new API();
