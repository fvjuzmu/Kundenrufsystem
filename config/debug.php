<?php
$debug = 0;
global $debug;

if( array_key_exists('dbg', $_REQUEST) )
{
    $debug = 1;
    ini_set('xdebug.collect_vars', 'on');
    ini_set('xdebug.collect_params', '4');
    ini_set('xdebug.dump_globals', 'on');
    ini_set('xdebug.dump.SERVER', 'REQUEST_URI');
    ini_set('xdebug.show_local_vars', 'on');
}
