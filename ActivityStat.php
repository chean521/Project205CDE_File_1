<?php include('Base/head.php'); ?>

<title>Check Activity Status - INTI Voting System (<?php echo ConfigurationData::Site_Version(); ?>)</title>

<style type="text/css">
.text-on-pannel {
  background: #fff none repeat scroll 0 0;
  height: auto;
  margin-left: 20px;
  padding: 3px 5px;
  position: absolute;
  margin-top: -37px;
  border: 1px solid #337ab7;
  border-radius: 8px;
}

.panel {
  /* for text on pannel */
  background: rgba(255,255,255, 0.1);
  margin-top: 30px !important;
}

.panel-body {
  
  padding-top: 23px !important;
  padding-bottom: 15px !important;
}

.panel-body-search{
    padding-top: 23px !important;
    padding-bottom: 0px !important;
}


.bg-1 { 
      background-color: #9d9d9d;
      color: #ffffff;
 }
 
 .padd{
     padding-top: 40px;
     padding-bottom: 40px;
 }

</style>

<script type="text/javascript" src="API/Chartv2/Chart.js"></script>
<link rel="stylesheet" type="text/css" href="CSS/Scroll.css" />

<div class="jumbotron text-center" id="container-4" >
    <h2>Check Activity Status</h2>
</div>

<?php
require_once('Engines/MySQL_Engine/MySQL_Engine.php');
require_once('Engines/Config/config.php');

try
{
    $sql = new MySQL_Engine();
    $sql->SetConnection(ConfigurationData::$database_host, ConfigurationData::$database_id, ConfigurationData::$database_pw, ConfigurationData::$database_db);
    $sql->Connect();

    $query = "select activity_id, activity_title, creation_date from voteactivity where now() >= start_date;";
    $result = $sql->Single_Line_Query($query, NULL, array());
    $sql->Disconnect();
}
catch(Exception $e)
{
    
}

?>

<div class="container-fluid" style="background-color: #f7f7f7; margin-top: -30px;">
    <div class="row">
        <div class="col-lg-12 text-center" style="margin-top: 30px;margin-bottom: 10px;">
            <form onchange="OnResultChanged(document.getElementById('act').value);" onsubmit="return false;">
                <div class="form-group form-inline">
                    <label for="act">Activity Listing&nbsp;</label>
                    <select name="activity" id="act" class="form-control" style="width: 450px;">
                        <option value="" selected="true">Please select activity available</option>
                        <option disabled="true">Available Result.</option>
                        <?php
                        foreach($result as $row)
                        {
                            echo '<option value="'.$row['activity_id'].'">Activity ID: '.$row['activity_id'].' - '.$row['activity_title'].' (Event Created On: '.$row['creation_date'].')</option>';
                        }
                        ?>
                    </select>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="container-fluid" style="background-color: #f7f7f7; overflow-y: scroll; max-height: 430px; height: 430px;">
    <form onsubmit="return false;" class="form-horizontal" style="display:none;" id="form-display">
        <div class="row">

            <div class="col-lg-12" style="margin-top:0px;">

                <div class="panel panel-primary">
                    <div class="panel-body">
                        <h5 class="text-on-pannel text-primary"><strong class="text-uppercase">Live Result Chart</strong></h5>
                        <div class="form-group" style="margin-top:15px;">
                            <label class="control-label col-lg-2">Progress Status</label>
                            <div class="col-lg-8" style="margin-top:7px;">
                                <span id="prog_stat" class="text"></span>
                            </div>
                            <div class="col-lg-2"></div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-2">Activity ID</label>
                            <div class="col-lg-8" style="margin-top:6px;">
                                <span id="act_id"></span>
                            </div>
                            <div class="col-lg-2"></div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-2">Activity Description</label>
                            <div class="col-lg-8" style="margin-top:6px;">
                                <span id="act_desc"></span>
                            </div>
                            <div class="col-lg-2"></div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-2">Start And End Date</label>
                            <div class="col-lg-8" style="margin-top:6px;">
                                <span id="date_sn"></span>
                            </div>
                            <div class="col-lg-2"></div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-2">Progress Details</label>
                            <div class="col-lg-8" style="margin-top:6px;">
                                <span id="prog_details"></span>
                            </div>
                            <div class="col-lg-2"></div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-1"></div>
                            <div class="col-lg-10" style="margin-left: -22px;">
                                <div id="chart_container">
                                    <canvas id="charts"></canvas>
                                </div>
                            </div>
                            <div class="col-lg-1" id="test"></div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
        

        
    </form>
</div>

<script type="text/javascript" src="js/ActivityStat_Request.js"></script>

<?php include('Base/foot.php'); ?>
