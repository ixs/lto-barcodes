<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="UTF-8">
  <title>LTO Barcode Generator</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="lto.css">
  <script type="text/javascript" src="lto.js.php" defer></script>
  <script type="text/javascript" src="JsBarcode.code39.min.js"></script>
</head>

<body onload="Init()">

  <h1>LTO Barcode Generator</h1>

  <form name="main" action="lto.php" method="get">
    <div class="form-grid">
      <div>
        <label for="prefix">Prefix (optional)</label>
        <input name="prefix" type="text" maxlength="6" value="ABC" onkeyup="updateTextlabel()" />
      </div>
      <div>
        <label for="count">Z&auml;hler</label>
        <input name="count" type="text" maxlength="6" value="34" onkeyup="updateTextlabel()" />
      </div>
      <div>
        <label for="suffix">Suffix (optional)</label>
        <input name="suffix" type="text" maxlength="6" value="T" onkeyup="updateTextlabel()" />
      </div>

      <div>
        <fieldset class="radio-group">
          <legend>Kassetten-Typ</legend>
          <label><input name="tapeType" type="radio" value="normal" onChange="updateTapeType()" checked /> Normale Daten-Kassette</label>
          <label><input name="tapeType" type="radio" value="cln" onChange="updateTapeType()" /> Reinigungskasette</label>
          <label><input name="tapeType" type="radio" value="dg" onChange="updateTapeType()" /> Diagnosekasette</label>
        </fieldset>
      </div>

      <div>
        <label for="colorscheme">Farbschema (<a href="colors.php">Farbtafel</a>)</label>
        <select name="colorscheme" onChange="updateColors()">
<?php
foreach (json_decode(file_get_contents('colors.json'), true) as $colorScheme => $colors) {
    echo "          <option value=\"$colorScheme\">$colorScheme</option>\n";
}
?>
        </select>
      </div>

      <div>
        <label for="tapeGen">LTO Typ</label>
        <select name="tapeGen" onChange="updateTapeGen()">
          <option value="1" selected>LTO 1</option>
          <option value="2">LTO 2</option>
          <option value="3">LTO 3</option>
          <option value="4">LTO 4</option>
          <option value="5">LTO 5</option>
          <option value="6">LTO 6</option>
          <option value="7">LTO 7</option>
          <option value="8">LTO 8</option>
          <option value="9">LTO 9</option>
          <option value="U">Universal</option>
        </select>
      </div>

      <div>
        <label><input type="checkbox" name="fontType" value="ocr"> OCR-A Font</label><br />
        <label><input type="checkbox" name="colorizeChars" value="1" checked="checked" onChange="updateColors()"> Colorize Characters</label>
      </div>
    </div>

    <div class="buttons">
      <input type="reset" onClick="setTimeout(updateTextlabel, 0)" value="Zur&uuml;cksetzen">
      <input type="submit" value="Generieren">
    </div>
  </form>

  <div class="label-container">
    <div class="label-row">
      <div id="l1" class="letter">A</div>
      <div id="l2" class="letter">B</div>
      <div id="l3" class="letter">C</div>
      <div id="l4" class="letter">4</div>
      <div id="l5" class="letter">5</div>
      <div id="l6" class="letter">6</div>
      <div id="mediatype" class="letter mediatype">L1</div>
    </div>
    <div class="barcode">
      <img src="barcode.png" alt="Barcode" id="barcode" style="max-width: 100%; height: auto;" />
    </div>
  </div>

  <section class="description">
    <h2>Funktionsbeschreibung</h2>
    <p>
      Diese Webanwendung generiert <strong>Barcode-Etiketten f&uuml;r LTO-Datentr&auml;ger</strong> gem&auml;&szlig; den Spezifikationen g&auml;ngiger LTO-Generationen (LTO-1 bis LTO-9 sowie Universal).
      Über das Formular k&ouml;nnen <strong>Pr&auml;fix</strong> und <strong>Suffix</strong>, der <strong>LTO-Typ</strong>, der <strong>Kassetten-Typ</strong> (Daten-, Reinigungs- oder Diagnosekassette)
      sowie das <strong>Farbschema</strong> konfiguriert werden. Zus&auml;tzlich k&ouml;nnen die Verwendung einer <strong>OCR-A-Schriftart</strong> und
      <strong>farbige Zeichen</strong> aktiviert werden.
    </p>
    <p>
      Nach dem Absenden wird ein <strong>PDF-Dokument mit 24 fortlaufenden Etiketten</strong> erzeugt, da&szlig; sich zum Ausdrucken und ausschneiden eignet.
    </p>
  </section>

  <footer>
    <a href="https://github.com/ixs/lto-barcodes/">A quick hack, &copy; 2007-2025 Andreas Thienemann</a>.
  </footer>

</body>
</html>
