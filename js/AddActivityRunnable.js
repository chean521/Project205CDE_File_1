/* Add Candidate in Activity Engine  */


var candidates = 0;
var cand_name = [];
var cand_id = [];

function AddCandidate()
{
    if(candidates >= 10)
    {
        alert("Candidates Maximum limit reached");
    }
    else
    {
        var tb = document.getElementById('cand_table').getElementsByTagName('tbody')[0];
        var row = tb.insertRow(tb.rows.length);
        var cell_1 = row.insertCell(0);
        var cell_2 = row.insertCell(1);
        var cell_3 = row.insertCell(2);
        var cell_4 = row.insertCell(3);
        var tmp;
        
        tmp = '<select name="cand_id[]" class="form-control" required><option value="" selected>Please select</option>';
        
        for(var i=0; i<cand_id.length; i++)
        {
            tmp += '<option value="'+cand_id[i]+'">'+cand_name[i]+' - ' + UcFirst(cand_id[i]) + '</option>';
        }
        
        tmp += '</select>';
        
        cell_1.innerHTML = tmp;
        cell_2.innerHTML = '<input type="text" class="form-control" name="cand_desc[]" maxlength="200" required placeholder="About this candidate"/>';
        cell_3.innerHTML = '<input type="file" class="form-control" name="photo[]" accept="image/*" required/>';
        cell_4.innerHTML = '<button type="button" class="btn btn-danger" onclick="DeleteRow(this);">Remove</button>';
        
        candidates++;
        
        document.getElementById('add_no').innerHTML = (10-candidates);
    }   
}

function DeleteRow(row)
{
    var i = row.parentNode.parentNode.rowIndex;
    document.getElementById('cand_table').deleteRow(i);
    candidates--;
    
    document.getElementById('add_no').innerHTML = (10-candidates);
}

function GetCandSelection()
{
    var xmlhttp = new XMLHttpRequest();
    
    xmlhttp.onreadystatechange = function()
    {
        if(this.readyState == 4 && this.status == 200)
        {
            var result = JSON.parse(this.responseText);
            
            for(var i=0; i<result.length; i++)
            {
                cand_id.push(result[i][0]);
                cand_name.push(result[i][1]);
            }
        }
    };
    
    xmlhttp.open('GET', 'Engines/GetCandidateSelect_JSON.php', true);
    xmlhttp.send();
}

function UcFirst(string)
{
    return string.charAt(0).toUpperCase() + string.slice(1);
}

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
    