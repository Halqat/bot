<?php

// include_once('db/db.php');
    include_once('Telegram.php');
    include_once('func/stringFunc.php');
    // Set the bot TOKEN
    $bot_token = '5478305661:AAGQRXZcIDzGABMlEbSRYVR3abyfxAKMR9k';
    // Instances the class
    $telegram = new Telegram($bot_token);


$insData = array(
    'id' => 1212,
    'chat_id' => 689646315,
    'photo' =>'my_photo',
    'caption' => 'my_caption',
    'game' => 'myGame',
);

$content = array('chat_id' => 689646315, 'text' => 'from mualy.net//bot//test.php', 'message_auto_delete_time'=> 5);

$telegram->sendMessage( $content );

/*
    getMe
    https://api.telegram.org/bot5478305661:AAGQRXZcIDzGABMlEbSRYVR3abyfxAKMR9k/getMe
    getUpdates
    https://api.telegram.org/bot5478305661:AAGQRXZcIDzGABMlEbSRYVR3abyfxAKMR9k/getUpdates
    setWebhook
    https://api.telegram.org/bot5478305661:AAGQRXZcIDzGABMlEbSRYVR3abyfxAKMR9k/setWebhook?url=https://mualy.net/bot/update.php
    deleteWebhook
    https://api.telegram.org/bot5478305661:AAGQRXZcIDzGABMlEbSRYVR3abyfxAKMR9k/deleteWebhook
*/