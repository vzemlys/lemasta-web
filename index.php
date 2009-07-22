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
	var i=$(event.target).attr("varno");
	if(i) {
	    var i=parseInt(i);
	    if(window.cd)show(window.cd[i]);
	}
    });

    $("#formtabs").tabs();
    var options= {
	success: showResponse,
	beforeSubmit:  showRequest,
	error: showError,
	dataType: "xml"
    };
    $("#eform").ajaxForm(options);

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
	    <li><a href="#fragment-1"><span id="scenname1">Bazinis scenarijus</span></a></li>
	    <li><a href="#fragment-2"><span id="scenname2">Scenarijus 1</span></a></li>
	    <li><a href="#fragment-3"><span id="scenname3">Scenarijus 2</span></a></li>
	    <li><a href="#fragment-4"><span>Palyginimas</span></a></li>
	    <li><a href="#fragment-5"><span>Nustatymai</span></a></li>
	</ul>
	<div id="fragment-1"><div id="output1"></div></div>
	<div id="fragment-2"><div id="output2"></div></div>
	<div id="fragment-3"><div id="output3"></div></div>
	<div id="fragment-4">
	   <div id="comparison"></div>
	   <p id="choices">Rodyti:</p>
	   <div id ="placeholder" style="width:600px;height:300px;"></div>
	</div>
	<div id="fragment-5">
	    <form id="eform" method="POST" action="pages/query/forecast.php">  
		<div id="formtabs">
		    <ul>
		      <li><a href="#frag-1"><span id="fscenname1">Bazinis scenarijus</span></a></li>
		      <li><a href="#frag-2"><span id="fscenname2">Scenarijus 1</span></a></li>
		      <li><a href="#frag-3"><span id="fscenname3">Scenarijus 2</span></a></li>
		    </ul>
		    <div id="frag-1"><div id="eformcont1"></div></div>
		    <div id="frag-2"><div id="eformcont2"></div></div>
		    <div id="frag-3"><div id="eformcont3"></div></div>	
		</div>
		<div id="scenchoice"> </div>
		<input type='submit' value='Siųsti' id='submitegzo'/> 
		<input name="arname" type="hidden" value="egzo"/>
		<input name="sarname" type="hidden" value="scen"/>
    	   	<input name="nrows" type="hidden" value="10"/>
	    </form>
	</div>
    </div>
</div> 
<!-- Pagrindinio turinio pabaiga -->



</body>

</html>
