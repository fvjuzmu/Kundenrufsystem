<?php
/**
 * "Removes" an order from the database.
 *
 * Actually it will write an DateTime into the end column of the db table, so the order will be not displayed
 */

require "api.php";
require "./../class/DatabaseHandler.php";

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
