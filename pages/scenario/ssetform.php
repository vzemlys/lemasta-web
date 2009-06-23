
<form action="../../index.php" enctype="multipart/form-data" method="POST">
<input type="hidden" name="MAX_FILE_SIZE" value="30000" />

<!--<input type="hidden" name="" value="1" />-->

<p><b>Scenarijaus pavadinimas</b><br>
<input type="text" name="scenario" value="scen01"></p>
<p> 
<b>Prognozuoti nuo</b><br>
<select name="year">
<?
for($x=2009;$x>=1995;$x--) {
    echo "<option value=\"$x\">$x</option>\n";
}
?>

</select>
<select name="quarter">
<?
for($x=1;$x<=4;$x++) {
    
    echo "<option value=\"$x\">Q$x</option>\n";
}
?>

</select>
</p>
<p>
<b>Scenarijai egzogeniniams kintamiesiems</b>
<input type="file" name="escen"/></p>

<p><input type="submit" value="Nustatyti"/> </br>

</form>



