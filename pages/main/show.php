<?
include_once "include/misc.php";
 


if(!empty($_POST["vars"])) {
    $vars=$_POST["vars"];

    chdir("pages/temp/");
    delfile("*.png");
    delfile("*.R");
    delfile("*.html");

    $R_command="/usr/bin/R";
    $cfn="show.R";

    $rcode="load('../../R/lemasta.RData')\n";
    $rcode=$rcode."getwd()\n";
    $rcode=$rcode."source('../../R/code.R')\n";

    $rcode=$rcode."Sys.setlocale(locale='lt_LT.UTF-8')\n";
    

    $varn="c(\"".$vars[0]."\"";

    for($i=1;$i<sizeof($vars);$i++) {
	$varn=$varn.",\"".$vars[$i]."_sa\"";
    }
    $varn=$varn.")";
    
    $rcode=$rcode."png(file='graph.png')\n";

    $rcode=$rcode."plot.forecast(aldt,ftry,$varn,nmi)\n";

    $rcode=$rcode."dev.off()\n";

    
    $fp=fopen($cfn,"w");

    fputs($fp,$rcode);
    fclose($fp);


    exec("$R_command -q --no-save < $cfn > result 2>&1");


    echo "<p><img src='pages/temp/graph.png'></img>\n";
    echo "</p>";
}
?>
