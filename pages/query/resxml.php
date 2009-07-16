<?
//$f = fopen("data.csv","r");
$ff=file_get_contents("../../R/data.csv");
$fh=file_get_contents("../../R/ftable.html");
$f1=file_get_contents("../../R/form1.html");

$xml="<lemasta><tb1><![CDATA[$fh]]></tb1><csv>$ff</csv><form1><![CDATA[$f1]]></form1></lemasta>";
header('Content-type: text/xml'); 
echo $xml;
?>
