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
    $("#tabs").tabs('select',4);
    $("#comparison").html(ctable(sob));
    
    var choiceContainer = $("#choices");
    choiceContainer.html("Rodyti:");
    fplot.forEach(function(x, idx) {
        choiceContainer.append('<input type="checkbox" scen="' + idx + '" checked="checked" > ' + sob.labels[idx]  + '</input>');
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

function prepare(csv) {
    var tmp=[];
    function splittab(block) {
	return block.split("\t");	
    }
    tmp=csv.map(function(ind) {
		    res=ind.csv.split("\n");
		    res=res.map(splittab);
		    return res;
		});
    var novar=tmp[0].length;
    var years=tmp[0][0].slice(1);
    var snames=csv.map(function(ind){
		return ind.name;
	    })
    var res=[];
    for(var j=1;j<novar-1;j++) {
	
	var table=[];
	for(i=0;i<csv.length;i++) {
	    table.push(tmp[i][j].slice(1));
	}

	res.push({title: tmp[0][j][0],
		  years: years,
		  table: table,
		  labels: snames   
		});
    }
    return res;
}

function toflot(sob) {
    var noscen=sob.table.length;
    var res=[];
    var time=[2006,2007,2008,2009,2010,2011];
    for(i=0;i<noscen;i++) {
	var data=[];
    	for(j=0;j<sob.table[i].length;j++) {
	    data.push([time[j],parseFloat(sob.table[i][j])]);
	}
	res.push({
	    label: sob.labels[i],
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
		scen="<td>"+sob.labels[i]+"</td>";
		return "<tr>"+scen+res.join(" ")+"</tr>";
	    }) 
    	
    html=html+table.join("\n")+"</table>";
    return html;
}

function showRequest(formData, jqForm, options) { 
    $.blockUI({message: "<h1><img src='css/bigrotation2.gif'>Palaukite, vyksta skaičiavimai</h1>"});
    return true; 
} 

function showResponse(xml, statusText)  { 
    $.unblockUI();
    xmltocontent(xml);
} 

function showError(XMLHttpRequest, textStatus, errorThrown) {
    $.unblockUI();
    $("#ajaxErrorMessage").html(XMLHttpRequest.responseText)
    $.blockUI({ message: $('#question'),timeout: 1500 }); 
    //alert(XMLHttpRequest.responseText);
}

function fillscenario(scen) {
     
     var id=$("number",scen).text();
     var name=$("name",scen).text();
     var tb=$("tb1",scen).text(); 

     $("#output"+id).html(tb); //Fill out table data     
     $("#scenname"+id).html(name); //Change tab name
     $("#fscenname"+id).html(name); //Change scenario tab name

//Start filling form pages
     var fr=$("form",scen);
     if(fr.length!=0) {
	fr=fr.text();
	var html="Scenarijaus pavadinimas <input name='scenname"+id+"'type='text' value='" + name+ "'/><br>";
	html=html+fr;
 	
	$("#eformcont"+id).html(html);
	$("#scenchoice").append('<input type="checkbox" name="fscensend[]" checked="checked" value="'+id+'">'+ name + '</input>');	
     }
}

function xmltocontent(xml) {
    var cdt=[];
    cdt=jQuery.map($("scenario",xml),function(scen,no){
	    fillscenario(scen);	
	    return {csv: $("csv",scen).text(),
		    name: $("name",scen).text(), 
		    id : $("number",scen).text()
		    };
	    });
    if(!window.cdt) {
	window.cdt=cdt;	
    }
    else {
	jQuery.each(cdt,function(){
		var i=parseInt(this.id)-1;
		window.cdt[i]=this;
    		});	
	$("#tabs").tabs('select',parseInt(cdt[0].id)-1);
	window.scroll(0,0);
    }
    window.cd=prepare(window.cdt);
}
