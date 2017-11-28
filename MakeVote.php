<?php include('Base/head.php'); ?>

<?php
if($isLogged == false)
{
    echo '<script>alert("Please log in to continue!");</script>';
    echo '<script>window.open("index.php","_self");</script>';
}
?>
<title>Make a vote - INTI Voting System (<?php echo ConfigurationData::Site_Version(); ?>)</title>

<link rel="stylesheet" type="text/css" href="CSS/Scroll.css" />
<style type="text/css">
    #cursor_link
    {
        cursor: pointer;
    }
    
    a:link, a:visited
    {
        color: #0000FF;
    }
    
    a:hover
    {
        color: #d43f3a;
    }
    
    a:active
    {
        color: #ff0;
    }
    
</style>

<script type="text/javascript">
    var win = false;
    
    function make_Vote(pid)
    {
        var target = "Vote.php?pid="+pid;
        
        if(win && !win.closed)
        {
            win.focus();
        }
        else
        {
            win = window.open(target, '_blank', 'resizable=no,location=no,width=800,height=604,top=100,left=150,menubar=no', true);
        }
    }
    
    $(window).bind('beforeunload',function(e){
        if(win)
        {
            win.close();
        }
    });
    
</script>

<div class="jumbotron text-center" style="margin-top: 0px;">
    <h2>Make A Vote</h2>
</div>

<div class="container-fluid" style="background-color: #f7f7f7; overflow-y: scroll; margin-top: -30px; max-height: 520px; height: 520px; padding-top: 20px;">
    <?php
    require_once('Engines/MySQL_Engine/MySQL_Engine.php');
    require_once('Engines/Config/config.php');
    $sql = new MySQL_Engine();
    $sql->SetConnection(ConfigurationData::$database_host, ConfigurationData::$database_id, ConfigurationData::$database_pw, ConfigurationData::$database_db);
    $sql->Connect();
    
    $result = $sql->Stored_Proc_Query('GetVoteActivity',array(''));
    $sql->Disconnect();
    
    if($result == 0)
    {
        echo '<div class="well well-lg alert alert-danger text-center"><strong>Error: </strong>No Event Happen!</div>';
    }
    else
    {
        foreach($result as $row)
        {
            echo '<a href="#" onclick="make_Vote('.$row['activity_id'].');"><div id="cursor_link" class="well well-lg"><div class="container">';
            echo '<div class="row">';
            $i=0;
            $d=0;
            $start='';
            
            foreach($row as $data)
            {
                switch($i)
                {
                    case 0:
                        echo '<div class="col-lg-3"><strong>Activity ID: '.$data.'</strong></div>';
                        break;
                    
                    case 1:
                    case 2:
                        if($d==0){echo '<div class="col-lg-3">Activity Title: '.$data.'<br />'; $d++;}
                        else{echo 'Creation Date: '.$data.'</div>'; $d=0;}
                        break;
                        
                    case 3:
                    case 4:
                        if($d==0)
                        {
                            echo '<div class="col-lg-3">Start Date: '.$data.'<br />';
                            $start = $data;
                            $d++;
                        }
                        else
                        {
                            echo 'End Date: '.$data; 
                            
                            $today = date('m/d/Y');
                            $end_date = strtotime($data);
                            $start_date = strtotime($start);
                            $formatted_end_date = date('m/d/Y', $end_date);
                            $formatted_start_date = date('m/d/Y', $start_date);

                            if($today < $formatted_start_date)
                            {
                                echo ' <span class="text text-warning" style="font-weight: bold;">(Wait for Open)</span></div>';
                            }
                            else if($formatted_end_date >= $today)
                            {
                                echo ' <span class="text text-success" style="font-weight: bold;">(Open)</span></div>';
                            }
                            else
                            {
                                echo ' <span class="text text-danger" style="font-weight: bold;">(Closed)</span></div>';
                            }
                            
                            $d=0;
                        }
                        break;    
                        
                    case 5:
                    case 6:
                        if($d==0)
                        {
                            $str = '';
                            switch($data)
                            {
                                case 1:
                                    $str = 'AGM Meeting';
                                    break;

                                case 2:
                                    $str = 'Club';
                                    break;

                                case 3:
                                    $str = 'Sport';
                                    break;
                            }
                            
                            echo '<div class="col-lg-3">Category: '.$str.'<br />';
                            $d++;
                        }
                        else
                        {
                            $str = '';
                            switch($data)
                            {
                                case 1:
                                    $str = 'Open';
                                    break;
                            }
                            
                            echo 'Restriction: '.$str.'</div>';
                            $d=0;
                        }
                        break;
                }
                
                $i++;
            }
            
            
            echo '</div></div></div></a>';
        }
    }
    ?>
    
</div>

<?php include('Base/foot.php'); ?> 
