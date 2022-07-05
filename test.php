<?php

include_once('db/db.php');
include_once('func/stringFunc.php');

$text = '/std5';
$stdId = substr($text,4);
$user = $DB->fetch("SELECT * FROM students WHERE stdId = ?", $stdId);

echo $user['name'];
echo '</br>';
echo startsWith(  $text ,'/std');
echo '</br>';
echo substr($text,4);