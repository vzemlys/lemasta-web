<?
include_once "../../include/misc.php";

if(!empty($_POST["arname"]) & !empty($_POST["nrows"])) {
    $str="";
    chdir("../temp/");
    delfile("*.xml");
    delfile("*.R");
       
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
	$rcode=$rcode."library(foreach)\n";
        $rcode=$rcode."source('../../R/code.R')\n";
	$rcode=$rcode."load('../../R/lemasta.RData')\n";
	$rcode=$rcode."print('".$_POST["scensend1"]."')\n";
	$rcode=$rcode."print('".$_POST["scensendea1"]."')\n";

	foreach($check as $sno) {
	    
/*	    $str="";
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
 */	    $str=$_POST["scensend".$sno];
	    $rcode=$rcode."bb <- ldply(strsplit(strsplit('$str','&')[[1]],';'),todf)\n";
	    $rcode=$rcode."print(bb)\n";
            $rcode=$rcode."cc <- cast(bb,variable~row)\n";
	    $rcode=$rcode."print(cc)\n";
	    $str=$_POST["scensendea".$sno];
	    $rcode=$rcode."ea <- NULL\n";
	    $rcode=$rcode."if('$str'!=''){\n";
	    $rcode=$rcode."bb <- ldply(strsplit(strsplit('$str','&')[[1]],';'),todf)\n";
	    $rcode=$rcode."print(bb)\n";
            $rcode=$rcode."ea <- cast(bb,variable~row)}\n";
	    $rcode=$rcode."print(ea)\n";


	    $scn=$_POST["scenname".$sno]; 
	    $rcode=$rcode."doforecast(cc,ea,1,$sno,'$scn')\n";

	}
	$fp=fopen($cfn,"w");

	fputs($fp,$rcode);
	fclose($fp);


//	exec("$R_command -q --no-save < $cfn > result 2>&1");
	
	exec("$R_command CMD BATCH $cfn");


	$xml="<lemasta>";
	foreach($check as $i) {
	    $dt=file_get_contents("scen$i.xml");
	    $xml=$xml.$dt;
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

