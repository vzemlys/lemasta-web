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


function show(sob,expl) {
    var previousPoint = null;
    fplot=toflot(sob);
    $("#tabs").tabs('select',4);
    $("#comparison").html(ctable(sob,expl));
    
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
function breakdown(csv) {
    return {
	real : {
		level:  prepare(pick(csv,"real","level")),
		growth: prepare(pick(csv,"real","growth")),
		gdpshare: prepare(pick(csv,"real","gdpshare"))
	       },
	nominal : {
		level:  prepare(pick(csv,"nominal","level")),
		growth: prepare(pick(csv,"nominal","growth")),
		gdpshare: prepare(pick(csv,"nominal","gdpshare"))
    	     }
       }

}

function pick(csv,lev1,lev2) {
   var tmp=csv.map(function(ind){
	    return {
		csv: $(lev2,$(lev1,ind.csv)).text(),
		name: ind.name,
		id: ind.id	
	    }
	   });
   return tmp;

}
function fbreak(fcdt) {
    return {
	level : csv2arr($("level",$("fbase",fcdt)).text()),
	growth :csv2arr($("growth",$("fbase",fcdt)).text()),
	upper : csv2arr($("upper",$("frest",fcdt)).text()),
	lower : csv2arr($("lower",$("frest",fcdt)).text())
    }

}
function csv2arr(csv) {
    var tmp=[];
    function splittab(block) {
	return block.split("\t");	
    }
    tmp=csv.split("\n");
    var res=tmp.map(splittab);
    return res;
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
    var years=tmp[0][0].slice(2);
    var snames=csv.map(function(ind){
		return ind.name;
	    })
    var res=[];
    for(var j=1;j<novar;j++) {
	
	var table=[];
	for(var i=0;i<csv.length;i++) {
	    table.push(tmp[i][j].slice(2));
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
    for(var i=0;i<noscen;i++) {
	var data=[];
    	for(var j=0;j<sob.table[i].length;j++) {
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

function updtb(newrow,scno,tbno,tbrowno) {
    var tbid="#table"+tbno+"-"+scno;
    var myrow=$(tbid+" tr").eq(tbrowno);
    var mycells=$("td",myrow);
    newrow=toFixed2(newrow);
    for(var i=0;i<newrow.length;i++) {
	mycells.eq(i+3).html(newrow[i]);
    }
}

function toFixed2(arr) {
    res=arr.map(function(f) {
	    return parseFloat(f).toFixed(2)
	    });
    return res;
}

function ctable(sob,expl) {
    var html="";
    html=html+"<h2 class='center'>"+sob.title+expl+"</h2>";
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

function additionalInfo() {
    var valid=true;
    $("#scenchoice").find("input:checked").each(function () {
            var key = $(this).val();
	    key = parseInt(key);
	    var validscen =  validateScen(key);
	    valid=valid && validscen
	    if(validscen) {
		$("#eform input[name='scensend"+key+"']").val(serializeScen(key));
	    }
        });
    return valid;
}

function serializeScen(scno) {
    var tr=$("#scentable"+scno+" tr");
    var res="";
    //omit header row
    for(var i=1;i<=window.lc.nofvar;i++) {
	var crow = tr.eq(i);
	var ccells=$("input",crow);
	for(var j=0;j<=window.lc.inpend;j++) {
	    res=res+ccells.eq(j).val()+";";
	}
	res=res+"&";
    }
    return res;  
}

function validateScen(scno) {
    var valid=true;
	for(var i=1;i<=7;i++) {
	    for(var j=4;j<=6;j++) {
		valid=valid && validateCell(scno,i,j);	
	    }
	}
    return valid;
}
function matchlength(m) {
    if(m==null) {
	return 0;
    }
    else {
	return m.length;
    }
}

function validateCell(scno,varno,valno) {
    var inp=$("#valinp"+scno+"-"+varno+"-"+valno);
	
    var str=inp.val();
    var low=parseFloat(window.fb.lower[varno][valno]);
    var upp=parseFloat(window.fb.upper[varno][valno]);
    
    var nm=window.fb.lower[varno][0];
    var yr=window.fb.lower[0][valno];

    var hadError=inp.hasClass("error");
    if(str=="") {
	inp.val(parseFloat(window.fb.level[varno][valno]).toFixed(2));
	inp.removeClass("error");
        $("#formerror"+scno).html();
	return true;
    }
    else {
        if(str.match(/[0-9,.]/)) {
	    str=str.replace(/[,]/g,".");
	    dotm=matchlength(str.match(/[.]/g));
	    if(dotm<=1) {
		inp.val(str);
		var val=parseFloat(str);
			if(val>=low & val<=upp) {
		    inp.removeClass("error");
		    if(hadError) {
			$("#formerror"+scno).html("");
		    }
		    return true;
		}
	    }
	}
    }
    inp.addClass("error");
    $("#formerror"+scno).html("<strong class='error'>Rodiklio „"+nm+"“ reikšmė "+yr+" metais turi būti tarp "+low.toFixed(2)+ " ir " + upp.toFixed(2) + " </strong>");
    return false;
}

function showBounds(scno,varno,valno) {
    var inp=$("#valinp"+scno+"-"+varno+"-"+valno);
    
    if(inp.hasClass("error")) {
	var low=parseFloat(window.fb.lower[varno][valno]);
	var upp=parseFloat(window.fb.upper[varno][valno]);
	var nm=window.fb.lower[varno][0];
        var yr=window.fb.lower[0][valno];

//	$("#formerror"+scno).html("<strong class='error'>Reikšmė turi būti tarp "+low.toFixed(2)+ " ir " + upp.toFixed(2) + " </strong>");
        $("#formerror"+scno).html("<strong class='error'>Rodiklio „"+nm+"“ reikšmė "+yr+" metais turi būti tarp "+low.toFixed(2)+ " ir " + upp.toFixed(2) + " </strong>");

    }
   return true;      
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
    
     var tbhtml="";

     jQuery.map($("table",scen),function(tb,no){
		tbhtml=tbhtml+"<h2 class='center'>"+$("tbname",tb).text()+"</h2>\n";
		tbhtml=tbhtml+"<br>\n";
		tbhtml=tbhtml+$("data",tb).text()+"\n"; //Fill out table data     
		tbhtml=tbhtml+"<br>\n";
	     });
      
     $("#output"+id).html(tbhtml);
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

	$("#stringsubmit").append('<input name="scensend'+id+ '" type="hidden", value="Nothing" id="scensend"'+id+'" </input>');
     }
     

}

function xmltocontent(xml) {
    var cdt=[];
    
    cdt=jQuery.map($("scenario",xml),function(scen,no){
	    fillscenario(scen);	
	    return {csv: $("csv",scen),
		    name: $("name",scen).text(), 
		    id : $("number",scen).text()
		    };
	    });
    
    if(!window.fb) {
        var fbt=$("rest",xml);
        window.fb=fbreak(fbt);
	window.lc={
	    noscen : cdt.length,
	    nofvar : window.fb.level.length-1,
	    inpstart: 4,
	    inpend: window.fb.level[0].length-1
	};
	$("#eform").bind("keydown", tablenavigate)
    }
    
    var frmi=$("#eform input[type=text]");

    frmi.blur(function(event){
	var tg=$(event.target);
	var scno=parseInt(tg.attr("scenno"));
	var varno=parseInt(tg.attr("varno"));
	var valno=parseInt(tg.attr("valno"));
	
	validateCell(scno,varno,valno);
			
    });
    frmi.focus(function(event){
	var tg=$(event.target);
	var scno=parseInt(tg.attr("scenno"));
	var varno=parseInt(tg.attr("varno"));
	var valno=parseInt(tg.attr("valno"));
	
	showBounds(scno,varno,valno);
    });
   /* $("#eform input[type=text]").blur(function(event){
	var tg=$(event.target);
	var scno=parseInt(tg.attr("scenno"));
	var varno=parseInt(tg.attr("varno"));
	var valno=parseInt(tg.attr("valno"));
	
	validateCell(scno,varno,valno);
			
    });*/
    
    $("#eform input[name='nrows']").val(window.lc.nofvar);

    if(!window.cdt) {
	window.cdt=cdt;	
    }
    else {
	jQuery.each(cdt,function(){
		var i=parseInt(this.id)-1;
		window.cdt[i]=this;
    		});	
	$("#tabs").tabs('select',parseInt(cdt[0].id));
	window.scroll(0,0);
    }
   window.cd=breakdown(window.cdt);
}

function tablenavigate(e) {
   	if (e.keyCode == 13) {
	    var tg=$(e.target);
	    var scno=parseInt(tg.attr("scenno"));
	    var varno=parseInt(tg.attr("varno"));
	    var valno=parseInt(tg.attr("valno"));
	    validateCell(scno,varno,valno);
	    //get the constants from the xml
	    var rowmax=window.lc.nofvar;
	    var colmax=window.lc.inpend;
	    var scenmax=window.lc.noscen;
	    var valstart=window.lc.inpstart;

	    if(varno==rowmax) {
		if(valno==colmax) {
		    if(scno==scenmax)	 {
			$("#formtabs").tabs('select',0);
			scno=1;
		    }
		    else {	    
			$("#formtabs").tabs('select',scno);
			scno=scno+1;
		    }
		    varno=1;
		    valno=valstart;

		}
		else {
		    valno=valno+1;
		    varno=1;
		}
	    }
	    else {
		varno=varno+1;
	    }
	    var inp=$("#valinp"+scno+"-"+varno+"-"+valno);
	    inp.focus();		
    
	    return false; //prevent default behaviour
	}
 
}
