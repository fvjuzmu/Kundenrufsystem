<html>
<head>
    <title>Bestellnummern Eingabe</title>
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <script src="js/jquery-3.1.1.min.js" type="application/javascript"></script>
    <script src="js/orderOutput.js" type="application/javascript"></script>
</head>
<body>
<div><h3 id="message" >&nbsp;</h3></div><br><br>


<div class="row">
    <?php
     for($x = 0; $x < 12; $x++)
     {
         echo '<div class="element-wrapper">'
        .'<button id="button'.$x.'" class="krsButton" value="'.$x.'"></button>'
        .'</div>';
     }
    ?>
</div>
</body>
</html>