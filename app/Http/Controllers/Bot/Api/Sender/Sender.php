<?php


namespace App\Http\Controllers\Bot\Api\Sender;
use App\Http\Controllers\Bot\Api\Buttons\Keyboard;
use App\Http\Controllers\Bot\Api\Login\Login;
use App\Http\Controllers\Bot\Api\Messages\Messages;
use Telegram;

class Sender
{
    protected static $_instance;
    protected static $_params;

    private function __construct() {
    }

    public static function getInstance() {
        if (self::$_instance === null) {
            self::$_instance = new self;
        }

        return self::$_instance;
    }

    private function __clone() {
    }

    private function __wakeup() {
    }

    public function startBot($messageText, $userId) {
        if (stristr($messageText, '/start')) {
            if (!Login::getInstance()->checkUser($userId))
                Telegram::sendMessage([
                    'chat_id' => $userId,
                    'text' => Messages::getInstance()->getMessageStartMessage(),
                    'parse_mode' => 'HTML',
                ]);
        }
    }
}
