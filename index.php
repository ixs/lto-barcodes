<?php
require('colors.php');

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

echo '<script type="text/javascript">

var l1, l2, l3, l4, l5, l6;
var suffix, prefix, mediatype, type;

// define colors
';

foreach (array_keys($colors) as $color) {
	echo 'var '.$color.' = new Array();'."\n";
	echo $color.' = new Object();'."\n";

	foreach ($colors[$color] as $key => $val) {
		$r = str_pad(dechex($val[0]), 2, '0', STR_PAD_LEFT);
		$g = str_pad(dechex($val[1]), 2, '0', STR_PAD_LEFT);
		$b = str_pad(dechex($val[2]), 2, '0', STR_PAD_LEFT);
		echo $color.'["'.$key.'"] = \'#'.$r.$g.$b.'\';'."\n";
	}
	echo "\n";
}

echo '

function getColor() {
	return document.getElementsByName("colorscheme")[0].value;
}

function updateText(prefix, suffix) {
	// Concat and cut to 6 Upperchars
	string = prefix.value + suffix.value;
	string = string.substr(0, 6);
	string = string.toUpperCase();
	// Pad the string to 6 chars
	for (var i = string.length; i <= 6; i++) {
		string = string + " ";
	}

	l1.firstChild.nodeValue = string.charAt(0);
	l2.firstChild.nodeValue = string.charAt(1);
	l3.firstChild.nodeValue = string.charAt(2);
	l4.firstChild.nodeValue = string.charAt(3);
	l5.firstChild.nodeValue = string.charAt(4);
	l6.firstChild.nodeValue = string.charAt(5);

}

function updateTextlabel() {
	updateText(prefix, suffix);
	updateColors();
}

function updateColors() {
	l1.style.backgroundColor = eval(getColor() + " [l1.firstChild.nodeValue]");
	l2.style.backgroundColor = eval(getColor() + " [l2.firstChild.nodeValue]");
	l3.style.backgroundColor = eval(getColor() + " [l3.firstChild.nodeValue]");
	l4.style.backgroundColor = eval(getColor() + " [l4.firstChild.nodeValue]");
	l5.style.backgroundColor = eval(getColor() + " [l5.firstChild.nodeValue]");
	l6.style.backgroundColor = eval(getColor() + " [l6.firstChild.nodeValue]");
}

function updateTapeGen() {
	if (document.getElementsByName("tapeGen")[0].value != "U") {
		mediatype.firstChild.nodeValue = "L" + document.getElementsByName("tapeGen")[0].value;
		if (type == "cln") {
			document.getElementsByName("prefix")[0].value = "CLN";
			updateTextlabel();
		}
	} else {
		mediatype.firstChild.nodeValue = "L1";
		if (type == "cln") {
			document.getElementsByName("prefix")[0].value = "CLNU";
			updateTextlabel();
		}
		document.getElementsByName("tapeGen")[0].value;
	}
}

function updateTapeType() {
	for (var i = 0; i < document.getElementsByName("tapeType").length; i++) {
		if (document.getElementsByName("tapeType")[i].checked == true) {
			type = document.getElementsByName("tapeType")[i].value;
		}
	}

	if (type == "normal") {
		document.getElementsByName("prefix")[0].value = "ABC";
		document.getElementsByName("prefix")[0].disabled = false;
	} else if (type == "cln") {
		document.getElementsByName("prefix")[0].value = "CLN";
		document.getElementsByName("prefix")[0].disabled = true;
	} else if (type == "dg") {
		document.getElementsByName("prefix")[0].value = "DG ";
		document.getElementsByName("prefix")[0].disabled = true;
	}
	updateTextlabel();

}

function Init() {
	l1 = document.getElementById("l1");
	l2 = document.getElementById("l2");
	l3 = document.getElementById("l3");
	l4 = document.getElementById("l4");
	l5 = document.getElementById("l5");
	l6 = document.getElementById("l6");
	mediatype = document.getElementById("mediatype");

	suffix = document.getElementsByName("suffix")[0];
	prefix = document.getElementsByName("prefix")[0];

	updateTextlabel();
	updateColors();
	updateTapeGen();
	updateTapeType();
}

</script>';

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

<p>A quick <a href="https:/github.com/ixs/lto-barcodes/">ixs</a> hack.</p>
</body>
</html>';

?>
