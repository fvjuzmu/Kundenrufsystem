<?php
require "api.php";
require "./../class/DatabaseHandler.php";

try
{
    $dbh = new \FVJUZ\Kundenrufsystem\DatabaseHandler();
    $sql = 'SELECT * FROM krs.order WHERE order.end IS NULL ORDER BY order.begin ASC limit 12';

    $sqlResult = $dbh->fetchAllAssoc($sql);
    usort($sqlResult, 'compare_nr');
    echo json_encode($sqlResult);
}
catch(Exception $e)
{
    echo convertExceptionIntoNotification($e);
}
