<?php

header("Content-Type: text/javascript");

echo '
var l1, l2, l3, l4, l5, l6;
var suffix, prefix, mediatype, type;

// define colors
';

$colors = json_decode(file_get_contents("colors.json"), true);

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

';
