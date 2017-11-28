/* User Authorization Response Engine Side Script */

var action;
var response;
var tag;

function SetAction(act,target)
{
    action = act;
    tag = target;
}

function SetResponse(resp)
{
    if(resp=="no")
    {
        action="";
        target_id="";
    }
}

function TrueResult()
{
    var reqs = {"target":tag, "action":action};
    var xmlhttp = new XMLHttpRequest();
    
    xmlhttp.onreadystatechange = function()
    {
        if(this.readyState == 4 && this.status == 200)
        {
            var data_obj = JSON.parse(this.responseText);
            
            if(data_obj["result"] == "success")
            {
                alert("Operation successfully!");
                window.location.reload();
            }
            else
            {
                alert("Process failed!");
                window.location.reload();
            }
        }
    };
    
    var send_param = JSON.stringify(reqs);
    xmlhttp.open("GET", "Engines/UserAuthorization_JSON.php?data=" + send_param, true);
    xmlhttp.send();
    
}