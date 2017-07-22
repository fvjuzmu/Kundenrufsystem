<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8"/>
    <title>Bestellnummern Eingabe</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <script src="js/jquery-3.1.1.min.js" type="application/javascript"></script>
    <script src="js/serverIPAsJS.php" type="application/javascript"></script>
    <script src="js/orderInput.js" type="application/javascript"></script>
</head>
<body id="bodyEingabe">
<div><h3 id="message">&nbsp;</h3></div>
<br><br>
<input id="orderID" type="number" min="1" max="5" step="1" autofocus="autofocus"/>
<!--input type="text" id="orderID" maxlength="4"-->
<h3>Letzte Hinzugef&uuml;gte Bestellungen:</h3>
<ul id="orderList"></ul>
</body>
</html>
