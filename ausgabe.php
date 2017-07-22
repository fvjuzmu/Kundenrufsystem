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


<div class="row">
    <?php
    for( $x = 0; $x < 12; $x++ ) {
        echo "\t<div class='element-wrapper'>\n"
            . "\t\t<button id='button" . $x . "' class='krsButton' value='" . $x . "'></button>\n"
            . "\t</div>\n";
    }
    ?>
</div>
<div id="dialog-confirm" title="Empty the recycle bin?">
    <p><span class="ui-icon ui-icon-alert" style="float:left; margin:12px 12px 20px 0;"></span><span
                id="confirmMessage"></span></p>
</div>
</body>
</html>
