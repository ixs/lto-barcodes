<?php
$colors = json_decode(file_get_contents('colors.json'), true);

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
      </style>';
echo '</head><body>';

echo '<h1>LTO Barcode Color Schemes</h1>';

foreach ($colors as $paletteName => $palette) {
    echo "<h2>Palette: " . htmlspecialchars($paletteName) . "</h2>";
    echo "<table><tr>";

    $textColor = (strtoupper($paletteName) == 'COOL' || strtoupper($paletteName) == 'INV') ? '#fff' : '#000';

    foreach ($palette as $char => $rgb) {
        $bgColor = sprintf("rgb(%d,%d,%d)", $rgb[0], $rgb[1], $rgb[2]);
        echo "<td style=\"background-color: $bgColor; color: $textColor;\">" . htmlspecialchars($char) . "</td>";
    }

    echo "</tr></table>";
}

echo '</body></html>';

