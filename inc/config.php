<?php 
/**
 * Configuration
 */

ini_set("display_errors", "on");

/**
 * Site URL
 * No '/' at the end
 */
define("HOST", "//search.axads.co");
define("CDNHOST", "//cdn.search.axads.co");
define("OPENSHIFT_MYSQL_DB_HOST", "localhost");
define("OPENSHIFT_MYSQL_DB_PORT", "3306");
define("OPENSHIFT_MYSQL_DB_USERNAME", "axworx05_ax");
define("OPENSHIFT_MYSQL_DB_PASSWORD", "36g5a12A%B2");
define("OPENSHIFT_GEAR_NAME", "axworx05_search");

$host = OPENSHIFT_MYSQL_DB_HOST;
$port = OPENSHIFT_MYSQL_DB_PORT;
$user = OPENSHIFT_MYSQL_DB_USERNAME;
$pass = OPENSHIFT_MYSQL_DB_PASSWORD;
$db = OPENSHIFT_GEAR_NAME;
$dbh = new PDO('mysql:dbname='.$db.';host='.$host.';port='.$port, $user, $pass);
?>
