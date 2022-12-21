<?php 
/**
 * Configuration
 */

ini_set("display_errors", "on");

/**
 * Site URL
 * No '/' at the end
 */
define("HOST", "//domain.com");
define("CDNHOST", "//cdn.domain.com");
define("OPENSHIFT_MYSQL_DB_HOST", "localhost");
define("OPENSHIFT_MYSQL_DB_PORT", "3306");
define("OPENSHIFT_MYSQL_DB_USERNAME", "user");
define("OPENSHIFT_MYSQL_DB_PASSWORD", "pass");
define("OPENSHIFT_GEAR_NAME", "db_name");

$host = OPENSHIFT_MYSQL_DB_HOST;
$port = OPENSHIFT_MYSQL_DB_PORT;
$user = OPENSHIFT_MYSQL_DB_USERNAME;
$pass = OPENSHIFT_MYSQL_DB_PASSWORD;
$db = OPENSHIFT_GEAR_NAME;
$dbh = new PDO('mysql:dbname='.$db.';host='.$host.';port='.$port, $user, $pass);
?>
