/* 
 *  Admin - Acticity Manager, JSON Request Javascript
 */



function delete_reqs()
{
    var ids = document.getElementsByName('id_selection');
    var selected_val='';
    
    for (var i = 0; i <= ids.length; i++)
    {
        if(ids[i].checked == true)
        {
            selected_val = ids[i].value;
            break;
        }
    }
    
    var reqs = new XMLHttpRequest();
    
    reqs.onreadystatechange = function()
    {
        if(this.readyState == 4 && this.status == 200)
        {
            var data = JSON.parse(this.responseText);
            
            alert("Activity Removed Successfully!");
            window.location.reload();
        }
    };
    
    var inputs = {"activity":selected_val,"type":"delete"};
    var send_param = JSON.stringify(inputs);
    reqs.open("GET", "Engines/ActivityManager_JSON.php?data="+send_param, true);
    reqs.send();
}