<?php
header("Content-Type: application/json; charset=UTF-8");

require_once('MySQL_Engine/MySQL_Engine.php');
require_once('Config/config.php');

$sql = new MySQL_Engine();
$sql->SetConnection(ConfigurationData::$database_host, ConfigurationData::$database_id, ConfigurationData::$database_pw, ConfigurationData::$database_db);
$sql->Connect();
$conn = $sql->GetConnection();

$values = json_decode($_GET['data'], false);

$query='';

if($values->action == 'approve')
{
    $query = "update user set status='active' where studentID='".$values->target."';";
}
else if($values->action == 'reject')
{
    $query = "delete from user where studentID='".$values->target."';";
}

$res = $conn->query($query);
$data = null;

if($res)
{
    $data = array("result"=>"success");
}
else
{
    $data = array("result"=>"failed");
}

$sql->Disconnect();

$json_send_data = json_encode($data);

echo $json_send_data;