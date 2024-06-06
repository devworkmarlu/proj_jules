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
define("GLOBAL_IP", $server2."/proj");
define("GLOBAL_PROJECT_NAME", "AP-IT:  Mobile Application GPS Tracking Attendance for Saint Vincent Annex Junior and Senior High School Students");
?>
