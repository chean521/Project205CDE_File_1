
<div id="login_box" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <form method="post" onsubmit="return GetData();">
            <div class="modal-content">
                <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal">&times;</button>
                     <h4 class="modal-title text-center">
                         <img src="images/logo.png" class="img-circle" width="100px" height="100px" />
                     </h4>
                     <h4 class="modal-title text-center">
                         Login to Access Vote
                     </h4>
                </div>
                <div class="modal-body">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input id="usr_id" name="usr_id" type="text" maxlength="50" class="form-control" placeholder="Student ID" required/>
                    </div>
                    <p></p>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                        <input id="pwd" type="password" class="form-control" maxlength="50" name="pwd" placeholder="Password" required/>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-4" style="margin-left: -16px;">
                                <button type="submit" class="btn btn-default" onclick="">Login</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal" onclick="">Cancel</button>
                            </div>
                            <div class="col-lg-8" style="margin-top:10px;">
                                <span id="err_msg">
                                    
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </form>
    </div>
    
</div>
<script type="text/javascript" src="js/LogModal_Request.js"></script>

<div id="register_modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <form method="post" onsubmit="return false;" class="form-horizontal" autocomplete="off">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title text-center">
                        <img src="images/logo.png" class="img-circle" width="100px" height="100px" />
                    </h4>
                    <h4 class="modal-title text-center">
                        Register to become Voter
                    </h4>
                </div>
                <script type="text/javascript" src="js/CheckSignUp_Request.js"></script>
                <div class="modal-body">
                    <div class="form-group has-feedback" id="id_box">
                        <label class="control-label col-lg-4" for="add_usr_id">Student ID</label>
                        <div class="col-lg-8">
                            <input type="text" class="form-control" id="add_usr_id" name="add_content[]" placeholder="Student ID" maxlength="9" minlength="9" required="required" oninput="CheckStudentID(this.value)" >
                            <span class="glyphicon form-control-feedback" id="add_usr_stat"></span>
                        </div>
                    </div>
                    <div class="form-group has-feedback" id="name_box">
                        <label class="control-label col-lg-4" for="add_fname">Student Name</label>
                        <div class="col-lg-8">
                            <input type="text" class="form-control" id="add_fname" name="add_content[]" placeholder="Student Name" maxlength="50" minlength="10" required="required" oninput="CheckNameLength(this.value)" >
                            <span class="glyphicon form-control-feedback" id="add_fname_stat"></span>
                        </div>
                    </div>
                    <div class="form-group has-feedback" id="prog_box">
                        <label class="control-label col-lg-4" for="add_prog">Programme</label>
                        <div class="col-lg-8">
                            <select class="form-control" id="add_prog" name="add_content[]" required="required" oninput="CheckProgrammeInput(this.value)">
                                <option value="">Please select</option>
                                <option value="BCTCU">BCTCU</option>
                                <option value="BCSCU">BCSCU</option>
                                <option value="DICTN">DICTN</option>
                                <option value="DIB">DIB</option>
                                <option value="others">Others</option>
                            </select>
                            <span class="glyphicon form-control-feedback" id="add_prog_stat"></span>
                        </div>
                    </div>
                    <div class="form-group has-feedback" id="pwd_box">
                        <label class="control-label col-lg-4" for="add_pwd">Password</label>
                        <div class="col-lg-8">
                            <input type="password" class="form-control" id="add_pwd" name="add_content[]" placeholder="Password" maxlength="50" minlength="8" required="required" oninput="CheckPwd()"/>
                            <span class="glyphicon form-control-feedback" id="add_pwd_stat"></span>
                            <div class="progress">
                                <div class="progress-bar progress-striped active" id="progress-strength" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                                    <span id="progress-text"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group has-feedback" id="cpwd_box">
                        <label class="control-label col-lg-4" for="add_pwd">Confirm Password</label>
                        <div class="col-lg-8">
                            <input type="password" class="form-control" id="add_cpwd" name="add_content[]" placeholder="Confirm Password" maxlength="50" minlength="8" required="required" oninput="CheckConfirmPassword(this.value)" />
                            <span class="glyphicon form-control-feedback" id="add_cpwd_stat"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="container-fluid text-center">
                        <div class="row">
                            <div class="col-lg-12">
                                <button type="button" class="btn btn-default" onclick="SubmitData();" >Create Account</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal" onclick="">No, Think First</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript" src="js/PasswordChange_Request.js"></script>
<div id="chg_pwd_modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title text-center">Change User Password</h4>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            Please enter current password to continue.
                        </div>
                    </div>
                    <div class="row" style="margin-top: 14px;">
                        <div class="col-lg-12">
                            <div class="input-group has-feedback" id="cur_pass_valid">
                                <input type="password" maxlength="50" required id="chg_cur_pwd" class="form-control" placeholder="Current Password" oninput="CheckCurrentPwd('<?php echo $Session->get_session_data('detail_id'); ?>');" />
                                <div class="input-group-btn">
                                    <button class="btn btn-default" type="button" id="chg_btn_1" disabled data-toggle="modal" data-target="#chg_pwd_modal_2" data-dismiss="modal" onclick="removeTxt();">
                                        <i class="glyphicon glyphicon-play"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                
            </div>
        </div>
    </div>
</div>

<div id="chg_pwd_modal_2" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <form method="post" onsubmit="return false;" class="form-horizontal">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title text-center">Change User Password</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group has-feedback" id="pwd_box2">
                        <label class="control-label col-lg-4" for="edit_pwd">New Password</label>
                        <div class="col-lg-8">
                            <input type="password" class="form-control" id="edit_pwd" name="add_content[]" placeholder="Password" maxlength="50" minlength="8" required="required" oninput="CheckPwd2()" onfocus="this.value='';"/>
                            <span class="glyphicon form-control-feedback" id="edit_pwd_stat"></span>
                            <div class="progress">
                                <div class="progress-bar progress-striped active" id="progress-edit-strength" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                                    <span id="progress-edit-text"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group has-feedback" id="cpwd_box2">
                        <label class="control-label col-lg-4" for="add_cpwd2">Confirm Password</label>
                        <div class="col-lg-8">
                            <input type="password" class="form-control" id="add_cpwd2" name="add_content[]" placeholder="Confirm Password" maxlength="50" minlength="8" required="required" oninput="CheckConfirmPassword2(this.value)"  onfocus="this.value='';"/>
                            <span class="glyphicon form-control-feedback" id="add_cpwd_stat2"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="container-fluid text-center">
                        <div class="row">
                            <div class="col-lg-12">
                                <button type="button" class="btn btn-default" onclick="SubmitChangePassword('<?php echo $Session->get_session_data('detail_id'); ?>');" >Yes, Change Now</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal" onclick="">No, Think First</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>