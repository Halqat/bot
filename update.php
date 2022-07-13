<?php
/**
 * Telegram Bot example.
 *
 * @author Gabriele Grillo <gabry.grillo@alice.it>
 */
include 'Telegram.php';
include_once('db/db.php');
include_once('func/stringFunc.php');

// Set the bot TOKEN
$bot_token = '5478305661:AAGQRXZcIDzGABMlEbSRYVR3abyfxAKMR9k';
$bot_id = 5478305661;
// Instances the class
$telegram = new Telegram($bot_token);

// بعض المتغيرات
$result = $telegram->getData();
/*$text = $result["message"] ["text"];
$chat_id = $result["message"] ["chat"]["id"]; */
// addUser($telegram);
// addMessage( $telegram->getData()['message'] );
addUserAndChat( $telegram->FromUser(), $telegram->Chat() );

// Take text and chat_id from the message
$text = $telegram->Text();
$chat_id = $telegram->ChatID();

// إذا جاء رد بالضغط على زر رسالة CallBack
$callback_query = $telegram->Callback_Query();
if (!empty($callback_query)) {
    $reply = 'Callback value '.$telegram->Callback_Data();
    $content = ['chat_id' => $telegram->Callback_ChatID(), 'text' => $reply];
    // $telegram->sendMessage($content);

    $content = ['callback_query_id' => $telegram->Callback_ID(), 'text' => $reply, 'show_alert' => true];
    // $content = ['callback_query_id' => $telegram->Callback_ID(), 'text' => json_encode( $telegram->TelegramUpdate() ), 'show_alert' => true];
    $telegram->answerCallbackQuery($content);
    insertInDB('callback_query', $telegram->CallbackQuery() );
    insertInDB('telegram_update',$telegram->TelegramUpdate() );
}

//Test Inline
$data = $telegram->getData();
if (!empty($data['inline_query'])) {
    $query = $data['inline_query']['query'];
    // GIF Examples
    if (strpos('testText', $query) !== false) {
        $results = json_encode([['type' => 'gif', 'id'=> '1', 'gif_url' => 'http://i1260.photobucket.com/albums/ii571/LMFAOSPEAKS/LMFAO/113481459.gif', 'thumb_url'=>'http://i1260.photobucket.com/albums/ii571/LMFAOSPEAKS/LMFAO/113481459.gif']]);
        $content = ['inline_query_id' => $data['inline_query']['id'], 'results' => $results];
        $reply = $telegram->answerInlineQuery($content);
    }

    if (strpos('dance', $query) !== false) {
        $results = json_encode([['type' => 'gif', 'id'=> '1', 'gif_url' => 'https://media.tenor.co/images/cbbfdd7ff679e2ae442024b5cfed229c/tenor.gif', 'thumb_url'=>'https://media.tenor.co/images/cbbfdd7ff679e2ae442024b5cfed229c/tenor.gif']]);
        $content = ['inline_query_id' => $data['inline_query']['id'], 'results' => $results];
        $reply = $telegram->answerInlineQuery($content);
    }
}

