<?php
header('Content-Type: application/json');

require './../config/debug.php';
require './../config/base.conf.php';
require './api.func.php';

require './../class/Configuration.php';

global $config;
$config = \FVJUZ\Kundenrufsystem\Configuration::getInstance();
