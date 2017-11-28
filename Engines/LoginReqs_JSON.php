<?php

/* Login Requesting, JSON Engine */

header("Content-Type: application/json; charset=UTF-8");

require_once('Config/config.php');

$conn = new mysqli(ConfigurationData::$database_host, ConfigurationData::$database_id, ConfigurationData::$database_pw, ConfigurationData::$database_db);

$values = json_decode($_GET['data'], false);

$query = "select studentID, fullname, roles from user where studentID='".$values->uid."' and password='".$values->pwd."' and status='active';";
$res = $conn->query($query);
$data = null;

if($res->num_rows > 0)
{   
    $data = $res->fetch_assoc();
    
    require_once('SessionManager/SessionManager.php');
    $sess = new SessionManager();
    
    $sess->set_session_data('login', true); 
    $sess->set_session_data('detail_name', $data['fullname']);
    $sess->set_session_data('detail_id', $data['studentID']);
    $sess->set_session_data('detail_role', $data['roles']);
}
else
{
    $data = array("studentID"=>null);
}

$conn->close();

$json_send_data = json_encode($data);

echo $json_send_data;