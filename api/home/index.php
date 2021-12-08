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

    public function home($memberId)
    {
        $sql = "SELECT COUNT(memberId)as project FROM `frk_memberProject` GROUP BY memberId HAVING memberId =$memberId";
        $result = $this->con->query($sql);
        $row = $result->fetchAll(PDO::FETCH_ASSOC);
        $data['total projects'] = $row;
        $sql1 = "SELECT COUNT(memberId) as task FROM `frk_item` GROUP BY memberId HAVING memberId =$memberId";
        $result1 = $this->con->query($sql1);
        $row1 = $result1->fetchAll(PDO::FETCH_ASSOC);
        $data['total tasks'] = $row1;
        return $data;
    }
    public function my_projects($memberId)
    {
        $sql = "select frk_project.name,frk_project.projectId from frk_project inner join frk_memberProject on frk_project.projectId=frk_memberProject.projectId where frk_memberProject.memberId='$memberId'";
        $result = $this->con->query($sql);
        $row = $result->fetchAll(PDO::FETCH_ASSOC);
        return $row;
    }
    public function task_history($memberId,$itemId)
    {
        $sql = "select frk_member.title,frk_member.firstName,frk_member.middleName,frk_member.lastName,frk_itemStatus.statusKey,frk_itemStatus.statusDate from frk_member left join frk_itemStatus on frk_member.memberId=frk_itemStatus.memberId where frk_itemStatus.memberId='$memberId' and frk_itemStatus.itemId = '$itemId'";
        $result = $this->con->query($sql);
        $row = $result->fetchAll(PDO::FETCH_ASSOC);
        // foreach ($row as $key => $value) {
        //     if ($key['statusKey'] == 0) {
        //         $value['statusKeyvalue'] = "0% NEW";
        //     } else if ($key['statusKey'] == 1) {
        //         $value['statusKeyvalue'] = "20% ASSIGNED";
        //     } else if ($key['statusKey'] == 2) {
        //         $value['statusKeyvalue'] = "40% PENDING";
        //     } else if ($key['statusKey'] == 3) {
        //         $value['statusKeyvalue'] = "60% COMMENCE";
        //     } else if ($key['statusKey'] == 4) {
        //         $value['statusKeyvalue'] = "80% IN-PROGRESS";
        //     } else if ($key['statusKey'] == 5) {
        //         $value['statusKeyvalue'] = "100% COMPLETED";
        //     }
        // }
        $data['allrow'] = $row;
        $data['statusKeyvalue'] = array(0 => "0% NEW", 1 => "20% ASSIGNED", 2 => "40% PENDING", 3 => "60% COMMENCE", 4 => "80% IN-PROGRESS", 5 => "100% COMPLETED");
        return $data;
    }
    public function projects_status($memberId)
    {

        $sql = "select frk_project.name,frk_projectStatus.statusDate,frk_projectStatus.statusKey from ((frk_project inner join frk_memberProject on frk_project.projectId=frk_memberProject.projectId) inner join frk_projectStatus on frk_projectStatus.memberId=frk_memberProject.memberId) where frk_projectStatus.memberId='$memberId'";
        $result = $this->con->query($sql);
        $row = $result->fetchAll(PDO::FETCH_ASSOC);
        return $row;
    }
    public function view_rform()
    {
        $sql = "select frk_rform.reqrefer,frk_rform.atport,frk_rform.reason_request,frk_rform.propaction,frk_rform.requestby,frk_rform.daterequest,frk_rform.datedue,frk_rform.docname,frk_rform.status,frk_rform.upload,frk_rform.upload1,frk_rform.cstamp,frk_equipment.itemname,frk_rform_subcat.subcatname from ((frk_rform inner join frk_rform_subcat on frk_rform_subcat.id=frk_rform.subcategory)
        inner join frk_equipment on frk_equipment.id=frk_rform.eq_id)";
        $result = $this->con->query($sql);
        $row = $result->fetchAll(PDO::FETCH_ASSOC);
        return $row;
    }
    public function show_country()
    {
        $sql = "select * from frk_country";
        $result = $this->con->query($sql);
        $row = $result->fetchAll(PDO::FETCH_ASSOC);
        return $row;
    }
}
$obj = new API();
