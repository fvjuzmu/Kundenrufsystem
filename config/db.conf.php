<?php
//server settings
$configDB[ 'servers' ] = [
    'dev' => array           // config name -> muss in base.conf.php eingetragen werden !
    (
        'host'     => '127.0.0.1',    // DB Host
        'name'     => 'test1',            // DB Name
        'user'     => 'user1',            // DB Benutzer
        'password' => 'pw1'        // DB Passwort
    )
];

//table prefixes for webdat tables
$configDB[ 'assist' ][ 'tablePrefix' ] = "krs_";
