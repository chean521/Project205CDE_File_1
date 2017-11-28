<?php include('Base/head.php'); ?>
    <?php
    if($isAdminLogged == false)
    {
        echo '<script>window.open("index.php","_self");</script>';
    }

?>
<title>View Account - INTI Voting System (<?php echo ConfigurationData::Site_Version(); ?>)</title>

<div class="jumbotron text-center">
    <h2>View Account Panel</h2>
</div>

<style type="text/css">
    
    #form_search
    {
        padding: 20px 10px 20px 15px;
    }
    
</style>
<script type="text/javascript" src="js/ViewAccountGet_Request.js"></script>
<div class="container-fluid" style="background-color: #f7f7f7; margin-top: -30px; height: 520px;">
    <div class="row">
        <div class="col-lg-12" id="form_search">
            <form method="get" action="" class="form-inline" onsubmit="return false;" autocomplete="off">
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>
                        <input type="text" maxlength="9" class="form-control" name="search" id="search_bar" placeholder="Enter Student ID here" value="" oninput="GetUserDetails(this.value)"/>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="container-fluid" style="overflow-y: scroll; max-height: 445px; height: 445px;">
                <div class="row">
                    <div class="col-lg-12">
                        <table class="table table-hover table-responsive">
                            <thead>
                                <tr>
                                    <th>Student ID</th>
                                    <th>Full Name</th>
                                    <th>Programme</th>
                                    <th>Roles</th>
                                    <th>Creation Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody id="content_data">
                                <span id="data-container"></span>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>

<?php include('Base/foot.php'); ?>