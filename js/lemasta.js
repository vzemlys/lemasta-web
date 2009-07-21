function showTooltip(x, y, contents) {
    $('<div id="tooltip">' + contents + '</div>').css( {
		position: 'absolute',
		display: 'none',
		top: y + 5,
		left: x + 5,
		border: '1px solid #fdd',
		padding: '2px',
		'background-color': '#fee',
		opacity: 0.80
	    }).appendTo("body").fadeIn(200);
}


function show(sob) {
    var previousPoint = null;
    fplot=toflot(sob);
    $("#tabs").tabs('select',3);
    $("#comparison").html(ctable(sob));
    
    var choiceContainer = $("#choices");
    choiceContainer.html("Rodyti:");
    fplot.forEach(function(x, idx) {
        choiceContainer.append('<input type="checkbox" scen="' + idx + '" checked="checked" > Scenarijus ' + (idx+1)  + '</input>');
    });

    choiceContainer.find("input").click(function() {
	    plotAccordingToChoices(fplot);
	    });

    plotAccordingToChoices(fplot);

}

function plotAccordingToChoices(fplot) {
        var data = [];
        $("#choices").find("input:checked").each(function () {
            var key = $(this).attr("scen");
	    key = parseInt(key);
            data.push(fplot[key]);
        });
	
	if (data.length > 0) {
	    var plot=$.plot($("#placeholder"), 
		    data,
		    {lines: {show: true },
		    points: {show: true },
		    grid: { hoverable: true, clickable: true},
		    xaxis: { mode: null, tickSize: 1, tickDecimals: 0} }
    	    );
	    var previousPoint = null;
     	    $("#placeholder").bind("plothover", function (event, pos, item) {
	    if (item) {
		if (previousPoint != item.datapoint) {
		    previousPoint = item.datapoint;

		    $("#tooltip").remove();
		    var    y = item.datapoint[1];
		    y=parseFloat(y).toFixed(2);
		    showTooltip(item.pageX, item.pageY, y);
		}
	    }
	    else {
		$("#tooltip").remove();
		previousPoint = null;            
	    }
	});
    }
    else {
	$("#placeholder").html("");
    }

}

function myfill(cdata,tabno) {
    $("#output"+tabno).find("input[scen0"+tabno+"]").each(function(i) {
	    $(this).click(
		function(){
		show(cdata[i]);
		})
	    });
}

function prepare(csv) {
    var tmp=[];
    function splittab(block) {
	return block.split("\t");	
    }
    tmp=csv.map(function(ind) {
		    res=ind.split("\n");
		    res=res.map(splittab);
		    return res;
		});
    var novar=tmp[0].length;
    var years=tmp[0][0].slice(1);
    var res=[];
    for(var j=1;j<novar-1;j++) {
	
	var table=[];
	for(i=0;i<csv.length;i++) {
	    table.push(tmp[i][j].slice(1));
	}

	res.push({title: tmp[0][j][0],
		  years: years,
		  table: table
		});
    }
    return res;
}

function toflot(sob) {
    var noscen=sob.table.length;
    var res=[];
    var time=[2008,2009,2010,2011,2012];
    for(i=0;i<noscen;i++) {
	var data=[];
    	for(j=0;j<sob.table[i].length;j++) {
	    data.push([time[j],parseFloat(sob.table[i][j])]);
	}
	res.push({
	    label: "scen"+(i+1),
	    color: i,
	    data: data
	})
    }
    return res;
}

function ctable(sob) {
    var html="";
    html=html+"<h2 class='center'>"+sob.title+"</h2>";
    html=html+"<table border=1 cellpadding=2 class='center'>";
    html=html+"<tr><th>Scenarijus</th>";
 
    var header=sob.years.map(function(val) {
		return "<th>"+val+"</th>";
	    })
    
    html=html+header.join(" ")+"</tr>\n";
    var table=sob.table.map(function(val,i){
		res=val.map(function(col){
		    return "<td align='right'>"+parseFloat(col).toFixed(3)+"</td>";
    		    })
		scen="<td> Scenarijus"+(i+1)+"</td>";
		return "<tr>"+scen+res.join(" ")+"</tr>";
	    }) 
    	
    html=html+table.join("\n")+"</table>";
    return html;
}
function preparr(arr) {
    var time=[2007,2008,2009,2010,2011,2012];
    var res=[];
    for (var i=1; i<arr.length-1; i++) {
	var row=arr[i].split("\t");
	var temp=[];
	for(var j=1;j<row.length; j++) {
	    temp.push([time[j],row[j]]);
	}
	res.push(temp);
    }
    return res;
}
function showResponse(xml, statusText)  { 
    // for normal html responses, the first argument to the success callback 
    // is the XMLHttpRequest object's responseText property 

    // if the ajaxForm method was passed an Options Object with the dataType 
    // property set to 'xml' then the first argument to the success callback 
    // is the XMLHttpRequest object's responseXML property 

    // if the ajaxForm method was passed an Options Object with the dataType 
    // property set to 'json' then the first argument to the success callback 
    // is the json data object returned by the server 
    //alert(responseText) 
  //  $("#output3").html($("tmp",xml).text());
    $("#tabs").tabs('select',2);
    window.scroll(0,0);
} 
