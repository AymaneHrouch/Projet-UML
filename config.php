<?php
/* Database credentials */
// define('DB_SERVER', 'sql4.freemysqlhosting.net');
// define('DB_USERNAME', 'sql4458139');
// define('DB_PASSWORD', 'p3qvIY9N98');
// define('DB_NAME', 'sql4458139');


define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'projet_uml');
 
/* Attempt to connect to MySQL database */
try{
    $pdo = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e){
    die("ERROR: Could not connect. " . $e->getMessage());
}
?>