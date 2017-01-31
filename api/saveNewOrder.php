<?php
require "api.php";
require "./../class/DatabaseHandler.php";

if($_REQUEST['debug'] == "true")
{
    echo json_encode($_REQUEST);
    die();
}

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
