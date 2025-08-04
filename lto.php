<?php
define('FPDF_FONTPATH','font/');
require('code39.php');

$colors = json_decode(file_get_contents("colors.json"), true);

// Colorscheme
$palette = $_GET['colorscheme'] ?? 'HOT';

$x = (int)10;
$y = (int)10;
$text_h = (float)5.9;

// Tapegeneration
$id = $_GET['tapeGen'] ?? 'U';
if ($id != 'U') {
	$bla = (int)$_GET['tapeGen'];
	$id = 'L'.$bla;
} else {
    $id = 'CU';
}

$colorizeChars = (isset($_GET['colorizeChars']) && $_GET['colorizeChars'] == 1) ? true : false;

$tapeType = $_GET['tapeType'] ?? 'normal';

$fontType = $_GET['fontType'] ?? 'normal';
if ($fontType == 'normal') {
    $font = 'Arial';
    $fontweight = 'B';
} elseif ($fontType == 'ocr') {
    $font = 'OCRA';
    $fontweight = '';
}

// Prefix
//$pre = 'BWN';
$pre = $_GET['prefix'] ?? '';

if ($tapeType === "cln") {
    $pre = "CLN";
    $palette = "BW";
    $id = "CU";
} elseif ($tapeType === "dg") {
    $pre = "DG ";
    $palette = "INV";
}

// Black text, except if we're inverted.
$textColor = ($palette != "INV") ? [0, 0, 0] : [255, 255, 255];

// Start number
//$start = 24;
$start = $_GET['suffix'] ?? 0;

// Number of labels
$num = 24;

// How many labels should we start from the top
$pad = 0;

// Stepping of the label increment
$step = 0;

function lto_label($x, $y, $code, $id, $palette) {
	global $colors;
	global $pdf;
	global $text_h;
        global $font;
        global $fontweight;
        global $textColor;
        global $colorizeChars;

	// Label outer border/marker
	$pdf->SetLineWidth(0.05);
	$pdf->Rect($x, $y, 79, 17, 'D');

        // Barcode/label inner position
	$pdf->SetY($y);
	$pdf->SetX($x+4);

        // Label text size
	$pdf->SetFont($font, $fontweight, 14);
        $pdf->SetTextColor($textColor[0], $textColor[1], $textColor[2]);
        // Label Code
	for ($i = 0; $i < strlen($code); $i++) {
		$char = substr($code, $i, 1);
                if ($colorizeChars === true && !ctype_digit($char) || ctype_digit($char)) {
                    $pdf->SetFillColor($colors[$palette][$char][0], $colors[$palette][$char][1], $colors[$palette][$char][2]);
                    $pdf->Cell(10, $text_h, $char, 1, 0, 'C', 1);
                } else {
                    $pdf->Cell(10, $text_h, $char, 1, 0, 'C', 0);
                }
	}
        // Tape Type marker
	$pdf->SetFont($font, $fontweight, 8);
	$pdf->SetFillColor($colors[$palette][" "][0], $colors[$palette][" "][1], $colors[$palette][" "][2]);
	$pdf->Cell(10, $text_h, $id, 1, 0, 'C', 1);

        // Code39 Barcode
        $pdf->SetFillColor(0, 0, 0);
	$pdf->Code39((float)$x+4.8, (float)$y+$text_h, $code . $id, 1.285, 11.10); //, true, false, true, false);
}

$pdf=new PDF_Code39('P', 'mm', 'A4');
if ($fontType != 'normal') {
    $pdf->AddFont($font, $fontweight, $font.'.php');
}
$pdf->AddPage();
$pdf->SetMargins(10, 10, 10, 10);

if ($num > 24) {
	$num = 24;
}

$pre_len = strlen($pre);

$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(190, 10, 'LTO Barcodes', 0, 0, 'C');

$i = 0;

if ($pad != 0) {
	$i = $pad;
	$num += $pad;
} else {
	$pad = 0;
}


for ($i; $i < $num; $i++) {

	$label = substr($pre . str_pad(($start+$i-$pad+(($i-$pad)*$step)), (6-$pre_len), 0, STR_PAD_LEFT), 0, 6);

	if (!($i%2)) {
		lto_label(20, (($i*10)+30), $label, $id, $palette);
	} else {
		lto_label(120, ((($i-1)*10)+30), $label, $id, $palette);
	}

}

$scheme =  (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'];
$requestUri = $_SERVER['REQUEST_URI'];
$requestUri = "/";
$url = $scheme . '://' . $host . $requestUri;

$pdf->SetAutoPageBreak(False);
$pdf->SetFont('Arial', '', 8);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetX(0);
$pdf->SetY(-15);
$pdf->Cell(190, 10, 'LTO Barcode Generator at ' . $url, 0, 0, 'R', false, $url);

$pdf->Output();
?>
