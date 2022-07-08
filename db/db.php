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

function addUser($telegram){
    global $DB;
    $DB->execute("INSERT INTO user (id, is_bot, first_name, last_name, username, language_code, is_premium, added_to_attachment_menu) 
        VALUES (?,?,?,?,?,?,?,?);", 
        array($telegram->ChatID(), $telegram->IsBot(), $telegram->FirstName() , $telegram->LastName(), $telegram->Username(), $telegram->LanguageCode(), $telegram->isPremium(), $telegram->AddedToAttachmentMenu()) );
}

// my first test
/*
$stdId = 1;
$user = $DB->fetch("SELECT * FROM students WHERE stdId = ?", $stdId);

echo $user['name'];
*/