<script type="text/javascript" >
    function confirmBox()
    {
        var conf = confirm("Are you sure want to proceed?");
        if(conf == false)
            return false;
    }
    
    $(document).ready(function () {
        $('#cand_1_desc').on("input", function(e){
            var len = $("#cand_1_desc").val().length;
            
            $('#check_char_1').html(500-len);
        });
    });
    
    $(document).ready(function () {
        $('#cand_2_desc').on("input", function(e){
            var len = $("#cand_2_desc").val().length;
            
            $('#check_char_2').html(500-len);
        });
    });
    
    $(document).ready(function() {
        $('#act_start').on('change', function() {
            var date_now = new Date();
            var date_start = new Date($('#act_start').val());
            
            if(date_start.getTime() < (date_now.getTime()-86400000))
            {
                alert("Error input start date, date should not less than start date.");
                $('#act_start').val('');
            }
            
        });
    });
    
    $(document).ready(function() {
        $('#act_end').on('change', function() {
            var date_start = new Date($('#act_start').val());
            var date_end = new Date($('#act_end').val());
            
            if(date_start.getTime() > date_end.getTime())
            {
                alert("Error input end date, date should not less than start date.");
                $('#act_end').val('');
            }
            
        });
    });
    
    $(document).ready(function() {
        $('#act_cand_1').on('change', function() {
            var cand_1 = $('#act_cand_1 option:selected').val();
            
            if(cand_1 == '')
            {
                alert("Option should not be empty.");
                $('#act_cand_1 option[value=""]').prop('selected', 'selected');
                $('#act_cand_1 option:selected').focus();
            }
        });        
    });
    
    $(document).ready(function() {
        $('#act_cand_2').on('change', function() {
            var cand_1 = $('#act_cand_1 option:selected').val();
            var cand_2 = $('#act_cand_2 option:selected').val();
            
            if(cand_2 == '')
            {
                alert("Option should not be empty.");
                $('#act_cand_2 option:selected').focus();
            }
            else if(cand_1 == cand_2)
            {
                alert("Candidate 2 should not be same as candidate 1.");
                $('#act_cand_2 option[value=""]').prop('selected', 'selected');
                $('#act_cand_2 option:selected').focus();
            }
            
        });        
    });
    
</script>


<div id="add_new_act" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <form class="form-horizontal" method="post" action="Engines/Activity_Process.php" onsubmit="return confirmBox();" enctype="multipart/form-data">
      
    <?php
    
    $sql_2 = new MySQL_Engine();
    $sql_2->SetConnection(ConfigurationData::$database_host, ConfigurationData::$database_id, ConfigurationData::$database_pw, ConfigurationData::$database_db);
    $sql_2->Connect();
    
    $con = $sql_2->GetConnection();
    
    ?>
        
    <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add New Vote Activity</h4>
            </div>
            <div class="modal-body">
                
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="act_title">Activity Title</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="act_title" name="act[]" placeholder="Activity Name" required="required" />
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="act_desc">Activity Description</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="act_desc" name="act[]" placeholder="Description" required="required" />
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="act_start">Start Date</label>
                        <div class="col-sm-8">
                            <input type="date" class="form-control" id="act_start" name="act[]" placeholder="Voting Start Date" required="required" />
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="act_end">End Date</label>
                        <div class="col-sm-8">
                            <input type="date" class="form-control" id="act_end" name="act[]" placeholder="Voting End Date" required="required"/>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="act_category" required="required">Category</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="act[]" id="act_category">
                                <option selected="selected" value="">Please select</option>
                                <option value="1">AGM</option>
                                <option value="2">Club</option>
                                <option value="3">Sport</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="act_restriction">Restriction</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="act[]" id="act_restriction" required="required">
                                <option selected="selected" value="">Please select</option>
                                <option value="1">Cat 1: Everyone</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="act_cand_1">Candidate 1: </label>
                        <div class="col-sm-8">
                            <select class="form-control" name="act[]" id="act_cand_1" required="required">
                                <option selected="selected" value="">Please select</option>
                                <?php
                                
                                $q = 'SELECT studentID, fullname FROM user';
                                $res = $con->query($q);
                                
                                $data = array();
                                
                                if($res->num_rows > 0)
                                {
                                    while($row = $res->fetch_object())
                                    {
                                        if($row->studentID == 'admin')
                                        {
                                            continue;
                                        }
                                        
                                        $data[] = $row;
                                    }
                                    
                                }
                                else
                                {
                                    echo '<option value="">No Data</option>';
                                }
                                
                                $res->free();
                                
                                foreach($data as $rows)
                                {
                                    $tmp = ucfirst($rows->studentID) . ' (' . $rows->fullname . ')';
                                    echo '<option value="' . $rows->studentID . '">'.$tmp.'</option>';
                                }
                                  
                                ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="cand_1_desc">Description<br />(Candidate 1):</label>
                        <div class="col-sm-8">
                            <textarea class="form-control" maxlength="500" rows="4" name="act[]" id="cand_1_desc" style="resize: none;" placeholder="Description for Candidate 1" required="required"></textarea>
                            <span id="check_char_1">500</span> character(s) left.
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="cand_1_file">Photo Candidate 1:</label>
                        <div class="col-sm-8">
                            <input type="file" class="form-control" name="photo[]" id="cand_1_desc" accept="image/*"  required="required"/>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="act_cand_2">Candidate 2: </label>
                        <div class="col-sm-8">
                            <select class="form-control" name="act[]" id="act_cand_2" required="required">
                                <option selected="selected" value="">Please select</option>
                                <?php
                                
                                foreach($data as $rows)
                                {
                                    $tmp = ucfirst($rows->studentID) . ' (' . $rows->fullname . ')';
                                    echo '<option value="' . $rows->studentID . '">'.$tmp.'</option>';
                                }
                                
                                ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="cand_2_desc">Description<br />(Candidate 2):</label>
                        <div class="col-sm-8">
                            <textarea class="form-control" maxlength="500" rows="4" name="act[]" id="cand_2_desc" style="resize: none;" placeholder="Description for Candidate 2" required="required"></textarea>
                            <span id="check_char_2">500</span> character(s) left.
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="cand_2_file">Photo Candidate 2:</label>
                        <div class="col-sm-8">
                            <input type="file" class="form-control" name="photo[]" id="cand_2_desc" accept="image/*"  required="required"/>
                        </div>
                    </div>
                    
                
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-default" >Add</button>
                <button type="button" class="btn btn-default" data-dismiss="modal" onclick="SetResponse('no');">Cancel</button>
            </div>
        </div>
    
    <?php  $sql_2->Disconnect(); ?>
    
    </form>
    </div>
</div>

<div id="delete_act_modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Delete Activity (Act ID: <span id="delete_act_id"></span>)</h4>
            </div>
            <div class="modal-body">
                Are you sure want to delete activity?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" onclick="delete_reqs();">Yes, proceed it</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">No, let me think</button>
            </div>
        </div>
    </div>
</div>