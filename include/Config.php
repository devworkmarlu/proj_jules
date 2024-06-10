<?php

/**
 * Database config variables
 */

 $server = $_SERVER['SERVER_ADDR'];
 $host_addr= gethostname();
 $server2 = gethostbyname($host_addr);
define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_PASSWORD", "");
define("DB_DATABASE", "proj");
define("GLOBAL_IP", $server2."/proj_jules");
define("GLOBAL_API_URL", "http://192.168.0.253/readers_api/dip_mod_api/web_api_controller.php");
define("GLOBAL_PROJECT_NAME", "Dip-Web-App:  Dipolog City Water District Web-Application.");
?>
