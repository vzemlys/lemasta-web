<?php
    function mainheader($title,$subtitle) {
?>
<div class="superHeader">
        <!--<span>Susiję puslapiai:</span>
        <a href="http://www.mif.vu.lt/~zemlys/index.php" title="Lietuviška
versija">LT</a> |
        <a href="http://www.mif.vu.lt/~zemlys/index_en.php" title="English
version">EN</a> |
	<a href="http://www.mif.vu.lt/~zemlys/index_fr.php" title="Version
    Française">FR</a>-->

      </div>

      <div class="midHeader">
      <h1 class="headerTitle" lang="la"><?echo $title?></h1>
      <div class="headerSubTitle"><?echo $subtitle?></div>

        <br class="doNotDisplay doNotPrint" />
<!--
        <div class="headerLinks">
          <span class="doNotDisplay">Tools:</span>
          <a href="./index.html">view the previous layout &laquo;</a>
          <span class="doNotDisplay">|</span>
          <a style="cursor: help;" title="Thanks to CSS, this page is already printer friendly!" href="#stylesheets">printer-friendly version &laquo;</a>
        </div>
	-->
      </div>
      
<?
}
?>
    
