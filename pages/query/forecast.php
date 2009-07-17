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


    $nr=(int)$_POST["nrows"];
    $pref=$_POST["arname"];
    for($i=1; $i<=$nr; $i++) {
	$nm=$pref.$i;	
	if(!empty($_POST[$nm])) {
	    foreach($_POST[$nm] as $prog) {
	    $str=$str.$prog.";";
	    }	
	    $str=$str."\n";
	}
	else {
	    echo "$nm not found";
	}
    }
    
    $R_command="/usr/bin/R";
    $cfn="trans.R";
    $str="'".$str."'";
    $rcode="getwd()\n";
    $rcode=$rcode."library(plyr)\n";
    $rcode=$rcode."library(xtable)\n";
    $rcode=$rcode."library(reshape)\n";
    $rcode=$rcode."source('../../R/code.R')\n";
    $rcode=$rcode."bb <- ldply(strsplit(strsplit($str,'\\n')[[1]],';'),todf)\n";
    $rcode=$rcode."cc <- cast(bb,variable~row)\n";
    $rcode=$rcode."print(xtable(cc),type='html',include.rows=FALSE,file='tmp.html',html.table.attributes='border=1 id=tmp1 cellpading=2',sanitize.text.function=function(x)x)\n";

    $fp=fopen($cfn,"w");

    fputs($fp,$rcode);
    fclose($fp);


    exec("$R_command -q --no-save < $cfn > result 2>&1");

    $ff=file_get_contents("tmp.html");

    $xml="<lemasta><tmp><![CDATA[$ff]]></tmp></lemasta>";

}
else {
    $xml=file_get_contents("initial.xml");

}

header('Content-type: text/xml'); 
    
echo $xml;
?>

