<?
include_once "include/misc.php";
?>
<form action="index.php" method="POST">
<p>Pasirinkite kintamuosius vaizdavimui</br>
</p>

<select name="vars[]" multiple="multiple">

<?

foreach($nametb as $en => $value) {
	if(in_array($en,$_POST["vars"]))	{
	    echo "<option selected value=\"$en\">".$nametb[$en]."</option>";
	}
	else {
	    echo "<option value=\"$en\">".$nametb[$en]."</option>";

	}
    }
?>
</select>

<p><input type="submit" value="Rodyti"/>

<select name="otype">
<option value="graph">Grafiką</option>
<option value="table">Lentelę</option>
</select>
</p>
</form>

