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

/** دالة إضافة مستخدم و محادثة إلى قاعدة البيانات */
function addUserAndChat( array $userArray, array $chatArray ){
    global $DB;
    $userArray['created_at'] = $userArray['updated_at'] = $chatArray['created_at'] = $chatArray['updated_at'] = date('Y-m-d H:i:s');
    $keys = implode(', ',array_keys($userArray));
    $values = "'" . implode("', '", array_values($userArray)) . "'";
    $sql = "INSERT INTO user ( " .$keys. ") VALUES (" .$values. "); ";
    // $DB->execute($sql);
    
    $keys = implode(', ',array_keys($chatArray));
    $values = "'" . implode("', '", array_values($chatArray)) . "'";
    $sql .= "INSERT INTO chat ( " .$keys. ") VALUES (" .$values. "); ";
    // $DB->execute($sql );
    
    $sql .= "INSERT INTO user_chat ( user_id, chat_id ) VALUES (".$userArray['id'].",".$chatArray['id']."); ";
    $DB->execute($sql);
}

/** دالة إضافة رسالة تيليغرام إلى قاعدة البيانات */
function insertMessage( array $content ){
    global $DB;
    
    $keys = implode(', ',array_keys($content));
    $values = "'" . implode("', '", array_values($content)) . "'";
    $sql = "INSERT INTO message ( " .$keys. ") VALUES (" .$values. ")";
    // $sql = "INSERT INTO message ( id, chat_id ) VALUES (9632,689646315)";

    $DB->execute($sql);
}

// my first test
/*
$stdId = 1;
$user = $DB->fetch("SELECT * FROM students WHERE stdId = ?", $stdId);

echo $user['name'];
*/