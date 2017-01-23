<?php
header('Content-Type: application/json');

require './../config/debug.php';
require './../config/base.conf.php';
require './api.func.php';

require './../class/Configuration.php';

global $config;
$config = \FVJUZ\Kundenrufsystem\Configuration::getInstance();

if(isset($_REQUEST['debug']) && $_REQUEST['debug'] == "true")
{
    echo json_encode($_REQUEST);
    die();
}
