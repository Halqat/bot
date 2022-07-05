<?php
// Firstly, define four constants for the host, database name, username and password:

define('DATABASE_NAME', 'mualynet_botdb');
define('DATABASE_USER', 'mualynet_dbuser');
define('DATABASE_PASS', '63ci]cpV*Gbu');
define('DATABASE_HOST', '23.91.70.10');

// Then, simply include this class into your project like so:

include_once('class.DBPDO.php');

// Then invoke the class:

$DB = new DBPDO();

// my first test
/*
$stdId = 1;
$user = $DB->fetch("SELECT * FROM students WHERE stdId = ?", $stdId);

echo $user['name'];
*/