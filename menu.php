<?php
     function mainmenu($lev) {    
?>
 <div class="subHeader">
        <span class="doNotDisplay">Navigacija:</span>
        <a href=<?level($lev,"index.php")?>>Prognozės</a> |
        <a href=<?level($lev,"pages/scenario/scenario.php")?>>Scenarijai</a> |
      </div>

<?
}
?>

