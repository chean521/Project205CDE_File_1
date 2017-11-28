/* Check Windows Opened */

var tm = null;
var x = null;

function open_win()
{
    chk();
    tm = setInterval(chk, 2000);
}

function chk()
{   
    if(x == null)
    {
        x = window.open('Admin_AddActivity.php','_blank');
    }
    
    if(x.closed)
    {
        window.location.reload();
        clearInterval(tm);
    }
    else
    {
        x.focus();
    }
}

