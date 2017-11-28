/* View Account Search Response Engine Side Script */

$(document).ready(function(e){GetUserDetails('');});

function GetUserDetails(uid)
{
    var data = {"uid":uid};
    
    var xmlhttp = new XMLHttpRequest();
    
    xmlhttp.onreadystatechange = function()
    {
        if(this.readyState == 4 && this.status == 200)
        {
            var result = JSON.parse(this.responseText);
            var container = document.getElementById('content_data');
            
            var write = '';
            
            for(var row=0; row < result.length; row++)
            {
                
                if(result[row][3] == 'admin')
                    continue;
                
                write += '<tr>';
                
                for(var col=0; col < result[0].length; col++)
                {
                    switch(col)
                    {
                        case 5:
                            if(result[row][col] == 'active')
                            {
                                write += '<td class="text-success">'+UcFirst(result[row][col])+'</td>';
                            }
                            else if(result[row][col] == 'pending')
                            {
                                write += '<td class="text-warning">'+UcFirst(result[row][col])+'</td>';
                            }
                            else
                            {
                                write += '<td class="text-danger">'+UcFirst(result[row][col])+'</td>';
                            }
                            
                            break;
                        
                        default:
                            write += '<td>'+UcFirst(result[row][col])+'</td>';
                            break;
                    }
                }
                
                write += '</tr>';
                
                
            }
            
            container.innerHTML = write;
        }
    };
    
    var send_param = JSON.stringify(data);
    xmlhttp.open("GET","Engines/ViewAccountGet_JSON.php?data="+send_param, true);
    xmlhttp.send();
}

function UcFirst(string)
{
    return string.charAt(0).toUpperCase() + string.slice(1);
}