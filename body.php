<?  
    include "miscfun.php";
    function body($header,$title,$subtitle,$lev,$menu,$content,$keitdata) {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">


<html>
    <head>
    <meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8" />
    <meta name="author" content="Vaidotas Zemlys" />
    <meta name="generator" content="Vaidotas Zemlys" />

    
    <link rel="stylesheet" type="text/css" href=<?level($lev,"css/prosimii-screen-alt.css")?>    media="screen" title="Main css" />
    <link rel="stylesheet alternative" type="text/css" href=<?level($lev,"css/prosimii-print.css")?>  media="screen" title="Print Preview" />
    <link rel="stylesheet" type="text/css" href=<?level($lev,"css/prosimii-print.css")?>  "css/prosimii-print.css" media="print" />

    <title><?echo $header?></title>
    </head>

    <body>
    
	<div id="header">
  
	<div > 
	    <?php
		include 'header.php';
		include 'menu.php';
		mainheader($title,$subtitle);
		mainmenu($lev);
	    ?>
	    </div>		
		
		<?
		    include $menu;
		   # sidemenu($lev)

		?>
				
	    <div id="main-copy">
		    <?
		    include $content;
		    ?>
	    </div>
	    <?php
		include 'footer.php';
		footer($keitdata);
	    ?>
    </body>
</html>
<?
}
?>
