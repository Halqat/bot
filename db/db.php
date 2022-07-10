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

/** دالة إضافة مستخدم تيليغرام إلى قاعدة البيانات */
function addUser($telegram){
    global $DB;
    $DB->execute("INSERT INTO user (id, is_bot, first_name, last_name, username, language_code, is_premium, added_to_attachment_menu) 
        VALUES (?,?,?,?,?,?,?,?);", 
        array($telegram->ChatID(), $telegram->IsBot(), $telegram->FirstName() , $telegram->LastName(), $telegram->Username(), $telegram->LanguageCode(), $telegram->isPremium(), $telegram->AddedToAttachmentMenu()) );
}

/** دالة إضافة رسالة تيليغرام إلى قاعدة البيانات */
function insertMessage( array $content ){
    echo ' I am inside insertMessage Function 1!';
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