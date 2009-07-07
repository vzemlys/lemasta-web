<?
function mainheader($title,$subtitle) {
?>
   <div class="superHeader">
    </div>

    <div class="midHeader">
	<h1 class="headerTitle" lang="la"><?echo $title?></h1>
    <div class="headerSubTitle"><?echo $subtitle?></div>

        <br class="doNotDisplay doNotPrint" />
    </div>
      
<?
}

function footer($keitdata) {
?>
    
<!--
<div id="footer">
      <span class="doNotPrint">
      Puslapio dizainas Prosimii  
      </span>
      <br>
      <strong>Atnaujinta &raquo;</strong> <?echo $keitdata?>
    </div>
-->
<?
}

function mainmenu($lev) {    
?>
 <div class="subHeader">
        <span class="doNotDisplay">Navigacija:</span>
        <a href=<?level($lev,"index.php")?>>Prognozės</a> |
        <a href=<?level($lev,"pages/scenario/scenario.php")?>>Scenarijai</a> |
      </div>

<?
}

function level($lev,$href) {
	echo "\"".$lev.$href."\"";		
    }

function head($header,$lev) {
?>
 <head>
    <meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8" />
    <meta name="author" content="Vaidotas Zemlys" />
    <meta name="generator" content="Vaidotas Zemlys" />

    
    <link rel="stylesheet" type="text/css" href=<?level($lev,"css/prosimii-screen-alt.css")?>    media="screen" title="Main css" />
    <link rel="stylesheet alternative" type="text/css" href=<?level($lev,"css/prosimii-print.css")?>  media="screen" title="Print Preview" />
    <link rel="stylesheet" type="text/css" href=<?level($lev,"css/prosimii-print.css")?>  "css/prosimii-print.css" media="print" />

    <title><?echo $header?></title>
    </head>
<?
}
?>

