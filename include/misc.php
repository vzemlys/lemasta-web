<?
include "variables.php";

function delfile($str){
	if(is_array(glob($str))){
		foreach(glob($str) as $fn) {
			unlink($fn);
		}
	}
} 

?>
