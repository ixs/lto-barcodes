<?php

header("Content-Type: text/javascript");

?>

var l1, l2, l3, l4, l5, l6;
var mediatype, type;

// define colors
<?php

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

?>

function getColor() {
	return document.getElementsByName("colorscheme")[0].value;
}

function getLabelText() {
        let mediatype, count, suffix, prefix, typeType, tapegen;

	prefix = document.getElementsByName("prefix")[0].value;
	count = document.getElementsByName("count")[0].value;
	suffix = document.getElementsByName("suffix")[0].value;
	tapeType = document.querySelector('input[name="tapeType"]:checked').value;
	tapegen = document.getElementsByName("tapeGen")[0].value;

	if (tapeType == "cln") {
		mediatype = "C" + tapegen;
	} else {
		mediatype = "L" + tapegen;
	}

        count = count.padStart(6 - prefix.length - suffix.length, "0");
	let label = (prefix + count + suffix).substr(0, 6) + mediatype;
	console.log("label: " + label);
	return label;

}

function updateText() {
	string = getLabelText();

	l1.firstChild.nodeValue = string.charAt(0);
	l2.firstChild.nodeValue = string.charAt(1);
	l3.firstChild.nodeValue = string.charAt(2);
	l4.firstChild.nodeValue = string.charAt(3);
	l5.firstChild.nodeValue = string.charAt(4);
	l6.firstChild.nodeValue = string.charAt(5);
	mediatype.firstChild.nodeValue = string.substr(6, 8);
}

function updateBarcode() {
	JsBarcode("#barcode", getLabelText(), {
		format: "CODE39",
		displayValue: false,
		height: 45,
		width: 1.34,
		margin: 0
	});
}

function updateTextlabel() {
	updateText();
	updateColors();
	updateBarcode();
}

function updateColors() {
	for (var i = 1; i <= 6; i++) {
		let char = eval("l" + i + ".firstChild.nodeValue");
		if (/^[a-zA-Z]$/.test(char) && !document.querySelector('input[name="colorizeChars"]').checked) {
			eval("l" + i + ".style.backgroundColor = " + getColor() + " [' ']");
		} else {
			eval("l" + i + ".style.backgroundColor = " + getColor() + " [l" + i + ".firstChild.nodeValue]");
		}
	}

	if (getColor() == "BLACK") {
		for (var i = 1; i <= 6; i++) {
			eval("l" + i + ".style.color = \"white\"");
		}
		mediatype.style.color = "white";
		mediatype.style.backgroundColor = BLACK [" "];
	} else {
		for (var i = 1; i <= 6; i++) {
			eval("l" + i + ".style.color = \"black\"");
		}
		mediatype.style.color = "black";
		mediatype.style.backgroundColor = eval(getColor() + " [' ']");
	}
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
	updateBarcode();
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
		document.querySelector('input[name="colorizeChars"]').checked = true;
		document.querySelector('select[name="colorscheme"]').value = 'HOT';
		document.querySelector('select[name="tapeGen"]').value = '1';
	} else if (type == "cln") {
		document.getElementsByName("prefix")[0].value = "CLN";
		document.getElementsByName("prefix")[0].disabled = true;
		document.querySelector('input[name="colorizeChars"]').checked = false;
		document.querySelector('select[name="colorscheme"]').value = 'WHITE';
		document.querySelector('select[name="tapeGen"]').value = 'U';
	} else if (type == "dg") {
		document.getElementsByName("prefix")[0].value = "DG ";
		document.getElementsByName("prefix")[0].disabled = true;
		document.querySelector('input[name="colorizeChars"]').checked = false;
		document.querySelector('select[name="colorscheme"]').value = 'BLACK';
		document.querySelector('select[name="tapeGen"]').value = '1';
	}
	updateTextlabel();
	updateColors();
	updateBarcode();
}

function Init() {
	l1 = document.getElementById("l1");
	l2 = document.getElementById("l2");
	l3 = document.getElementById("l3");
	l4 = document.getElementById("l4");
	l5 = document.getElementById("l5");
	l6 = document.getElementById("l6");
	mediatype = document.getElementById("mediatype");

	updateTextlabel();
	updateColors();
	updateTapeGen();
	updateTapeType();
}
