<? 
include_once "include/misc.php";
?>
<body>

<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>          
<script type="text/javascript" src="js/jquery-ui-1.7.2.custom.min.js"></script>
<script type="text/javascript" src="js/jquery.form.js"></script>
<script type="text/javascript" src="js/flot/jquery.flot.js"></script>      
<script type="text/javascript" src="js/lemasta.js"></script>      

<script type="text/javascript">  
var ajaxResponse=null;
$(document).ready(function() {
    var ajaxResponse=null;

    if(!ajaxResponse) {
	ajaxResponse=$.ajax({
	    async: true,
		type: "GET",
		url: "pages/query/resxml.php",
		success: function(xml){
		    tb=$("tb1",xml).text();    
		    $("#output1").html(tb);
		    $("#output2").html(tb);
		    $("#eform1cont").html($("form1",xml).text());
		    myfill($("csv",xml).text(),1);
		    myfill($("csv",xml).text(),2);

		}	
	});

    }
    $("#tabs").tabs();
    var options= {
	success: showResponse,
	dataType: "xml"
    };
    $("#eform1").ajaxForm(options);

});


</script>

<div id="header">
<? 
mainheader("LEMASTA","Valdymas"); //These functions come from structure.php
//mainmenu("");	//main.php is included in index.php at top level
?>
</div>

<div>

<div id="side-bar">
<? 
//include "pages/main/viewform.php";
?>
</div>

<!-- 
 Pasižiūrime ar buvo užkrauti nauji duomenys   
-->
<!-- Pagrindinio turinio pradžia-->
<div id="main-copy"> 
    <div id="tabs">

	 <ul>
	    <li><a href="#fragment-1"><span>Bazinis scenarijus</span></a></li>
	    <li><a href="#fragment-2"><span>Scenarijus 1</span></a></li>
	    <li><a href="#fragment-3"><span>Scenarijus 2</span></a></li>
	    <li><a href="#fragment-4"><span>Palyginimas</span></a></li>
	    <li><a href="#fragment-5"><span>Nustatymai</span></a></li>
	</ul>

	<div id="fragment-1">
	   <div id="output1"></div>
	   <div id ="placeholder1" style="width:600px;height:300px;"></div>

	</div>
	<div id="fragment-2">
	   <div id="output2"></div>
	   <div id ="placeholder2" style="width:600px;height:300px;"></div>

	</div>
	<div id="fragment-3">
	   <div id="output3"></div>
	   <div id ="placeholder3" style="width:600px;height:300px;"></div>

	</div>
	<div id="fragment-4">
	   <div id="output4"></div>
	   <div id ="placeholder4" style="width:600px;height:300px;"></div>
	</div>

	<div id="fragment-5">
	   	    <form id="eform1" method="POST" action="pages/query/forecast.php">

		<div id="eform1cont">
		</div>

		
		<input type='submit' value='Siųsti' id='submitegzo'/> 
		<input name="arname" type="hidden" value="egzo"/>
		<input name="nrows" type="hidden" value="13"/>

	    </form>
	</div>
    </div>

</div> 
<!-- Pagrindinio turinio pabaiga -->
</div>
</body>
