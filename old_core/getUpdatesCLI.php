<?php
require __DIR__ .'/vendor/autoload.php';

$bot_api_key  = '5478305661:AAGQRXZcIDzGABMlEbSRYVR3abyfxAKMR9k';
$bot_username = 'rumailahbot';

$mysql_credentials = [
   'host'     => '23.91.70.10',
   'port'     => 3306, // optional
   'user'     => 'mualynet_dbuser',
   'password' => '63ci]cpV*Gbu',
   'database' => 'mualynet_botdb',
];

try {
    // Create Telegram API object
    $telegram = new Longman\TelegramBot\Telegram($bot_api_key, $bot_username);

    // Enable MySQL
    $telegram->enableMySql($mysql_credentials);

    // Handle telegram getUpdates request
    $telegram->handleGetUpdates();
} catch (Longman\TelegramBot\Exception\TelegramException $e) {
    // log telegram errors
    echo $e->getMessage();
}