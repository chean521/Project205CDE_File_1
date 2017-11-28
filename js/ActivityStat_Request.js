/* 
 * Activity Statistic JSON Request Engine
 * 
 * Created By Oscar Loh
 * 
 */

var pid = "";
var timer = null;
var cand_id = null;
var each_percent = null;
var changed = true;
var last_data = null;
var ctx = null;
var chart = null;
var repeats = 0;

var pro_stat = document.getElementById('prog_stat');
var pro_id = document.getElementById('act_id');
var pro_desc = document.getElementById('act_desc');
var pro_date  = document.getElementById('date_sn');
var pro_detls = document.getElementById('prog_details');

function OnResultChanged(activity_id)
{    
    if(activity_id == "" || activity_id == null)
    {
        document.getElementById('form-display').style.display = 'none';
        return;
    }
    
    document.getElementById('form-display').style.display = 'initial';
    var data_send = {"types":"gets","pid":activity_id};
    var xmlhttp = new XMLHttpRequest();
    pid = activity_id;

    xmlhttp.onreadystatechange = function() 
    {
        if(this.readyState == 4 && this.status == 200)
        {
            var data_obj = JSON.parse(this.responseText);
            
            if(data_obj != null)
            {
                if(timer!= null)
                    clearInterval(timer);
                
                if(ctx != null)
                    ctx = null;
                
                if(chart != null)
                    chart = null;
                
                if(repeats > 0)
                    repeats = 0;
                
                var today = new Date().getTime();
                var end = new Date(data_obj[0]['act_end']);
                
                if(today > end.getTime())
                {
                    addClass(pro_stat, "text-danger");
                    
                    removeClass(pro_stat, "text-success");
                    
                    pro_stat.innerHTML = "Ended";
                }
                else
                {
                    addClass(pro_stat, "text-success");
                    
                    removeClass(pro_stat, "text-danger");
                    
                    pro_stat.innerHTML = "In Progress";
                }
                
                pro_id.innerHTML = data_obj[0]['act_id'];
                pro_desc.innerHTML = data_obj[0]['act_ttl'];
                pro_date.innerHTML = 'Date Start: ' + data_obj[0]['act_start'] + ', Date End: ' + data_obj[0]['act_end'];
                
                LiveResult();
            }
            else
            {
                clearInterval(timer);
            }
        }
    };

    var send_param = JSON.stringify(data_send);
    xmlhttp.open("GET", "Engines/GetVoteRes_JSON.php?data="+send_param, true);
    xmlhttp.send();
}

function LiveResult()
{
    var data_send = {"types":"live","pid":pid};
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function() 
    {
        if(this.readyState == 4 && this.status == 200)
        {
            var data_obj = JSON.parse(this.responseText);
            
            if(repeats == 0)
            {
                WriteBarChart(data_obj[1],data_obj[2]);
                repeats++;
                last_data = data_obj[2];
            }
            else
            {
                var isChanged = false;
                
                for(var i=0; i<last_data.length; i++)
                {
                    if(data_obj[2][i] != last_data[i])
                    {
                        isChanged = true;
                        break;
                    }
                    else
                    {
                        isChanged = false;
                    }
                }
                
                if(isChanged == true)
                {
                    removeData(chart);
                    addData(chart,data_obj[2]);
                    isChanged = false;
                    last_data = data_obj[2];
                }
            }
        }
    };

    var send_param = JSON.stringify(data_send);
    xmlhttp.open("GET", "Engines/GetVoteRes_JSON.php?data="+send_param, true);
    xmlhttp.send();
}

function UcFirst(string)
{
    return string.charAt(0).toUpperCase() + string.slice(1);
}

function addData(chart, data) {
    var datas = chart.data.datasets[0].data;
    
    var total = 0;
    
    for(var i=0; i<data.length; i++)
    {
        total += parseInt(data[i]);
    }
        
    for(var i=0; i<data.length; i++)
    {
        var percent = Math.round(( parseInt(data[i])/total) * 100);
        datas[i] = percent;
    }
    
    chart.update();
}

function removeData(chart) {
    
    var data = chart.data.datasets[0].data;
    
    for(var i=0; i<data.length; i++)
    {
        data.pop();
    }
    
    chart.update();
}

function WriteBarChart(cand_name, cand_res)
{ 
    var total = 0;
    
    for(var i=0; i<cand_res.length; i++)
    {
        total += parseInt(cand_res[i]);
    }
    
    var tmp = [];
    
    for(var i=0; i<cand_res.length; i++)
    {
        var percent = Math.round(( parseInt(cand_res[i])/total) * 100);
        tmp.push(percent);
    }
    
    var chartdata = {
        labels: cand_name,
        datasets : [
            {
                label: 'Candidate 1',
                backgroundColor: [
                'rgba(0, 255, 0, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 0, 0, 0.2)',
                'rgba(255, 0, 255, 0.2)',
                'rgba(255, 255, 0, 0.2)',
                'rgba(244, 194, 66, 0.2)',
                'rgba(81, 232, 232, 0.2)',
                'rgba(226, 55, 229, 0.2)',
                'rgba(209, 31, 96, 0.2)',
                'rgba(151, 255, 33, 0.2)'
                ]
                ,borderColor: [
                'rgba(0, 255, 0, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 0, 0, 1)',
                'rgba(255, 0, 255, 1)',
                'rgba(255, 255, 0, 1)',
                'rgba(244, 194, 66, 1)',
                'rgba(81, 232, 232, 1)',
                'rgba(226, 55, 229, 1)',
                'rgba(209, 31, 96, 1)',
                'rgba(151, 255, 33, 1)'
                ],
                data: tmp,
                borderWidth: 1
            }
        ]
    };
    
    var opt = {
        responsive: true,
        scales:{
            xAxes: [{
                ticks: {
                    min: 0,
                    max: 100,
                    callback: function(value) {
                        return value + "%";
                    }
                },
                scaleLabel:{
                    display: true,
                    labelString: "Percentage of Voted"
                }
            }]
        },
        title: {
            display: true,
            text: 'Total Activity Result for #'+pid
        },
        animation: {
            animateScale: true,
            animateRotate: true
        },
        legend: {
            display: false,
            position: "right",
            labels: {
                fontColor: "#333",
                fontSize: 10
            }
        },
        tooltips: {
            callbacks: {
               label: function(tooltipItem) {
                    return tooltipItem.yLabel + " Percentage";
               }
            }
        }
    };  
    
    ctx = document.getElementById('charts').getContext('2d');
    ctx.canvas.width = 650;
    ctx.canvas.height = 100;
    
    chart = new Chart(ctx, {type: 'horizontalBar', data: chartdata, options: opt});
    timer = setInterval(LiveResult, 1000);
}


function addClass(element,className) {
  var currentClassName = element.getAttribute("class");
  if (typeof currentClassName!== "undefined" && currentClassName) {
    element.setAttribute("class",currentClassName + " "+ className);
  }
  else {
    element.setAttribute("class",className); 
  }
}
function removeClass(element,className) {
  var currentClassName = element.getAttribute("class");
  if (typeof currentClassName!== "undefined" && currentClassName) {

    var class2RemoveIndex = currentClassName.indexOf(className);
    if (class2RemoveIndex != -1) {
        var class2Remove = currentClassName.substr(class2RemoveIndex, className.length);
        var updatedClassName = currentClassName.replace(class2Remove,"").trim();
        element.setAttribute("class",updatedClassName);
    }
  }
  else {
    element.removeAttribute("class");   
  } 
}