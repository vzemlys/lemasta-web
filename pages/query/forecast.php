<?
include_once "../../include/misc.php";

if(!empty($_POST["arname"]) & !empty($_POST["nrows"])) {
    $str="";
    chdir("../temp/");
    delfile("*.png");
    delfile("*.R");
    delfile("*.html");
    delfile("*.csv");
    delfile("*.txt");

    
    $nr=(int)$_POST["nrows"]; //Rely on client index.php
    $pref=$_POST["arname"];  //Rely on client index.php
    $spref=$_POST["sarname"]; //Rely on client index.php
    
    if(!empty($_POST["fscensend"])) {

	$check=$_POST["fscensend"]; //Rely on client fillscenario
	$R_command="/usr/bin/R";
        $cfn="trans.R";
	$str="'".$str."'";
        $rcode="getwd()\n";
	$rcode=$rcode."library(plyr)\n";
        $rcode=$rcode."library(xtable)\n";
	$rcode=$rcode."library(reshape)\n";
        $rcode=$rcode."source('../../R/code.R')\n";
	$rcode=$rcode."load('../../R/lemasta.RData')\n";

	foreach($check as $sno) {
	    
	    $str="";
	    for($i=1; $i<=$nr; $i++) {
		 $nm=$spref.$sno.$pref.$i;	
		 if(!empty($_POST[$nm])) {
		     foreach($_POST[$nm] as $prog) {
			 $str=$str.$prog.";";
		     }	
		     $str=$str."\n";
		 }
		 else {
		     header($_SERVER["SERVER_PROTOCOL"]."403 Internal Server Error", true, 403);
		     echo "$nm not found";
		     exit;

		 }
	     }
	     $rcode=$rcode."bb <- ldply(strsplit(strsplit('$str','\\n')[[1]],';'),todf)\n";
	     $rcode=$rcode."cc <- cast(bb,variable~row)\n";
	     $rcode=$rcode."print(cc)\n";
	     $rcode=$rcode."doforecast(cc,$sno)\n";

	}
	$fp=fopen($cfn,"w");

	fputs($fp,$rcode);
	fclose($fp);


	exec("$R_command -q --no-save < $cfn > result 2>&1");
 
	$xml="<lemasta>";
	foreach($check as $i) {
	    $dt=file_get_contents("data$i.csv");
	    $ht=file_get_contents("ftable$i.html");

	    $xml=$xml."<scenario>";
	    $xml=$xml."<number>$i</number>";
	    $scn=$_POST["scenname".$i]; //Rely on client fillscenario
	    $xml=$xml."<name>$scn</name>";
	    $xml=$xml."<tb1>";
	    $xml=$xml."<![CDATA[$ht]]>";
	    $xml=$xml."</tb1>";
	    $xml=$xml."<csv>$dt</csv></scenario>";
	}
	
	$xml=$xml."</lemasta>";

	file_put_contents("result.xml",$xml);

	header('Content-type: text/xml'); 
    }
    else {
	header($_SERVER["SERVER_PROTOCOL"]."403 Internal Server Error", true, 403);
	echo "No scenarios selected";
	exit;

    }
        
}
else {
    $xml=file_get_contents("initial.xml");
    header('Content-type: text/xml'); 

}
    
echo $xml;
?>

