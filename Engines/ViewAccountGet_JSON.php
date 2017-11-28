<?php
header("Content-Type: application/json; charset=UTF-8");
require_once('MySQL_Engine/MySQL_Engine.php');
require_once('Config/config.php');

$sql = new MySQL_Engine();
$sql->SetConnection(ConfigurationData::$database_host, ConfigurationData::$database_id, ConfigurationData::$database_pw, ConfigurationData::$database_db);
$sql->Connect();
$conn = $sql->GetConnection();

$values = json_decode($_GET['data'], false);

$uid = $values->uid;
$query = "";

if($uid=="")
{
    $query = "select studentID, fullname, programme, roles, created_on, status from user";
}
else
{
    $query = "select studentID, fullname, programme, roles, created_on, status from user where studentID like '".$uid."%';";
}

$result = array();

$res = $conn->query($query);

while($row = $res->fetch_array(MYSQLI_NUM))
{
    $result[] = $row;
}

$sql->Disconnect();

$json_send_data = json_encode($result);

echo $json_send_data;