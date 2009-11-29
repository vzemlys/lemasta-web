<?
    include 'include/structure.php';
    include_once "include/misc.php";


//body("LEMASTA","LEMASTA","Valdymas","","pages/main/sideview.php","pages/main/main.php","")

?>
<html>

<? 
    head("LEMASTA",""); //We are at the top level 
    
?>
<body>

<script language="javascript" type="text/javascript" src="js/jquery-1.3.2.min.js"></script>          
<script language="javascript" type="text/javascript" src="js/jquery-ui-1.7.2.custom.min.js"></script>
<script language="javascript" type="text/javascript" src="js/jquery.form.js"></script>
<script language="javascript" type="text/javascript" src="js/flot/excanvas.js"></script>      
<script language="javascript" type="text/javascript" src="js/flot/jquery.flot.js"></script>      
<script language="javascript" type="text/javascript" src="js/jquery.blockUI.js"></script>      
<script language="javascript" type="text/javascript" src="js/lemasta.js"></script>      

<script id="source" language="javascript" type="text/javascript">  
    
//This prototype is provided by the Mozilla foundation and
//is distributed under the MIT license.
//http://www.ibiblio.org/pub/Linux/LICENSES/mit.license
    
if (!Array.prototype.map)
{
  Array.prototype.map = function(fun /*, thisp*/)
  {
    var len = this.length;
    if (typeof fun != "function")
      throw new TypeError();

    var res = new Array(len);
    var thisp = arguments[1];
    for (var i = 0; i < len; i++)
    {
      if (i in this)
        res[i] = fun.call(thisp, this[i], i, this);
    }

    return res;
  };
} 

//This prototype is provided by the Mozilla foundation and
//is distributed under the MIT license.
//http://www.ibiblio.org/pub/Linux/LICENSES/mit.license

if (!Array.prototype.forEach)
{
  Array.prototype.forEach = function(fun /*, thisp*/)
  {
    var len = this.length;
    if (typeof fun != "function")
      throw new TypeError();

    var thisp = arguments[1];
    for (var i = 0; i < len; i++)
    {
      if (i in this)
        fun.call(thisp, this[i], i, this);
    }
  };
}

$(document).ready(function() {
     
    window.cd=null;
    window.cdt=null;

    $.get("pages/query/forecast.php",xmltocontent);
    
    $("#tabs").tabs();
    $("#tabs").click(function(event) {
	var tg=$(event.target);
	var i=tg.attr("varno");
	if(i) {
	    var i=parseInt(i);
	    var scno=parseInt(tg.attr("scenno"));
	    var tbno=parseInt(tg.attr("tbno"));
	    var tbvarno=parseInt(tg.attr("tbvarno"));
       
	    var rnname="'rn"+scno+"type"+i+"'";
	    var lgsname="'lgs"+scno+"type"+i+"'";
	
	    var rn=$("input[name="+rnname+"]:checked").val();
	    var lgs=$("input[name="+lgsname+"]:checked").val();

	    if(!rn) {
		var rn="real";
		var rnname=""
	    }		
	    else {
		if(rn=="real") var rnname="realios kainos, ";
		if(rn=="nominal") var rnname="veikusios kainos, "
	    }
	    if(lgs=="level") var lgsname="lygiai";
	    if(lgs=="growth") var lgsname="augimai";
            if(lgs=="gdpshare") var lgsname="BVP dalis";

	    var kas=tg.val();

	    if(window.cd) {
		if(kas=="Lyginti") {
		    show(window.cd[rn][lgs][i]," ("+rnname+ lgsname+ ")");
		}
		else {
		    newrow=window.cd[rn][lgs][i].table[scno-1];
		    updtb(newrow,scno,tbno,tbvarno);
		}
	    }
	   
	}
    });
    
    $("#formtabs").tabs();
    var options= {
	success: showResponse,
	    beforeSubmit:  showRequest,
	    beforeSerialize: additionalInfo,
	error: showError,
	dataType: "xml"
    };
    
    $("#eform").ajaxForm(options);
    
    $("#eform").bind("keydown", function(e) {
	if (e.keyCode == 13) {
	    var tg=$(e.target);
	    var scno=parseInt(tg.attr("scenno"));
	    var varno=parseInt(tg.attr("varno"));
	    var valno=parseInt(tg.attr("valno"));
	    validateCell(scno,varno,valno);
	    //get the constants from the xml
	    if(varno==7) {
		if(valno==6) {
		    if(scno==3)	 {
			$("#formtabs").tabs('select',0);
			scno=1;
		    }
		    else {	    
			$("#formtabs").tabs('select',scno);
			scno=scno+1;
		    }
		    varno=1;
		    valno=4;

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
    });
 
    $('#OK').click(function() { 
            $.unblockUI(); 
            return false; 
        }); 
});
</script>

<div id="header">
<? 
mainheader("LEMASTA","Valdymas"); //These functions come from structure.php
//mainmenu("");	//main.php is included in index.php at top level
?>
</div>


<!-- Pagrindinio turinio pradžia-->
<div id="main-copy"> 
    <div id="tabs">
	 <ul>
	    <li><a href="#fragment-1"><span>Nustatymai</span></a></li>

	    <li><a href="#fragment-2"><span id="scenname1">Scenarijus 1</span></a></li>
	    <li><a href="#fragment-3"><span id="scenname2">Scenarijus 2</span></a></li>
	    <li><a href="#fragment-4"><span id="scenname3">Scenarijus 3</span></a></li>
	    <li><a href="#fragment-5"><span>Palyginimas</span></a></li>
	</ul>
	<div id="fragment-1">
	    <form id="eform" method="POST" action="pages/query/forecast.php">  
		<div id="formtabs">
		    <ul>
		      <li><a href="#frag-1"><span id="fscenname1">Scenarijus 1</span></a></li>
		      <li><a href="#frag-2"><span id="fscenname2">Scenarijus 2</span></a></li>
		      <li><a href="#frag-3"><span id="fscenname3">Scenarijus 3</span></a></li>
		    </ul>
		    <div id="frag-1"><div id="eformcont1"></div><div id="formerror1"></div></div>
		    <div id="frag-2"><div id="eformcont2"></div><div id="formerror2"></div></div>
		    <div id="frag-3"><div id="eformcont3"></div><div id="formerror3"></div></div>	
		</div>
		<div id="scenchoice"> </div>
		<div id="stringsubmit"></div>

		<input type='submit' value='Siųsti' id='submitegzo'/> 
		<input name="arname" type="hidden" value="egzo"/>
		<input name="sarname" type="hidden" value="scen"/>
		<input name="nrows"  type="hidden" value="3"/>
	    </form>
	</div>

	<div id="fragment-2"><div id="output1"></div></div>
	<div id="fragment-3"><div id="output2"></div></div>
	<div id="fragment-4"><div id="output3"></div></div>
	<div id="fragment-5">
	   <div id="comparison"></div>
	   <p id="choices">Rodyti:</p>
	   <div id ="placeholder" style="width:600px;height:300px;"></div>
	</div>
     </div>
</div> 
<!-- Pagrindinio turinio pabaiga -->

<div id="question" style="display:none; cursor: default"> 
        <h1 id="ajaxErrorMessage">Įvyko klaida</h1> 
        <input type="button" id="OK" value="OK" /> 
</div> 

</body>

</html>
