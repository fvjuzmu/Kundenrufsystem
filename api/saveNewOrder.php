<?php
/**
 * Save a new order into the database. If the order id (order number) is a negative value, remove the order from the
 * database.
 *
 * TODO Should it be possible to enter an order twice. Imagine the a case where the order ID roles over and begins again
 * TODO by '1'. Maybe instead of throwing an error, whe should accept the id again an only set the 'end' column to NULL.
 */

require "api.php";
require "./../class/DatabaseHandler.php";

$dbh = new \FVJUZ\Kundenrufsystem\DatabaseHandler();
if((int)$_REQUEST['orderID'] < 0)
{
    $order_nr = (int)$_REQUEST['orderID'] * -1;
    $sql = 'DELETE FROM krs.order WHERE nr = '.$order_nr;
}else{
    $sql = 'INSERT INTO krs.order (nr, begin) VALUES ('.$_REQUEST['orderID'].', NOW())';
}

try {
   $dbh->executeStatement($sql);

    $dbh->commitDB();

    echo '{ "success":true}';
}
catch(PDOException $e)
{
    if($e->errorInfo[1] == 1062)
    {
        echo newNotification("Error", "Bestellung " . $_REQUEST['orderID'] . " bereits vorhanden !!!");
        exit();
    }

    echo convertExceptionIntoNotification($e);
}
catch(Exception $e)
{
    echo convertExceptionIntoNotification($e);
}
