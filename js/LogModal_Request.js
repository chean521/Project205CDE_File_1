// Login Engine

function GetData()
{
    var id = document.getElementById('usr_id').value;
    var pwd = document.getElementById('pwd').value;
    
    AuthLoginData(id,pwd);
    return false;
}

function AuthLoginData(usr_id, usr_pwd)
{
    var send_arr = {"uid":usr_id, "pwd":usr_pwd};
    var xmlhttp = new XMLHttpRequest();
    
    xmlhttp.onreadystatechange = function()
    {
        var err = document.getElementById('err_msg');
        
        if(this.readyState == 4 && this.status == 200)
        {
            var data_obj = JSON.parse(this.responseText);
            
            if(data_obj["studentID"] == null)
            {
                err.innerHTML = '<i class="glyphicon glyphicon-remove"></i>&nbsp;&nbsp;Invalid ID and password Combination.';
                err.className = 'text text-danger';
            }
            else
            {
                err.innerHTML = '<i class="glyphicon glyphicon-ok"></i>&nbsp;&nbsp;Login Success.';
                err.className = 'text text-success';
                setTimeout(Reloading,1000);
            }
        }
        
    };
    
    var send_param = JSON.stringify(send_arr);
    xmlhttp.open("GET", "Engines/LoginReqs_JSON.php?data=" + send_param, true);
    xmlhttp.send();
}

function Reloading()
{
    window.location.reload();
}