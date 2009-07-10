<? 
include_once "include/misc.php";
?>
<body>

<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>          
<script type="text/javascript" src="js/jquery-ui-1.7.2.custom.min.js"></script>
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
			$("#output").html(tb);
			myfill($("csv",xml).text());
		    }	
		});

	     }
	     $("#tabs").tabs();
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
	    <li><a href="#fragment-4"><span>Nustatymai</span></a></li>
	</ul>

	<div id="fragment-1">
	   <div id="output"></div>
	   <div id ="placeholder" style="width:600px;height:300px;"></div>

	</div>
	<div id="fragment-2">
	   Kol kas nieko   
	</div>
	<div id="fragment-3">
	    Kol kas nieko irgi	
	</div>
	<div id="fragment-4">
	    Kol kas nieko irgi	
	</div>
    </div>

</div> 
<!-- Pagrindinio turinio pabaiga -->
</div>
</body>
