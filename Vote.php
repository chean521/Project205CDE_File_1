<?php
require('Engines/SessionManager/SessionManager.php');
require('Engines/MySQL_Engine/MySQL_Engine.php');
require('Engines/Config/config.php');

$Sess = new SessionManager();
$User_Data = array($Sess->get_session_data('detail_id'),$Sess->get_session_data('detail_name'),$Sess->get_session_data('detail_role'));
$activity_id = $_GET['pid'];

if($User_Data[2] == 'admin')
{
    echo '<script>alert("Admin not allowed for voting.");</script>';
    echo '<script>self.close();</script>';
}
else
{
    $sql = new MySQL_Engine();
    $sql->SetConnection(ConfigurationData::$database_host, ConfigurationData::$database_id, ConfigurationData::$database_pw, ConfigurationData::$database_db);
    $sql->Connect();
    $result = $sql->Stored_Proc_Query('GetCandDetails_Vote', array($activity_id));
    $sql->Disconnect();
    
    $GetSetting = simplexml_load_file('Engines/Config/Setting.xml') or die();
    $GetCand = (string)$GetSetting->config->allowCand;
    
    if((bool)$GetCand == false)
    {
        $isAllowed = true;
        
        foreach($result as $rows)
        {
            if($rows['cand_id'] == $User_Data[0])
            {
                $isAllowed = false;
            }
        }
        
        if($isAllowed == false)
        {
            echo '<script>alert("Candidate for this event not allowed for voting.");</script>';
            echo '<script>self.close();</script>';
        }
    }
    else
    {
        $sql->Connect();
        $query = "select start_date, end_date from voteactivity where activity_id=?";
        $result2 = $sql->Single_Line_Query($query, "i", array($activity_id));
        
        
        $today = date('m/d/Y');
        $end_date = strtotime($result2[0]['end_date']);
        $start_date = strtotime($result2[0]['start_date']);
        $formatted_end_date = date('m/d/Y', $end_date);
        $formatted_start_date = date('m/d/Y', $start_date);
        
        if($formatted_start_date > $today)
        {
            echo '<script>alert("Event haven\'t started yet!");</script>';
            echo '<script>self.close();</script>';
        }
        else if($today > $formatted_end_date)
        {
            echo '<script>alert("Event Expired!");</script>';
            echo '<script>self.close();</script>';
        }
        else
        {
            $sql->Disconnect();
            $sql->Connect();
            $query2 = 'GetVoteCountBySingle';
            $result2 = $sql->Stored_Proc_Query($query2, array($activity_id,$User_Data[0]));
            
            if($result2[0]['result'] > 0)
            {
                echo '<script>alert("Voters had vote this event, permission rejected!");</script>';
                echo '<script>self.close();</script>';
            }
            else
            {
                if($_SERVER['REQUEST_METHOD'] == 'GET' && !empty($_GET['voted_candidate']))
                {
                    $choosed = $_GET['voted_candidate'];
                    
                    $query3 = "insert into votes(activity_id, studentID, candidate_id, choose_date) values (".$activity_id.",'".$Sess->get_session_data('detail_id')."','".$choosed."',now());";
                    $sql->Disconnect();
                    $sql->Connect();
                    $result3 = $sql->GetConnection()->query($query3);
                    
                    if($result3)
                    {
                        echo '<script>alert("Vote candidate successfully!");</script>';
                        echo '<script>self.close();</script>';
                    }
                    else
                    {
                        echo '<script>alert("Vote candidate failed!");</script>';
                        echo '<script>self.close();</script>';
                    }
                }
            }
        }
    }
    
    $sql->Disconnect();
}

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Vote Candidate - <?php echo ConfigurationData::Site_Version(); ?></title>
        <link rel="stylesheet" type="text/css" href="API/BootStrapv3.3.7-dist/CSS/bootstrap.css" />
        <link rel="stylesheet" type="text/css" href="API/BootStrapv3.3.7-dist/CSS/bootstrap-theme.css" />
        <script type="text/javascript" src="API/JQuery v3.2.1/jquery.js"></script>
        <script type="text/javascript" src="API/BootStrapv3.3.7-dist/JS/bootstrap.js"></script>
        <script type="text/javascript">
        $(document).ready(function(){
            $('[data-toggle="popover"]').popover();
        });
        
        function SubmitVote()
        {
            var x = confirm('Are you sure want to proceed? Once proceed can\'t be undone.');
            
            if(x==false)
                return false;
        }
        </script>
        <style type="text/css">
        .bg-1 
        { 
            background-color: #1abc9c; /* Green */
            color: #ffffff;
        }
        
        .bg-2
        {
            background-color: #31b0d5;
            color: #ffffff;
        }
        
        .bg-3
        {
            background-color: #2aabd2;
            color: #FFFFFF;
        }
        
        .bg-4
        {
            background-color: #d43f3a;
            color: #FFFFFF;
        }
        
        .attention-warning
        {
            background-color: #ff0c0c;
            color: #FFFFFF;
        }
        
        .align
        {
            margin-top: -30px;
        }
        
        .desc-link
        {
            outline: none;
            border: none;
        }
        
        </style>
    </head>
    
    <body>
        <div class="jumbotron">
            <div class="container text-center">
                <h4>Which candidate would you like to vote?</h4>
            </div>
        </div>
        
        <?php
        $sql2 = new MySQL_Engine();
        $sql2->SetConnection(ConfigurationData::$database_host, ConfigurationData::$database_id, ConfigurationData::$database_pw, ConfigurationData::$database_db);
        $sql2->Connect();
        $result4 = $sql2->Stored_Proc_Query('GetCandDetails_Vote', array($activity_id));
        $sql2->Disconnect();
        ?>
        
        <form method="GET" autocomplete="off" onsubmit="return SubmitVote();">
            <input type="hidden" name="pid" value="<?php echo $_GET['pid']; ?>" />
            <div class="container-fluid align">
                
                <?php
                
                $color = array('bg-1','bg-2','bg-3','bg-4');
                
                foreach($result4 as $row)
                {
                    $code = $color[rand(0, 3)];
                    
                    echo '<div class="row text-center '.$code.'">';
                    echo '<div class="col-xs-12">';
                    
                    echo '<h4>'.$row['fullname'].'</h4>';
                    echo '<img src="Engines/Candidate_pic/'.$row['photo_loc'].'" class="img-circle" alt="Candidate_Pic" width="170" height="170" />';
                    echo '<h5 style="color:#000;"><button type="button" id="pop" class="btn btn-link desc-link" data-toggle="popover" data-trigger="hover" title="About '.$row['fullname'].'" data-placement="bottom" data-content="'.$row['cand_desc'].'">Description</button></h5>';
                    
                    echo '</div>';
                    echo '</div>';
                    
                    echo '<div class="row text-center '.$code.'">';
                    echo '<div class="col-xs-12">';
                    echo '<label class="radio-inline"><input type="radio" name="voted_candidate" value="'.$row['cand_id'].'" required="true"/> Vote Me</label>';
                    echo '</div> </div>';
                }
                
                ?>
                
                <div class="row text-center" style="background-color:#eee; padding: 20px 20px 20px 20px;">
                    <div class="col-xs-12">
                        <button type="submit" class="btn btn-primary">Vote Now!</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 attention-warning" style="padding: 20px 20px 20px 20px;">
                        <p style="padding-left:23px;"><span class="glyphicon glyphicon-alert"></span>&nbsp;&nbsp;<u>Attention for Voting</u></p>
                        <p>
                            <ol>
                                <li>Each voters have only one chance for voting.</li>
                                <li>No second attempts vote for same activity.</li>
                                <li>Please choose carefully, do not make mistake. Once mistaken cannot undo.</li>
                            </ol>
                        </p>
                    </div>
                </div>
                
                
            </div>
            
        </form>
    </body>
    
</html>