<?php

declare(strict_types = 1);

include 'basics.php';

use GuzzleHttp\Exception\ClientException;
use unreal4u\TelegramAPI\Telegram\Methods\SendMessage;
use unreal4u\TelegramAPI\Telegram\Types\KeyboardButton;
use unreal4u\TelegramAPI\Telegram\Types\ReplyKeyboardMarkup;
use unreal4u\TelegramAPI\TgLog;

$loop = \React\EventLoop\Factory::create();
$handler = new \unreal4u\TelegramAPI\HttpClientRequestHandler($loop);
$tgLog = new TgLog(BOT_TOKEN, $handler);

$sendMessage = new SendMessage();
$sendMessage->chat_id = A_USER_CHAT_ID;
$sendMessage->text = 'Have you read this message?';
$sendMessage->reply_markup = new ReplyKeyboardMarkup();
$sendMessage->reply_markup->one_time_keyboard = true;

// Create the first button
$keyboardButton = new KeyboardButton();
$keyboardButton->text = 'Yes';
$sendMessage->reply_markup->keyboard[0][] = $keyboardButton;
// Create the second button
$keyboardButton = new KeyboardButton();
$keyboardButton->text = 'No';
$sendMessage->reply_markup->keyboard[0][] = $keyboardButton;
// Create the second button
$keyboardButton = new KeyboardButton();
$keyboardButton->text = 'Maybe';
$sendMessage->reply_markup->keyboard[1][] = $keyboardButton;
// Create the second button
$keyboardButton = new KeyboardButton();
$keyboardButton->text = 'It\'s classified';
$sendMessage->reply_markup->keyboard[2][] = $keyboardButton;

$promise = $tgLog->performApiRequest($sendMessage);

$promise->then(
    function ($response) {
        echo '<pre>';
        var_dump($response);
        echo '</pre>';
    },
    function (\Exception $exception) {
        // Onoes, an exception occurred...
        echo 'Exception ' . get_class($exception) . ' caught, message: ' . $exception->getMessage();
    }
);

$loop->run();
