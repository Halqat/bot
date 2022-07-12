<?php
// Firstly, define four constants for the host, database name, username and password:

define('DATABASE_NAME', 'mualynet_botdb');
define('DATABASE_USER', 'mualynet_dbuser');
define('DATABASE_PASS', '63ci]cpV*Gbu');
define('DATABASE_HOST', '23.91.70.10');
define('BOT_ID', 5478305661);

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

/** دالة إضافة سجل في جدول في قاعدة البيانات */
function insertInDB( $table, array $fields ){
    global $DB;

    $keys = implode(', ',array_keys($fields));
    $values = "'" . implode("', '", array_values($fields)) . "'";
    return $DB->execute("INSERT INTO ".$table." ( " .$keys. ") VALUES (" .$values. "); " );
}

/** دالة إضافة رسالة و مستخدم و محادثة إلى قاعدة البيانات */
/* function addMessage( array $data ){
    global $DB;
    $userArray = $data['from'];
    $chatArray = $data['chat'];

    $userArray['created_at'] = $userArray['updated_at'] = $chatArray['created_at'] = $chatArray['updated_at'] = date('Y-m-d H:i:s', $data['date']);
    $keys = implode(', ',array_keys($userArray));
    $values = "'" . implode("', '", array_values($userArray)) . "'";
    $sql = "INSERT INTO user ( " .$keys. ") VALUES (" .$values. "); ";
    $DB->execute($sql);
    
    $keys = implode(', ',array_keys($chatArray));
    $values = "'" . implode("', '", array_values($chatArray)) . "'";
    $sql = "INSERT INTO chat ( " .$keys. ") VALUES (" .$values. "); ";
    $DB->execute($sql);
    
    $sql = "INSERT INTO user_chat ( user_id, chat_id ) VALUES (".$userArray['id'].", ".$chatArray['id']."); ";
    $DB->execute($sql);

    $sql = "INSERT INTO message ( chat_id, sender_chat_id, id, text, date , api_method ) VALUES ( ". $chatArray['id'].", ". $chatArray['id'].", ".$data['message_id'].", '".$data['text']."', '".$userArray['created_at']."', 'استقبال رسالة')";
    $DB->execute($sql);

} */


// my first test
/*
$stdId = 1;
$user = $DB->fetch("SELECT * FROM students WHERE stdId = ?", $stdId);

echo $user['name'];
*/