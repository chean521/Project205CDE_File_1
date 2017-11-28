/* 
 * Sign Up Input JSON Request (Mixed)
 */

var user_id_ok = false;
var name_ok = false;
var program_ok = false;
var pwd_ok = false;
var cpwd_ok = false;

$(document).ready(function(){
    $('#add_pwd').on('input',function(e) {
         var strongRegex = new RegExp("^(?=.{12,})(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*\\W).*$", "g");
         var mediumRegex = new RegExp("^(?=.{10,})(((?=.*[A-Z])(?=.*[a-z]))|((?=.*[A-Z])(?=.*[0-9]))|((?=.*[a-z])(?=.*[0-9]))).*$", "g");
         var enoughRegex = new RegExp("(?=.{8,}).*", "g");
         if (false == enoughRegex.test($(this).val())) {
            $('#progress-text').html('More Characters');
            $('#progress-strength').css('width','0%');
            $('#progress-strength').removeClass('progress-bar-success');
            $('#progress-strength').removeClass('progress-bar-danger');
            $('#progress-strength').removeClass('progress-bar-warning');
            pwd_ok = false;
         } else if (strongRegex.test($(this).val())) {
            $('#progress-text').html('Strong!');
            $('#progress-strength').css('width','100%');  
            $('#progress-strength').addClass('progress-bar-success');
            $('#progress-strength').removeClass('progress-bar-warning');
            pwd_ok = true;
         } else if (mediumRegex.test($(this).val())) {
            $('#progress-text').html('Medium!');
            $('#progress-strength').css('width','67%');
            $('#progress-strength').addClass('progress-bar-warning');
            $('#progress-strength').removeClass('progress-bar-success');
            $('#progress-strength').removeClass('progress-bar-danger');
            pwd_ok = true;
         } else {
            $('#progress-text').html('Weak!');
            $('#progress-strength').css('width','33%'); 
            $('#progress-strength').addClass('progress-bar-danger');
            $('#progress-strength').removeClass('progress-bar-warning');
            $('#progress-strength').removeClass('progress-bar-success');
            pwd_ok = true;
         }
         return true;
    });
});

function CheckPwd()
{
    var pwd_box = document.getElementById('pwd_box').classList;
    var pwd_stat = document.getElementById('add_pwd_stat').classList;
    
    if(pwd_ok == true)
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

function CheckStudentID(values)
{
    var xmlhttp = new XMLHttpRequest();
    
    xmlhttp.onreadystatechange = function()
    {
        if(this.readyState == 4 && this.status == 200)
        {
            var data = JSON.parse(this.responseText);
            var id_box = document.getElementById('id_box').classList;
            var id_stat = document.getElementById('add_usr_stat').classList;
            
            switch(data['result'])
            {
                case "err_0":
                    if(id_box.contains('has-error'))
                    {
                        id_box.remove('has-error');
                    }
                    
                    if(id_stat.contains('glyphicon-remove'))
                    {
                        id_stat.remove('glyphicon-remove');
                    }
                    
                    id_box.add('has-success');
                    id_stat.add('glyphicon-ok');
                    user_id_ok = true;
                    
                    break;
                    
                case "err_1":
                case "err_2":
                    if(id_box.contains('has-success'))
                    {
                        id_box.remove('has-success');
                    }
                    
                    if(id_stat.contains('glyphicon-ok'))
                    {
                        id_stat.remove('glyphicon-ok');
                    }
                    
                    id_box.add('has-error');
                    id_stat.add('glyphicon-remove');
                    user_id_ok = false;
                    break;
            }
        }
    };
    
    var val = {"uid":values};
    var send_param = JSON.stringify(val);
    xmlhttp.open("GET","Engines/SignUpCheck_JSON.php?data="+send_param,true);
    xmlhttp.send();
}

function CheckNameLength(values)
{
    var name_box = document.getElementById('name_box').classList;
    var name_stat = document.getElementById('add_fname_stat').classList;
    
    var str = new String(values);
    if(str.length >= 10)
    {
        if(name_box.contains('has-error'))
        {
            name_box.remove('has-error');
        }

        if(name_stat.contains('glyphicon-remove'))
        {
            name_stat.remove('glyphicon-remove');
        }

        name_box.add('has-success');
        name_stat.add('glyphicon-ok');
        name_ok = true;
    }
    else
    {
        if(name_box.contains('has-success'))
        {
            name_box.remove('has-success');
        }

        if(name_stat.contains('glyphicon-ok'))
        {
            name_stat.remove('glyphicon-ok');
        }

        name_box.add('has-error');
        name_stat.add('glyphicon-remove');
        name_ok = false;
    }
}

function CheckConfirmPassword(values)
{
    var cpwd_box = document.getElementById('cpwd_box').classList;
    var cpwd_stat = document.getElementById('add_cpwd_stat').classList;
    var pwd_text = document.getElementById('add_pwd').value;
    
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
        cpwd_ok = false;
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
        cpwd_ok = true;
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
        cpwd_ok = false;
    }
}

function CheckProgrammeInput(values)
{
    var prog_box = document.getElementById('prog_box').classList;
    var prog_stat = document.getElementById('add_prog_stat').classList;
    
    var val = new String(values);
    
    if(val.length != 0)
    {
        if(prog_box.contains('has-error'))
        {
            prog_box.remove('has-error');
        }

        if(prog_stat.contains('glyphicon-remove'))
        {
            prog_stat.remove('glyphicon-remove');
        }

        prog_box.add('has-success');
        prog_stat.add('glyphicon-ok');
        program_ok = true;
    }
    else
    {
        if(prog_box.contains('has-success'))
        {
            prog_box.remove('has-success');
        }

        if(prog_stat.contains('glyphicon-ok'))
        {
            prog_stat.remove('glyphicon-ok');
        }

        prog_box.add('has-error');
        prog_stat.add('glyphicon-remove');
        program_ok = false;
    }
}

function SubmitData()
{
    if(user_id_ok == true && name_ok == true && program_ok == true && pwd_ok == true && cpwd_ok == true)
    {
        if(confirm("Are you sure want to continue?") == false)
            return false;
        
        var uid = document.getElementById('add_usr_id').value;
        var fname = document.getElementById('add_fname').value;
        var prog = document.getElementById('add_prog').value;
        var pwd = document.getElementById('add_pwd').value;
        
        var reqs = new XMLHttpRequest();
        
        reqs.onreadystatechange = function()
        {
            if(this.readyState == 4 && this.status == 200)
            {
                var data = JSON.parse(this.responseText);
                
                if(data["result"] == true)
                {
                    alert("Account created, pending for approval. (1-3 working day(s)).");
                    window.location.reload();
                }
                else
                {
                    alert("Account creation failed.");
                }
            }
        };
        
        var inputs = {"uid":uid,"fname":fname,"prog":prog,"pwd":pwd};
        var send_param = JSON.stringify(inputs);
        reqs.open("POST","Engines/SignUpSubmit_JSON.php", true);
        reqs.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        reqs.send("data=" + send_param);
    }
    
    return false;
}