<?
//$f = fopen("data.csv","r");

$f1=file_get_contents("../../R/form1.html");

$xml="<lemasta>";
$scennames=array("Scenarijus 1","Scenarijus 2","Scenarijus 3");
for($i=1;$i<=3;$i++) {
    $dt=file_get_contents("../../R/data$i.csv");
    $ht=file_get_contents("../../R/ftable$i.html");
    $fm=file_get_contents("../../R/form$i.html");

    $xml=$xml."<scenario>";
    $xml=$xml."<number>$i</number>";
    $scn=$scennames[$i-1];
    $xml=$xml."<name>$scn</name>";
    $xml=$xml."<tb1>";
    $xml=$xml."<![CDATA[$ht]]>";
    $xml=$xml."</tb1>";
    $xml=$xml."<form><![CDATA[$fm]]></form>";
    $xml=$xml."<csv>$dt</csv></scenario>";
}


$xml=$xml."</lemasta>";

file_put_contents("initial.xml",$xml);

header('Content-type: text/xml'); 
echo $xml;

?>
