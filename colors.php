<?php
$colors = json_decode(file_get_contents('colors.json'), true);

// Space, 0-9, A-Z as Dec ASCII Code ranges
$chr_ranges = [[32, 32], [48, 57], [65, 90]];

echo '<!DOCTYPE html><html><head><meta charset="utf-8">';
echo '<style>
        body {
          font-family: sans-serif;
          background: #f9f9f9;
          color: #333;
        }
        table {
          border-collapse: collapse;
          margin: 1em 0;
        }
        td {
          width: 36px;
          height: 36px;
          text-align: center;
          vertical-align: middle;
          font-family: sans-serif;
          font-size: 1.1em;
          font-weight: 700;
          border: 1px solid #ccc;
        }
        h2 {
          font-size: 1.3em;
          font-weight: 700;
          margin-top: 2em;
        }
      </style>'."\n";
echo '</head><body>'."\n";

echo '<h1>LTO Barcode Color Schemes</h1>'."\n";

foreach ($colors as $paletteName => $palette) {
    echo "<h2>Palette: " . htmlspecialchars($paletteName) . "</h2>\n";
    echo "<table><tr>\n";

    $textColor = (strtoupper($paletteName) == 'COOL' || strtoupper($paletteName) == 'INV') ? '#fff' : '#000';

    foreach ($chr_ranges as list($start, $end)) {
        for ($i = $start; $i <= $end; $i++) {
            $char = chr($i);
            $rgb = $palette[$char];
            $bgColor = sprintf("rgb(%d,%d,%d)", $rgb[0], $rgb[1], $rgb[2]);
            echo "<td style=\"background-color: $bgColor; color: $textColor;\">" . htmlspecialchars($char) . "</td>\n";
        }
    }
    echo "</tr></table>\n";
}

echo '</body></html>'."\n";

