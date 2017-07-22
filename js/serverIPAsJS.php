/**
 * Gets the servers IP from php and displays it as javascript variable assignment, so the javascript always has the
 * correct IP to the server.
 * This php file should be included just like any other .js (javascript file) inside the html file that will do js api calls
 */
$(document).ready(function(){
<?php
echo "server = '".$_SERVER['SERVER_ADDR'].":".$_SERVER['SERVER_PORT']."'\n";
?>
});
