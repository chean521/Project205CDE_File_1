<?php
require ('Config/config.php');

if(!isset($_POST))
{
    echo '<script>alert("Values not set.");</script>';
    echo '<script>self.close();</script>';
}
else 
{
    $con = new mysqli(ConfigurationData::$database_host, ConfigurationData::$database_id, ConfigurationData::$database_pw, ConfigurationData::$database_db);
    $file_name = array();
    $swap = array();
    $id = array();
    $desc = array();

    foreach($_POST['cand_id'] as $pid)
    {
        $id[] = $pid;
    }

    foreach($_POST['cand_desc'] as $dec)
    {
        $desc[] = $dec;
    }
    
    foreach($_POST['act'] as $data)
    {
        $swap[] = $data;
    }
   
    foreach($_FILES['photo']['error'] as $key => $error)
    {
        $tmp_name = $_FILES['photo']['tmp_name'][$key];
        $name = $_FILES['photo']['name'][$key];
        
        $file_name[] = $name;
        $b_name = basename($name);
        $tg_file = ConfigurationData::$target_folder.$b_name;
        
        if(!file_exists($tg_file))
        {
            move_uploaded_file($tmp_name, $tg_file);
        }
    }
    
    $act_id = 0;
    
    while(true)
    {
        $rand_id = rand(10000,99999);
        
        $res = $con->query('select activity_id from voteactivity where activity_id="'.$rand_id.'";');
        
        if($res->num_rows == 0)
        {
            $act_id = $rand_id;
            $res->free();
            break;
        }
        
        $res->free();
    }
    
    $con->close();
    $con2 = new mysqli(ConfigurationData::$database_host, ConfigurationData::$database_id, ConfigurationData::$database_pw, ConfigurationData::$database_db);
    
    $query1 = "INSERT INTO voteactivity(activity_id,activity_title,description,creation_date,created_by,start_date,end_date,category,restriction) values (".$act_id.",'?','?',now(),'admin','?','?','?','?');";

    $tmp_query = str_replace(array('%','?'), array('%%','%s'), $query1);
    $bind = vsprintf($tmp_query, $swap);
    
    
    
    $query2 = '';

    for($i=0; $i<sizeof($id); $i++)
    {
        $query2 .= "insert into candidate(activity_id, cand_id, cand_desc, photo_loc) VALUES (".$act_id.",'".$id[$i]."','".$desc[$i]."','".$file_name[$i]."');";
    }
    
    $bind_query = $bind.$query2;

    if($con2->multi_query($bind_query) === true)
    {
        $con2->close();
        echo '<script>alert("Record Added Successfully!");</script>';
        echo '<script>self.close();</script>';
    }
    else
    {
        echo 'Error: '.$con2->error;
        $con2->close();
    }
}
