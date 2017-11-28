<?php
header("Content-Type: application/json; charset=UTF-8");
require_once('MySQL_Engine/MySQL_Engine.php');
require_once('Config/config.php');

$sql = new MySQL_Engine();
$sql->SetConnection(ConfigurationData::$database_host, ConfigurationData::$database_id, ConfigurationData::$database_pw, ConfigurationData::$database_db);
$sql->Connect();

$result = null;
$values = json_decode($_GET['data'], false);

if($values->types == "gets")
{
    $res = $sql->Stored_Proc_Query('GetActivity_Result', array($values->pid));
    $sql->Disconnect();
    $result = $res;
}
else if($values->types == "live")
{
    $res = $sql->Stored_Proc_Query('GetCandDetails_Vote', array($values->pid));
    $sql->Disconnect();
    $ids = array();
    $names = array();
    
    foreach($res as $row)
    {
        $ids[] = $row['cand_id'];
        $names[] = $row['fullname'];
    }
    
    $sql->Connect();
    $conn = $sql->GetConnection();
    $r = array();
    
    $q = '';
    
    for($i=0; $i<sizeof($ids); $i++)
    {
        $q .= 'Call GetNoVote_Result("'.$values->pid.'", "'.$ids[$i].'");';
    }
    
    if($conn->multi_query($q))
    {
        do
        {
            if($res = $conn->store_result())
            {
                $dt = $res->fetch_array(MYSQLI_NUM);
                $r[] = $dt[0];
                $res->free();
            }
        }
        while($conn->more_results() && $conn->next_result());
    }
    
    $result = array();
    $result[] = $ids;
    $result[] = $names;
    $result[] = $r;
    
    $sql->Disconnect();
}

$json_send_data = json_encode($result);

echo $json_send_data;