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

    public function login($username, $password)
    {
        $pass = md5($password);
        $query = "select * from frk_member where username='$username' and password='$pass'"; //print_r($query);die;
        $res = $this->con->query($query);
        //print_r(mysqli_num_rows($res));die;
        if ($res->rowCount() > 0) {
            $_SESSION['login'] = $username;
            //$_SESSION['password'] = $password;
            $sql = "select memberId,email,phone,username from frk_member where username = '$username'";
            $result = $this->con->query($sql);
            $row = $result->fetch(PDO::FETCH_ASSOC);
            return $row;
            //return true;
        }
    }
    public function registration($email, $title, $firstName, $middleName, $lastName, $zipCode, $city, $stateCode, $countryId, $phone, $mobile, $fax, $username, $password, $salt, $autoLogin, $timeZone, $expirationDate, $lastLoginDate, $lastLoginAddress, $creationDate, $lastChangeDate, $visits, $badAccess, $level, $activation, $authorId, $enabled)
    {
        $pass = md5($password);
        $sql = "insert into frk_member(email, title, firstName, middleName, lastName, zipCode, city, stateCode, countryId, phone, mobile, fax, username, password, salt, autoLogin, timeZone, expirationDate,lastLoginDate,lastLoginAddress,creationDate,lastChangeDate,visits,badAccess,level,activation,authorId,enabled) 
                    values('$email', '$title', '$firstName', '$middleName', '$lastName', '$zipCode', '$city', '$stateCode', '$countryId', '$phone', '$mobile', '$fax', '$username', '$pass', '$salt', '$autoLogin', '$timeZone', '$expirationDate','$lastLoginDate','$lastLoginAddress','$creationDate','$lastChangeDate','$visits','$badAccess','$level','$activation','$authorId','$enabled')";

        if ($this->con->query($sql)) {

            return true;
        } else {

            return false;
        }
    }
    public function get_profile($memberId)
    {
        $query = "select * from frk_member where memberId = '$memberId'";
        $result = $this->con->query($query);
        $row = $result->fetch(PDO::FETCH_ASSOC);
        return $row;
    }
    public function edit_profile($email, $title, $firstName, $middleName, $lastName, $zipCode, $city, $stateCode, $countryId, $phone, $mobile, $fax, $password, $salt, $autoLogin, $timeZone, $expirationDate, $lastLoginDate, $lastLoginAddress, $creationDate, $lastChangeDate, $visits, $badAccess, $level, $activation, $authorId, $enabled, $username, $memberId)
    {
        $pass = md5($password);
        $query = "update frk_member set email='{$email}',title='{$title}', firstName='{$firstName}',middleName='{$middleName}', lastName='{$lastName}',zipCode='{$zipCode}',city='{$city}',stateCode='{$stateCode}',countryId='{$countryId}',phone='{$phone}',mobile='{$mobile}',fax='{$fax}',password='{$pass}',salt='{$salt}',autoLogin='{$autoLogin}',timeZone='{$timeZone}',expirationDate='{$expirationDate}',lastLoginDate='{$lastLoginDate}',lastLoginAddress='{$lastLoginAddress}',creationDate='{$creationDate}',lastChangeDate='{$lastChangeDate}',visits='{$visits}',badAccess='{$badAccess}',level='{$level}',activation='{$activation}',authorId='{$authorId}',enabled='{$enabled}',username='{$username}' where memberId = '{$memberId}'";
        if ($this->con->query($query)) {
            return true;
        } else {
            return false;
        }
    }
    public function logout($username)
    {
        $_SESSION['login'] == $username;
        //session_destroy();
        unset($_SESSION['login']);
        return true;
    }
    public function forget_password_form($username, $password)
    {
        $query = "SELECT email from frk_member where username='$username'";
        $result = $this->con->query($query);
        $pass = md5($password);
        $row = $result->fetchAll(PDO::FETCH_ASSOC);
        $to = $row[0]['email'];
        $subject = "Password";
        $txt = "Your password is : $password";
        $headers = "From: satyam@cidev.in" . "\r\n";
        if (mail($to, $subject, $txt, $headers)) {
            $sql = "update frk_member set password='{$pass}' where username = '$username'";

            if ($this->con->query($sql)) {

                return true;
            }
        }
    }
}
$obj = new API();
