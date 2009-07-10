<?
//$f = fopen("data.csv","r");
$ff=file_get_contents("../../R/data.csv");
$fh=file_get_contents("../../R/ftable.html");
$xml="<lemasta><tb1><![CDATA[$fh]]></tb1><csv>$ff</csv></lemasta>";
header('Content-type: text/xml'); 
echo $xml;
?>
