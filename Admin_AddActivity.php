<?php
require ('Engines/SessionManager/SessionManager.php');
require ('Engines/Config/config.php');

$Session = new SessionManager();

$login_details = $Session->get_session_data('detail_role');
if($login_details != 'admin')
{
    echo '<script>alert("Access Denied!");</script>';
    echo '<script>self.close();</script>';
}
?>

<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="stylesheet" type="text/css" href="API/BootStrapv3.3.7-dist/CSS/bootstrap.css" />
        <link rel="stylesheet" type="text/css" href="API/BootStrapv3.3.7-dist/CSS/bootstrap-theme.css" />
        <link rel="stylesheet" type="text/css" href="CSS/Scroll.css" />
        <link rel="shortcut icon" href="images/160.ico" />
        <script type="text/javascript" language="javascript" src="API/JQuery v3.2.1/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="API/BootStrapv3.3.7-dist/JS/bootstrap.js"></script>
        <title>Add New Vote Activity - INTI Voting System (<?php echo ConfigurationData::Site_Version(); ?>)</title>
        <style type="text/css">
            html {position: relative; min-height: 100%;}
            body {font-family: Times New Roman, serif;}
            @import url(http://fonts.googleapis.com/css?family=Roboto);
            
            * {
                font-family: 'Roboto', sans-serif;
            }
            
            tbody
            {
                display: block;
                max-height: 380px;
                overflow-y: scroll;
                height: 380px;
            }
            
            thead, tbody tr 
            {
                display: table;
                width:100%;
                table-layout: fixed;/* even columns width , fix width of table too*/
            }
        </style>
    </head>
    
    <body onload="GetCandSelection();">
        <div class="jumbotron text-center">
            <h2>Add New Vote Activity</h2>
        </div>
        <div class="container-fluid" style=" background-color:#2aabd2; margin-top: -30px;">
            <form method="post" action="Engines/AddActivity_Reqs.php" onsubmit="return CandidateValidate();" enctype="multipart/form-data" class="form-horizontal" name="add_activity">
                <div class="row">
                    <div class="col-lg-6" style="height: 490px;">
                        <div class="form-group" style="margin-top: 40px;">
                            <label class="control-label col-lg-3" for="act_title">Activity Title</label>
                            <div class="col-lg-9">
                                <input type="text" class="form-control" id="act_title" name="act[]" placeholder="Activity Name" required="required" />
                            </div>
                        </div>

                        <div class="form-group" style="margin-top: 20px;">
                            <label class="control-label col-lg-3" for="act_desc">Activity Description</label>
                            <div class="col-lg-9">
                                <input type="text" class="form-control" id="act_desc" name="act[]" placeholder="Description" required="required" />
                            </div>
                        </div>

                        <div class="form-group" style="margin-top: 20px;">
                            <label class="control-label col-lg-3" for="act_start">Start Date</label>
                            <div class="col-lg-9">
                                <input type="date" class="form-control" id="act_start" name="act[]" placeholder="Voting Start Date" required="required" />
                            </div>
                        </div>

                        <div class="form-group" style="margin-top: 20px;">
                            <label class="control-label col-lg-3" for="act_end">End Date</label>
                            <div class="col-lg-9">
                                <input type="date" class="form-control" id="act_end" name="act[]" placeholder="Voting End Date" required="required"/>
                            </div>
                        </div>

                        <div class="form-group" style="margin-top: 20px;">
                            <label class="control-label col-lg-3" for="act_category" required="required">Category</label>
                            <div class="col-lg-9">
                                <select class="form-control" name="act[]" id="act_category">
                                    <option value="1">AGM</option>
                                    <option value="2">Club</option>
                                    <option value="3">Sport</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group" style="margin-top: 20px;">
                            <label class="control-label col-lg-3" for="act_restriction">Restriction</label>
                            <div class="col-lg-9">
                                <select class="form-control" name="act[]" id="act_restriction" required="required">
                                    <option value="1">Cat 1: Everyone</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6" style="height: 490px; max-height: 510px;">
                         
                        <table class="table table-hover table-responsive" border="1" style="margin-top: 40px;" id="cand_table">
                            <thead>
                                <tr>
                                    <th>Candidate ID</th>
                                    <th>Candidate Desc</th>
                                    <th>Photo</th>
                                    <th style="width: 26.3%">Action</th>
                                </tr>
                            </thead>
                            <tbody id="cand_cont">
                            
                            </tbody>
                            
                        </table>
                        
                    </div>
                </div>
                <div class="row" >
                    <div class="col-lg-12 text-right" style="height: 60px;">
                        <button type="submit" class="btn btn-success" style="margin-top: 12px;">Add Activity</button>
                        <button type="button" class="btn btn-primary" style="margin-top: 12px" onclick="AddCandidate();">Add Candidate (<span id="add_no">10</span>)</button>
                        <button type="button" class="btn btn-danger" style="margin-top: 12px;" onclick="self.close();">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
        
        <footer class="container-fluid text-center">
            <p>&copy; Copyright, Oscar Loh. All Right Reserved.</p>
        </footer>
        <script type="text/javascript" src="js/AddActivityRunnable.js"></script>
        <script type="text/javascript">
            
            function CandidateValidate()
            {
                if(candidates < 2)
                {
                    alert("Minimum must have 2 candidates.");
                    return false;
                }
                else
                {
                    var cand_id_box = document.getElementsByName("cand_id[]");

                    for(var i=0; i<cand_id_box.length; i++)
                    {
                        if(cand_id_box[i].value == "" )
                        {
                            alert("Each Candidate Box should not leave empty");
                            return false;
                        }
                    }
                    
                    for(var i=0; i<cand_id_box.length; i++)
                    {
                        for(var j=i; j<cand_id_box.length-1; j++)
                        {   
                            if(cand_id_box[i].value == cand_id_box[j+1].value)
                            {
                                alert("Each Candidate should not be same.");
                                return false;
                            }
                        }
                    }

                    if(confirm("Are you sure want to proceed?") == true)
                        return true;
                    else
                        return false;
                }
            }
        </script>
    </body>
    
</html>