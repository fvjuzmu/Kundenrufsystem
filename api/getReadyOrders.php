<?php
require "api.php";
require "./../class/DatabaseHandler.php";

$dbh = new \FVJUZ\Kundenrufsystem\DatabaseHandler();
$sql = 'SELECT * FROM krs.order WHERE order.end IS NULL ORDER BY order.begin ASC';
try
{
    $sqlResult = $dbh->fetchAllAssoc($sql);
    echo json_encode($sqlResult);
}
catch(PDOException $e)
{
    echo convertExceptionIntoNotification($e);
}
