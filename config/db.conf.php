<?php
//server settings
$configDB[ 'servers' ] = [
    'dev' => array           // config name -> muss in base.conf.php eingetragen werden !
    (
        'host'     => '127.0.0.1',    // DB Host
        'name'     => 'krs',            // DB Name
        'user'     => 'root',            // DB Benutzer
        'password' => ''        // DB Passwort
    )
];

//table prefixes for webdat tables
$configDB[ 'assist' ][ 'tablePrefix' ] = "";
