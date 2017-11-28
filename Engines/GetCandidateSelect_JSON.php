<?php

header("Content-Type: application/json; charset=UTF-8");
require_once('MySQL_Engine/MySQL_Engine.php');
require_once('Config/config.php');

$sql = new MySQL_Engine();
$sql->SetConnection(ConfigurationData::$database_host, ConfigurationData::$database_id, ConfigurationData::$database_pw, ConfigurationData::$database_db);
$sql->Connect();
$conn = $sql->GetConnection();

$result = array();

$query = "select studentID, fullname from user where studentID not in ('admin');";
$res = $conn->query($query);

while($row = $res->fetch_assoc())
{
    $result[] = array($row['studentID'],$row['fullname']);
}

$sql->Disconnect();

$json_send_data = json_encode($result);

echo $json_send_data;