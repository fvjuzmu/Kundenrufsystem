<?php
require "api.php";
require "./../class/DatabaseHandler.php";

if ($_REQUEST['debug'] == "true") {
    echo json_encode($_REQUEST);
    die();
}

try {
    $dbh = new \FVJUZ\Kundenrufsystem\DatabaseHandler();
    $sql = 'UPDATE krs.order SET end = NOW() WHERE nr = ' . $_REQUEST['orderID'];

    $dbh->executeStatement($sql);

    $dbh->commitDB();

    echo '{ "success":true}';
} catch (Exception $e) {
    if ($e->errorInfo[1] == 1062) {
        echo newNotification("Error", "Bestellung " . $_REQUEST['orderID'] . " bereits vorhanden !!!");
        exit();
    }

    echo convertExceptionIntoNotification($e);
} catch (Exception $e) {
    echo convertExceptionIntoNotification($e);
}
