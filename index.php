<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="UTF-8">
  <title>LTO Barcode Generator</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="lto.css">
  <script type="text/javascript" src="lto.js.php"></script>
</head>

<body onload="Init()">

  <h1>LTO Barcode Generator</h1>

  <form name="main" action="lto.php" method="get">
    <div class="form-grid">
      <div>
        <label for="prefix">Prefix</label>
        <input name="prefix" type="text" maxlength="6" value="ABC" onkeyup="updateTextlabel()" />
      </div>
      <div>
        <label for="suffix">Suffix</label>
        <input name="suffix" type="text" maxlength="6" value="456" onkeyup="updateTextlabel()" />
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
        <fieldset class="radio-group">
          <legend>Kassetten-Typ</legend>
          <label><input name="tapeType" type="radio" value="normal" onChange="updateTapeType()" checked /> Normale Daten-Kassette</label>
          <label><input name="tapeType" type="radio" value="cln" onChange="updateTapeType()" /> Reinigungskasette</label>
          <label><input name="tapeType" type="radio" value="dg" onChange="updateTapeType()" /> Diagnosekasette</label>
        </fieldset>
      </div>
      <div>
        <label for="colorscheme">Farbschema</label>
        <select name="colorscheme" onChange="updateColors()">
          <option value="HOT">HOT</option>
          <option value="WARM">WARM</option>
          <option value="COOL">COOL</option>
          <option value="BW">BW</option>
          <option value="INV">INV</option>
        </select>
      </div>
      <div>
        <label><input type="checkbox" name="fontType" value="ocr"> OCR-A Font</label><br />
        <label><input type="checkbox" name="colorizeChars" value="1" checked="checked"> Colorize Characters</label>
      </div>
    </div>

    <div class="buttons">
      <input type="submit" value="Generieren">
      <input type="reset" value="Zurücksetzen">
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
      <img src="barcode.png" alt="Barcode" style="max-width: 100%; height: auto;" />
    </div>
  </div>

  <footer>
    A quick <a href="https://github.com/ixs/lto-barcodes/">ixs</a> hack.
  </footer>

</body>
</html>