// إذا أرسل المستخدم أي رسالة
if(!empty( $data['message'] )){
    $message = $data['message'];
    $record = ['chat_id'=>$chat_id, 'user_id'=>$bot_id, 'sender_chat_id'=>$chat_id, 'id'=>$telegram->MessageID(), 'date'=>date("Y-m-d H:i:s", $telegram->Date())];

    // إذا أرسل المستخدم رقم جواله
    if(!empty($message['contact'])){
        $record['contact'] = $message['contact']['phone_number'];
        $record['api_method'] ='📱 رقم جوال';
    }

    // إذا أرسل المستخدم موقع جغرافي
    if(!empty($message['location'])){
        // $record['location'] = "latitude:". $message['location']['latitude'].", longitude:". $message['location']['longitude']  ;
        $record['location'] = json_encode( $message['location']);
        $record['api_method'] ='📍 موقع جغرافي';
    }
    
    // إذا أرسل المستخدم صورة
    if(!empty($message['photo'])){
        $record['photo'] = json_encode( $message['photo'] );
        $record['api_method'] ='🖼 صورة';
    }

    // إذا أرسل المستخدم مستند أو ملف
    if(!empty($message['document'])){
        $record['document'] = json_encode( $message['document'] );
        $record['api_method'] ='📄 مستند';
    }

    // إذا أرسل المستخدم فيديو
    elseif(!empty($message['video'])){ $record['video']=json_encode($message['video']); $record['api_method']='🎞 فيديو'; }
    // إذا أرسل المستخدم مذكرة فيديو
    elseif(!empty($message['video_note'])){$record['video_note']=json_encode($message['video_note']); $record['api_method']='🎥 مذكرة فيديو';}
    // إذا أرسل المستخدم صوت
    elseif(!empty($message['voice'])){ $record['voice'] = json_encode( $message['voice'] ); $record['api_method'] ='🔊 صوت'; }
    elseif(!empty($message['audio'])){ $record['audio'] = json_encode( $message['audio'] ); $record['api_method'] ='🎵 مقطع صوتي'; }
    // إذا أرسل المستخدم ملصق
    elseif(!empty($message['sticker'])){ $record['sticker']=json_encode($message['sticker']); $record['api_method'] ='😀 ملصق'; }
    elseif(!empty($message['animation'])){ $record['animation']=json_encode($message['animation']); $record['api_method'] ='💢 صورة متحركة'; }
    elseif(!empty($message['game'])){ $record['game']=json_encode($message['game']); $record['api_method'] ='🎮 لعبة'; }
    elseif(!empty($message['venue'])){ $record['venue']=json_encode($message['venue']); $record['api_method'] ='venue'; }
    elseif(!empty($message['dice'])){ $record['dice']=json_encode($message['dice']); $record['api_method'] ='dice'; }
    elseif(!empty($message['poll'])){ $record['poll']=json_encode($message['poll']); $record['api_method'] ='🗳 استفتاء'; }

    // إذا أحتوى الملف أو الصورة أو الصوت على عنوان
    if(!empty($message['caption'])) $record['caption'] = $message['caption'];
    if(!empty($message['caption_entities'])) $record['caption_entities']=json_encode( $message['caption_entities']);
    if(!empty($message['entities'])) $record['entities']=json_encode( $message['entities']);
    if(!empty($message['sender_chat'])) $record['sender_chat_id'] = $message['sender_chat']['id'];
    if(!empty($message['forward_from'])) $record['forward_from'] = $message['forward_from']['id'];
    if(!empty($message['forward_from_chat'])) $record['forward_from_chat'] = $message['forward_from_chat']['chat']['id'];
    if(!empty($message['forward_date'])) $record['forward_date'] = date("Y-m-d H:i:s", $message['forward_date']);
    if(!empty($message['reply_to_message'])) {$record['reply_to_chat'] = $message['reply_to_message']; $record['reply_to_message']['from']['id'] = $message['reply_to_message']['message_id'];}
    if(!empty($message['edit_date'])) $record['edit_date'] = date("Y-m-d H:i:s", $message['edit_date']);

    // إذا أرسل المستخدم رسالة نصية
    if(!empty($message['text'])){ $record['text'] = $text; $record['api_method'] ='✉ رسالة نصية'; }


    // تخزين الرسالة مهما كان نوعها في قاعدة البيانات
    insertInDB( 'message', $record );
    insertInDB( 'telegram_update', [ 'id'=>$data['update_id'], 'chat_id'=>$chat_id, 'message_id'=>$telegram->MessageID()] );
}

// إذا الرسالة جائت بأمر أو نص عادي
if (!is_null($text) && !is_null($chat_id)) {

    if ($text == '/test') {
        if ($telegram->messageFromGroup()) {
            $reply = 'Chat Group';
        } else {
            $reply = 'محادثة غير جماعية - مفردة';
        }
        // Create option for the custom keyboard. Array of array string
        $option = [['A', 'B'], ['C', 'D']];
        // Get the keyboard
        $keyb = $telegram->buildKeyBoard($option);
        $content = ['chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => $reply];
        $telegram->sendMessage($content);
    } elseif ($text == '/git') {
        $reply = 'Check me on GitHub: https://github.com/Eleirbag89/TelegramBotPHP';
        // Build the reply array
        $content = ['chat_id' => $chat_id, 'text' => $reply];
        $telegram->sendMessage($content);
    } elseif ($text == '/img') {
        // Load a local file to upload. If is already on Telegram's Servers just pass the resource id
        $img = curl_file_create('test.png', 'image/png');
        $content = ['chat_id' => $chat_id, 'photo' => $img];
        $telegram->sendPhoto($content);
        //Download the file just sended
        $file_id = $message['photo'][0]['file_id'];
        $file = $telegram->getFile($file_id);
        $telegram->downloadFile($file['result']['file_path'], './test_download.png');
    } elseif ($text == '/where') {
        // Send the Catania's coordinate
        $content = ['chat_id' => $chat_id, 'latitude' => '37.5', 'longitude' => '15.1'];
        $telegram->sendLocation($content);
    } elseif ($text == '/inlinekeyboard') {
        // Shows the Inline Keyboard and Trigger a callback on a button press
        $option = [
            [
                $telegram->buildInlineKeyBoardButton('Callback 1', $url = '', $callback_data = '1'),
                $telegram->buildInlineKeyBoardButton('Callback 2', $url = '', $callback_data = '2'),
            ],
        ];

        $keyb = $telegram->buildInlineKeyBoard($option);
        $content = ['chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => 'This is an InlineKeyboard Test with Callbacks'];
        $telegram->sendMessage($content);
    } 
    elseif ( startsWith(  $text ,'/std')) {
        // my first test
        $stdId = substr($text, 4);
        $user = $DB->fetch("SELECT * FROM students WHERE stdId = ?", $stdId);
        $content = ['chat_id' => $chat_id, 'text' => $user['name']];
        $telegram->sendMessage( $content );
    }
}
