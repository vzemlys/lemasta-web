<?
//$f = fopen("data.csv","r");

$xml="<lemasta>";

for($i=1;$i<=3;$i++) {
    $dt=file_get_contents("../../R/data$i.csv");
    $ht=file_get_contents("../../R/ftable$i.html");
    $xml=$xml."<scen0$i>";
    $xml=$xml."<tb1>";
    $xml=$xml."<![CDATA[$ht]]>";
    $xml=$xml."</tb1>";
    $xml=$xml."<csv>$dt</csv></scen0$i>";
}

$f1=file_get_contents("../../R/form1.html");

$xml=$xml."<form1><![CDATA[$f1]]></form1></lemasta>";

file_put_contents("initial.xml",$xml);

header('Content-type: text/xml'); 
echo $xml;

?>
