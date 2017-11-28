/* 
* Password Request Handler, JSON 
*/

var edit_pw_ok = false;
var edit_cpw_ok = false;

function CheckCurrentPwd(ids)
{
    var cur_pwd = document.getElementById('chg_cur_pwd').value;
    var inputs = {"usr_id":ids,"types":"chk_cur","pwd":cur_pwd};
        
    var reqs = new XMLHttpRequest();
    
    reqs.onreadystatechange = function()
    {
        if(this.readyState == 4 && this.status == 200)
        {
            var res = JSON.parse(this.responseText);
            var cur_box = document.getElementById('cur_pass_valid').classList;
            
            if(res['result']==true)
            {
                if(cur_box.contains('has-error'))
                    cur_box.remove('has-error');
                
                cur_box.add('has-success');
                document.getElementById('chg_btn_1').disabled = false;
            }
            else
            {
                 if(cur_box.contains('has-success'))
                    cur_box.remove('has-success');
                
                cur_box.add('has-error');
                document.getElementById('chg_btn_1').disabled = true;
            }
            
        }
    };
    
    var send_param = JSON.stringify(inputs);
    reqs.open("GET", "Engines/PasswordChange_JSON.php?data="+send_param, true);
    reqs.send();
}

function removeTxt()
{
    document.getElementById('chg_cur_pwd').value='';
    setTimeout(function(){document.getElementById('chg_btn_1').disabled = true;}, 1000);
    var cur_box = document.getElementById('cur_pass_valid').classList;
    if(cur_box.contains('has-success'))
        cur_box.remove('has-success');
}

$(document).ready(function(){
    $('#edit_pwd').on('input',function(e) {
         var strongRegex = new RegExp("^(?=.{12,})(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*\\W).*$", "g");
         var mediumRegex = new RegExp("^(?=.{10,})(((?=.*[A-Z])(?=.*[a-z]))|((?=.*[A-Z])(?=.*[0-9]))|((?=.*[a-z])(?=.*[0-9]))).*$", "g");
         var enoughRegex = new RegExp("(?=.{8,}).*", "g");
         if (false == enoughRegex.test($(this).val())) {
            $('#progress-edit-text').html('More Characters');
            $('#progress-edit-strength').css('width','0%');
            $('#progress-edit-strength').removeClass('progress-bar-success');
            $('#progress-edit-strength').removeClass('progress-bar-danger');
            $('#progress-edit-strength').removeClass('progress-bar-warning');
            edit_pw_ok = false;
         } else if (strongRegex.test($(this).val())) {
            $('#progress-edit-text').html('Strong!');
            $('#progress-edit-strength').css('width','100%');  
            $('#progress-edit-strength').addClass('progress-bar-success');
            $('#progress-edit-strength').removeClass('progress-bar-warning');
            edit_pw_ok = true;
         } else if (mediumRegex.test($(this).val())) {
            $('#progress-edit-text').html('Medium!');
            $('#progress-edit-strength').css('width','67%');
            $('#progress-edit-strength').addClass('progress-bar-warning');
            $('#progress-edit-strength').removeClass('progress-bar-success');
            $('#progress-edit-strength').removeClass('progress-bar-danger');
            edit_pw_ok = true;
         } else {
            $('#progress-edit-text').html('Weak!');
            $('#progress-edit-strength').css('width','33%'); 
            $('#progress-edit-strength').addClass('progress-bar-danger');
            $('#progress-edit-strength').removeClass('progress-bar-warning');
            $('#progress-edit-strength').removeClass('progress-bar-success');
            edit_pw_ok = true;
         }
         return true;
    });
});

function CheckPwd2()
{
    var pwd_box = document.getElementById('pwd_box2').classList;
    var pwd_stat = document.getElementById('edit_pwd_stat').classList;
    
    if(edit_pw_ok == true)
    {
        if(pwd_box.contains('has-error'))
        {
            pwd_box.remove('has-error');
        }

        if(pwd_stat.contains('glyphicon-remove'))
        {
            pwd_stat.remove('glyphicon-remove');
        }

        pwd_box.add('has-success');
        pwd_stat.add('glyphicon-ok');
    }
    else
    {
        if(pwd_box.contains('has-success'))
        {
            pwd_box.remove('has-success');
        }

        if(pwd_stat.contains('glyphicon-ok'))
        {
            pwd_stat.remove('glyphicon-ok');
        }

        pwd_box.add('has-error');
        pwd_stat.add('glyphicon-remove');
    }
}

function CheckConfirmPassword2(values)
{
    var cpwd_box = document.getElementById('cpwd_box2').classList;
    var cpwd_stat = document.getElementById('add_cpwd_stat2').classList;
    var pwd_text = document.getElementById('edit_pwd').value;
    
    if(values == "")
    {
        if(cpwd_box.contains('has-success'))
        {
            cpwd_box.remove('has-success');
        }

        if(cpwd_stat.contains('glyphicon-ok'))
        {
            cpwd_stat.remove('glyphicon-ok');
        }

        cpwd_box.add('has-error');
        cpwd_stat.add('glyphicon-remove');
        edit_cpw_ok = false;
    }
    else if(values == pwd_text)
    {
        if(cpwd_box.contains('has-error'))
        {
            cpwd_box.remove('has-error');
        }

        if(cpwd_stat.contains('glyphicon-remove'))
        {
            cpwd_stat.remove('glyphicon-remove');
        }

        cpwd_box.add('has-success');
        cpwd_stat.add('glyphicon-ok');
        edit_cpw_ok = true;
    }
    else
    {
        if(cpwd_box.contains('has-success'))
        {
            cpwd_box.remove('has-success');
        }

        if(cpwd_stat.contains('glyphicon-ok'))
        {
            cpwd_stat.remove('glyphicon-ok');
        }

        cpwd_box.add('has-error');
        cpwd_stat.add('glyphicon-remove');
        edit_cpw_ok = false;
    }
}

function SubmitChangePassword(usr_id)
{
    if(edit_cpw_ok == true && edit_pw_ok == true)
    {
        if(confirm("Are you sure want to proceed? Once proceed cannot undone.") == false)
            return false;
        
        var pwd = document.getElementById('edit_pwd').value;
        
        var reqs = new XMLHttpRequest();
        reqs.onreadystatechange = function()
        {
            if(this.readyState == 4 && this.status == 200)
            {
                var res = JSON.parse(this.responseText);
                
                if(res['result'] == true)
                {
                    alert("Password changed.");
                    window.location.reload();
                }
                else
                {
                    alert("Change Failed.");
                    window.location.reload();
                }
            }
        };
        
        var input = {"types":"chg_pwd", "pwd2": pwd, "usr_id2": usr_id};
        var send_param = JSON.stringify(input);
        reqs.open('GET', 'Engines/PasswordChange_JSON.php?data='+send_param, true);
        reqs.send();   
        return false;
    }
    else
    {
        alert('Please input properly!');
        return false;
    }
}
