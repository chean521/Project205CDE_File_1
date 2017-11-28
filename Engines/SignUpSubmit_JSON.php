<?php

header("Content-Type: application/json; charset=UTF-8");

$values = json_decode($_POST['data'], false);

require_once ('MySQL_Engine/MySQL_Engine.php');
require_once ('Config/config.php');
$sql = new MySQL_Engine();
$sql->SetConnection(ConfigurationData::$database_host, ConfigurationData::$database_id, ConfigurationData::$database_pw, ConfigurationData::$database_db);
$sql->Connect();
$conn = $sql->GetConnection();

$query = "insert into user(studentID,fullname,programme,roles,password,created_by,created_on,status)";
$query .= " values (?,?,?,?,?,?,now(),?);";

$stmt = $conn->prepare($query);
$stmt->bind_param('sssssss', $values->uid, $values->fname, $values->prog, $roles, $values->pwd, $created, $stat);
$roles = 'student';
$created = 'admin';
$stat = 'pending';
$stmt->execute();

$result = null;

if($stmt)
{
    $result = array("result" => true);
}
else
{
    $result = array("result" => false);
}

$stmt->close();
$sql->Disconnect();

$json_send_data = json_encode($result);

echo $json_send_data;