<?php
require "api.php";
require "./../class/DatabaseHandler.php";

$dbh = new \FVJUZ\Kundenrufsystem\DatabaseHandler();
$sql = 'SELECT * FROM krs.order WHERE order.end IS NULL ORDER BY order.begin ASC limit 12';
try
{
    $sqlResult = $dbh->fetchAllAssoc($sql);
    usort($sqlResult, 'compare_nr');
    echo json_encode($sqlResult);
}
catch(PDOException $e)
{
    echo convertExceptionIntoNotification($e);
}
