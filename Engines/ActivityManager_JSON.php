<?php
header("Content-Type: application/json; charset=UTF-8");
$dt = json_decode($_GET['data'], false);

require_once('MySQL_Engine/MySQL_Engine.php');
require_once('Config/config.php');

$sql = new MySQL_Engine();
$sql->SetConnection(ConfigurationData::$database_host, ConfigurationData::$database_id, ConfigurationData::$database_pw, ConfigurationData::$database_db);
$sql->Connect();
$conn = $sql->GetConnection();
$pid = $dt->activity;

if($dt->type == "delete")
{
    $query = "delete from votes where activity_id='".$pid."';";
    $query .= "delete from candidate where activity_id='".$pid."';";
    $query .= "delete from voteactivity where activity_id='".$pid."';";

    $central_data = null;

    if($conn->multi_query($query))
    {
        do
        {
            if($res = $conn->store_result())
            {
                if($res)
                {
                    $central_data = 'true';
                    $res->free_result();
                }
            }
        }
        while($conn->more_results() && $conn->next_result());
    }
    else
    {
        $central_data = 'false';
    }

    $sql->Disconnect();
    $compiled_data = array("result"=>$central_data);

    $json_send_data = json_encode($compiled_data);

    echo $json_send_data;
}