<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8"/>
    <title>Essensausgabe</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="js/jquery-ui-1.12.1.custom/jquery-ui.css">
    <script src="js/jquery-3.1.1.min.js" type="application/javascript"></script>
    <script src="js/serverIPAsJS.php" type="application/javascript"></script>
    <script src="js/orderOutput.js" type="application/javascript"></script>
    <script src="js/jquery-ui-1.12.1.custom/jquery-ui.js" type="application/javascript"></script>
</head>
<body>
<div id="divErrorMsg"><h3 id="message">&nbsp;</h3>
    <button type="button" id="btnErrorMsg">OK</button>
</div>
<br/>


<div class="orderOutTest">
    <?php
    for( $x = 0; $x < 12; $x++ ) {
        echo "\t<div class=''>\n"
            . "\t\t<button id='button" . $x . "' class='btnOrder' value='" . $x . "'></button>\n"
            . "\t</div>\n";
    }
    ?>
</div>
<div id="dialog-confirm" title="Bestellung wirklich löschen?">
    <p><span id="confirmMessage"></span></p>
</div>
</body>
</html>
