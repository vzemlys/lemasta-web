<? 
include_once "include/misc.php";
?>
<body>
<div id="header">
<? 
mainheader("LEMASTA","Valdymas"); //These functions come from structure.php
mainmenu("");	//main.php is included in index.php at top level
?>
</div>

<div>
<div id="side-bar">
<? 
include "pages/main/viewform.php";
?>
</div>

<!-- 
 Pasižiūrime ar buvo užkrauti nauji duomenys   
-->
<!-- Pagrindinio turinio pradžia-->
<div id="main-copy"> 

<!--
Vaizduojame lenteles
-->
<?
include "R/ftable.html"
?>
<!--
Tikriname ar buvo prašyta parodyti grafikus ir juos rodome
-->
<?
include "pages/main/show.php"
?>
</div> 
<!-- Pagrindinio turinio pabaiga -->
</div>
</body>
