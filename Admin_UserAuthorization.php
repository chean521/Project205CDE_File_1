<?php include('Base/head.php'); ?>
<title>User Sign Up Authorization - INTI Voting System (<?php echo ConfigurationData::Site_Version(); ?>)</title>

<?php
    if($isAdminLogged == false)
    {
        echo '<script>window.open("index.php","_self");</script>';
    }

?>

<div class="jumbotron text-center">
    <h2>User Account Registration Authorization Panel</h2>
</div>

<style type="text/css">
    
    #form_search
    {
        padding: 20px 10px 20px 15px;
    }
    
</style>

<div class="container-fluid" style="background-color: #f7f7f7; margin-top: -30px; height: 520px;">
    <div class="row">
        <div class="col-lg-12" id="form_search">
            <form method="get" action="" class="form-inline" autocomplete="off">
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>
                        <?php if(isset($_GET['search'])){ $text = $_GET['search'];} else { $text = ''; } ?>
                        <input type="text" maxlength="50" class="form-control" name="search" id="search_bar" placeholder="Enter Student ID here" value="<?php echo $text; ?>"/>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <link rel="stylesheet" type="text/css" href="CSS/Scroll.css" />
    <div class="row">
        <div class="col-lg-12">
            <div class="container-fluid" style="overflow-y: scroll; max-height: 445px; height: 445px;">
                <div class="row">
                    <div class="col-lg-12">
                        <script type="text/javascript" src="js/UserAuthorization_Request.js"></script>
                        <table class="table table-hover table-responsive">
                            <thead>
                                <tr>
                                    <th>Student ID</th>
                                    <th>Full Name</th>
                                    <th>Programme</th>
                                    <th>Roles</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody style="overflow-y: scroll;" id="content_data">
                            <p id="auth_data">
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

                                $result = $sql->Stored_Proc_Query('GetUserStats',array('pending',$search));
                                $sql->Disconnect();

                                if($result == 0)
                                {
                                    if($search != '')
                                    {
                                        echo '<tr class="alert alert-danger"><td colspan="5" class="text-center"><strong>Error: </strong>Search keyword "'. ucfirst($search).'" not found.</td></tr>';
                                    }
                                    else
                                    {
                                        echo '<tr class="alert alert-danger"><td colspan="5" class="text-center"><strong>Error: </strong>No User Register Request</td></tr>';
                                    }
                                }
                                else
                                {

                                    foreach($result as $row)
                                    {
                                        echo '<tr>';
                                        $i=0;
                                        $std_id = '';

                                        foreach($row as $col)
                                        {
                                            if($i==3)
                                            {
                                                switch($col)
                                                {
                                                    case 'admin':
                                                        echo '<td>Administrator</td>';
                                                        break;

                                                    case 'student':
                                                        echo '<td>Student</td>';
                                                        break;

                                                    case 'staff':
                                                        echo '<td>Staff</td>';
                                                        break;
                                                }
                                            }
                                            else
                                            {
                                                echo '<td>'.ucfirst($col).'</td>';
                                                if($i==0)
                                                {
                                                    $std_id = $col;
                                                }
                                            }

                                            $i++;
                                        }

                                        echo '<td class="text-center">'
                                                . '<button type="button" class="btn btn-success" style="border-radius:25px;" data-toggle="modal" data-target="#verify_modal" onclick="SetAction(\'approve\',\''.$std_id.'\');">Approve</button>&nbsp;&nbsp;&nbsp;'
                                                . '<button type="button" class="btn btn-danger" style="border-radius:25px;" data-toggle="modal" data-target="#verify_modal" onclick="SetAction(\'reject\',\''.$std_id.'\');">Reject</button>'
                                           . '</td>';

                                        echo '</tr>';
                                    }
                                }


                                ?>
                            </p>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>
<?php include('Base/auth_modal.php'); ?>

<?php include('Base/foot.php'); ?>
