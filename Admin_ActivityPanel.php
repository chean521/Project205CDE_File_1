<?php include('Base/head.php'); ?>
<?php
    if($isAdminLogged == false)
    {
        echo '<script>window.open("index.php","_self");</script>';
    }

?>
<title>Voting Activity Panel - INTI Voting System (<?php echo ConfigurationData::Site_Version(); ?>)</title>

<div class="jumbotron text-center">
    <h2>Voting Activity Panel</h2>
</div>
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
    
#activity_details tbody tr.highlight td {
    background-color: rgba(153,153,153, 0.6);
}
</style>
<script type="text/javascript" src="js/ActivityPanelAddCheck.js"></script>
<div class="container-fluid" style="background-color: #f7f7f7; margin-top: -30px; height: 520px;">
    <div class="row">
        <div class="col-lg-8">
            <div class="panel panel-primary">
                <div class="panel-body">
                    <h5 class="text-on-pannel text-primary"><strong class="text-uppercase">Tools</strong></h5>
                    <button type="button" class="btn btn-primary" onclick="open_win()">Add New Activity</button>
                    <button type="button" class="btn btn-primary" id="view_res_btn" onclick="export_result()" disabled>Export Result</button>
                    <button type="button" class="btn btn-danger" id="del_btn" data-toggle="modal" data-target="#delete_act_modal" disabled>Delete</button>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="panel panel-primary">
                <div class="panel-body panel-body-search">
                    <h5 class="text-on-pannel text-primary"><strong class="text-uppercase">Search By Creation Date</strong></h5>
                    <form method="get" action="">
                        <div class="form-group">
                            <?php if(isset($_GET['search'])){ $text = $_GET['search'];} else { $text = ''; } ?>
                            <input type="date" name="search" class="form-control" id="date" value="<?php echo $text; ?>" placeholder="Date Activity Created" />
                            <input type="submit" style="position: absolute; display: none;" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
    var selected_id = '';
        
    $(document).ready(function(){
        $('input[type=radio][name=id_selection]').change(function(){
            if(this.value != null || this.value != '')
            {
                $('#view_res_btn').prop('disabled', false);
                $('#del_btn').prop('disabled', false);
                selected_id = this.value;
                $('#view_act_id').html(selected_id);
                $('#delete_act_id').html(selected_id);
            }
            else
            {
                $('#view_res_btn').prop('disabled', true);
                $('#del_btn').prop('disabled', true);
                selected_id = '';
            }
        });
    });
    
    function export_result()
    {
        var ids = document.getElementsByName('id_selection');
        var selected_value;

        for (var i = 0, length = ids.length; i < length; i++)
        {
            if(ids[i].checked)
            {
                selected_value = ids[i].value;
                break;
            }
        }
        window.open("ResultExport.php?pid="+selected_value,"_blank");
    }
    </script>
    <script type="text/javascript" src="js/ActivityManager_Request.js"></script>
    <link rel="stylesheet" type="text/css" href="CSS/Scroll.css" />
    <div class="row">
        <div class="col-lg-12">
            <div class="container-fluid" style="overflow-y: scroll; max-height: 395px; height: 395px;">
                <div class="row">
                    <div class="col-lg-12">
                        <table class="table table-hover table-responsive" id="activity_details">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Activity ID</th>
                                    <th>Activity Title</th>
                                    <th>Created On</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Category</th>
                                    <th>Restriction</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                require_once('Engines/MySQL_Engine/MySQL_Engine.php');
                                require_once('Engines/Config/config.php');

                                $search = '';

                                if(isset($_GET['search']))
                                {
                                    $search = $_GET['search'];
                                }

                                $sql = new MySQL_Engine();
                                $sql->SetConnection(ConfigurationData::$database_host, ConfigurationData::$database_id, ConfigurationData::$database_pw, ConfigurationData::$database_db);
                                $sql->Connect();

                                $result = $sql->Stored_Proc_Query('GetVoteActivity',array($search));
                                $sql->Disconnect();

                                if($result == 0)
                                {
                                    if($search != '')
                                    {
                                        echo '<tr class="alert alert-danger"><td colspan="9" class="text-center"><strong>Error: </strong>Search date "'. ucfirst($search).'" not found.</td></tr>';
                                    }
                                    else
                                    {
                                        echo '<tr class="alert alert-danger"><td colspan="9" class="text-center"><strong>Error: </strong>No Event Happen!</td></tr>';
                                    }
                                }
                                else
                                {
                                    foreach($result as $row)
                                    {
                                        $i=0;
                                        echo '<tr>';
                                        $end = '';
                                        $start = '';

                                        foreach($row as $col)
                                        {
                                            switch($i)
                                            {
                                                case 0:
                                                    echo '<td><input type="radio" id="selected_id" name="id_selection" value="'.$col.'" /></td>';
                                                    echo '<td class="a_id">'.$col.'</td>';
                                                    break;

                                                case 3:
                                                    $start = $col;
                                                case 4:
                                                    $end = $col;
                                                    echo '<td>'.ucfirst($col).'</td>';
                                                    break;

                                                case 5:
                                                    switch($col)
                                                    {
                                                        case 1:
                                                            echo '<td>AGM Meeting</td>';
                                                            break;

                                                        case 2:
                                                            echo '<td>Club</td>';
                                                            break;

                                                        case 3:
                                                            echo '<td>Sport</td>';
                                                            break;
                                                    }
                                                    break;

                                                case 6:
                                                    switch($col)
                                                    {
                                                        case 1:
                                                            echo '<td>Everyone (Open)</td>';
                                                            break;
                                                    }
                                                    break;

                                                default:
                                                    echo '<td>'.ucfirst($col).'</td>';
                                                    break;
                                            }


                                            $i++;
                                        }

                                        $today = date('m/d/Y');
                                        $start_date = strtotime($start);
                                        $end_date = strtotime($end);
                                        $formatted_end_date = date('m/d/Y', $end_date);
                                        $formatted_start_date = date('m/d/Y', $start_date);

                                        if($formatted_start_date > $today)
                                        {
                                            echo '<td class="text-warning">Waiting for Open</td>';
                                        }
                                        else if($formatted_end_date >= $today)
                                        {
                                            echo '<td class="text-success">Open</td>';
                                        }
                                        else
                                        {
                                            echo '<td class="text-danger">Closed</td>';
                                        }

                                        echo '</tr>';
                                    }
                                }

                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>

<script type="text/javascript" src="js/table_choose.js"></script>
<?php include('Base/ActivityModal.php'); ?>
<?php include('Base/foot.php'); ?>