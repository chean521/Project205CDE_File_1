<?php

/* 
 * password Change and Check, JSON Process
 */

header("Content-Type: application/json; charset=UTF-8");
$values = json_decode($_GET['data'], false);

require_once ('MySQL_Engine/MySQL_Engine.php');
require_once ('Config/config.php');
$sql = new MySQL_Engine();
$sql->SetConnection(ConfigurationData::$database_host, ConfigurationData::$database_id, ConfigurationData::$database_pw, ConfigurationData::$database_db);
$sql->Connect();
$conn = $sql->GetConnection();

$result = null;

if($values->types == 'chk_cur')
{
    $query = "select * from user where studentID='".$values->usr_id."' AND password='".$values->pwd."';";
    $res = $conn->query($query);
    if($res->num_rows > 0)
    {
        $result = array("result" => true);
    }
    else
    {
        $result = array("result" => false);
    }
}
else if($values->types == 'chg_pwd')
{
    $query = "update user set password='".$values->pwd2."' where studentID='".$values->usr_id2."';";
    $res = $conn->query($query);
    if($res)
    {
        $result = array("result" => true);
    }
    else
    {
        $result = array("result" => false);
    }
}

$sql->Disconnect();

$json_send_data = json_encode($result);

echo $json_send_data;