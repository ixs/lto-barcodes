<?php

// Load colors from external json
$colors = json_decode(file_get_contents("colors.json"), true);

echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
    "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="de">

<head>
<title>LTO Barcode Generator</title>

<style type="text/css">
td.letter {
	border: 1px black solid;
	width: 27px;
    height: 27px;
	font-family: sans-serif;
    font-size: 16px;
    font-weight: bold;
	text-align: center;
    margin: 0px;
	padding: 0px;
}

td.mediatype {
	border: 1px black solid;
	width: 27px;
    height: 16px;
	font-family: sans-serif;
    font-size: 6px;
    font-weight: bold;
	text-align: center;
}

table.label {
	border: 1px black solid;
	table-layout: fixed;
	border-collapse: collapse;
	height: 47px;
	width: 223px;
	padding: 0px;
}

td.barcode {
	height: 30px;
	width: 223px;
	border: 0px;
    margin: 0px;
	padding: 0px;
}

</style>
';

echo '<script type="text/javascript" src="lto.js.php"></script>
';

echo '</head>

<body onload="Init()">

<h1>LTO Barcode Generator</h1>

<form name="main" action="lto.php" method="get">
<table border=1>
 <tr>
  <td><label for="prefix">Prefix</label> <input name="prefix" type="text" size="20" maxlength="6" value="ABC" onkeyup="updateTextlabel()" /></td>
  <td colspan="2"><label for="suffix">Suffix</label> <input name="suffix" type="text" size="20" maxlength="6" value="456" onkeyup="updateTextlabel()" /></td>
 </tr>
 <tr>
  <td><input name="tapeType" type="radio" value="normal" onChange="updateTapeType()"  checked="checked" />Normale Archivkasette<br />
      <input name="tapeType" type="radio" value="cln" onChange="updateTapeType()" />Reinigungskasette<br />
      <input name="tapeType" type="radio" value="dg" onChange="updateTapeType()" />Diagnosekasette</td>
  <td>LTO Typ:<br />
    <select name="tapeGen" size=1 onChange="updateTapeGen()">
	 <option value="1" selected="selected">LTO 1</option>
	 <option value="2">LTO 2</option>
	 <option value="3">LTO 3</option>
	 <option value="4">LTO 4</option>
	 <option value="5">LTO 5</option>
	 <option value="6">LTO 6</option>
	 <option value="7">LTO 7</option>
	 <option value="8">LTO 8</option>
	 <option value="9">LTO 9</option>
	 <option value="U">Universal</option>
    </select></td>
  <td>Farbschema:<br />
    <select name="colorscheme" onChange="updateColors()" size=1>
';
foreach (array_keys($colors) as $color) {
	echo '<option name="'.$color.'">'.$color.'</option>
';
}

echo '</select></td>
 </tr>
 <tr>
  <td><input type="submit"></td>
  <td colspan="2"><input type="reset"></td>
 </tr>
</table>
<input type="hidden" name="colorizeChars" value="1">
</form>

<table class="label">
 <tr>
  <td class="invis"></td>
  <td id="l1" class="letter">A</td>
  <td id="l2" class="letter">B</td>
  <td id="l3" class="letter">C</td>
  <td id="l4" class="letter">4</td>
  <td id="l5" class="letter">5</td>
  <td id="l6" class="letter">6</td>
  <td id="mediatype" class="mediatype">L1</td>
  <td class="invis"></td>
 </tr>
 <tr>
  <td colspan="9" class="barcode"><img src="barcode.png" style="display: block; margin: 0px auto 0px auto;"></td>
 </tr>
</table>

<p>A quick <a href="https://github.com/ixs/lto-barcodes/">ixs</a> hack.</p>
</body>
</html>';

?>
