<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8" />
    <title>Essensausgabe</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <script src="js/jquery-3.1.1.min.js" type="application/javascript"></script>
    <script src="js/serverIPAsJS.php" type="application/javascript"></script>
    <script src="js/orderOutput.js" type="application/javascript"></script>
</head>
<body>
<div><h3 id="message" >&nbsp;</h3></div><br><br>


<div class="row">
    <?php
     for($x = 0; $x < 12; $x++)
     {
         echo "\t<div class='element-wrapper'>\n"
        ."\t\t<button id='button".$x."' class='krsButton' value='".$x."'></button>\n"
        ."\t</div>\n";
     }
    ?>
</div>
</body>
</html>
