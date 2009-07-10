<? 
include_once "include/misc.php";
?>
<body>
<script type="text/javascript" src="js/jquery-1.3.2.js"></script>          
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
		    //	alert( "Data Saved: " + msg );
//			alert(xml);
			tb=$("tb1",xml).text();    
//			alert(tb);
			$("#output").html(tb);
			myfill($("csv",xml).text());
		    }	
		});

	     }
	});


</script>

<div id="header">
<? 
mainheader("LEMASTA","Valdymas"); //These functions come from structure.php
mainmenu("");	//main.php is included in index.php at top level
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
<div id="output"></div>
<div id ="placeholder" style="width:600px;height:300px;">
</div>
</div> 
<!-- Pagrindinio turinio pabaiga -->
</div>
</body>
