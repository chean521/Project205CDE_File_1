<?php

header("Content-Type: application/json; charset=UTF-8");

$values = json_decode($_GET['data'], false);

$res_msg = 'err_0';

if(strlen($values->uid) != 9)
{
    $res_msg = 'err_1';
}
else
{
    require_once ('MySQL_Engine/MySQL_Engine.php');
    require_once ('Config/config.php');
    $sql = new MySQL_Engine();
    $sql->SetConnection(ConfigurationData::$database_host, ConfigurationData::$database_id, ConfigurationData::$database_pw, ConfigurationData::$database_db);
    $sql->Connect();
    $conn = $sql->GetConnection();

    $result = $conn->query("select * from user where studentID='".$values->uid."';");
    
    if($result->num_rows > 0)
    {
        $res_msg = 'err_2';
    }
    else
    {
        $res_msg = 'err_0';
    }
    
    $sql->Disconnect();
}

$compiled_data = array("result"=>$res_msg);

$json_send_data = json_encode($compiled_data);

echo $json_send_data;