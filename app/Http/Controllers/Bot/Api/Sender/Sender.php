<?php


namespace App\Http\Controllers\Bot\Api\Sender;
use App\Http\Controllers\Bot\Api\Buttons\KeyboardBot;
use App\Http\Controllers\Bot\Api\Login\Login;
use App\Http\Controllers\Bot\Api\Messages\Messages;
use App\Models\ServerModel;
//use Telegram\Bot\Api;
use Telegram;
use Telegram\Bot\Keyboard\Keyboard;

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

    public function startBot($messageText, $userName, $userId) {
        if (stristr($messageText, '/start')) {

            if (Login::getInstance()->checkUser($userId)) {
                $statusUser = Login::getInstance()->getUserField($userId, 'status');
                if ($statusUser[0]->status)
                    Telegram::sendMessage([
                        'chat_id' => $userId,
                        'text' => Messages::getInstance()->getMessageStartMessage('welcome_message'),
                        'parse_mode' => 'HTML',
                    ]);
                else {
                    $reply_markup = Keyboard::make([
                        'keyboard' => KeyboardBot::getInstance()->getStartDemandButton(),
                        'resize_keyboard' => true,
                    ]);

                    Telegram::sendMessage([
                        'chat_id' => $userId,
                        'text' => Messages::getInstance()->getMessageStartDemand('channel_link'),
                        'parse_mode' => 'HTML',
                        'reply_markup' => $reply_markup
                    ]);
                }

            } else {

                if (isset(explode($messageText, ' ')[1]))
                    Login::getInstance()->registerUser($userId, $userName, explode($messageText, ' ')[1]);
                else
                    Login::getInstance()->registerUser($userId, $userName);

                $reply_markup = Keyboard::make([
                    'keyboard' => Keyboard::getInstance()->getStartDemandButton(),
                    'resize_keyboard' => true,
                ]);

                Telegram::sendMessage([
                    'chat_id' => $userId,
                    'text' => Messages::getInstance()->getMessageStartDemand('channel_link'),
                    'parse_mode' => 'HTML',
                    'reply_markup' => $reply_markup
                ]);

            }
        }
    }

    public function checkSubscribe($messageText, $userId) {
        $statusUser = Login::getInstance()->getUserField($userId, 'status');
        if ($messageText == '🔎 Проверить подписку на канал') {
            if (!$statusUser[0]->status) {
                $serverModel = new ServerModel();
                $chatId = $serverModel->getBotSetting('channel_id')[0]->channel_id;

                $responseChannelData = Telegram::getChatMember([
                    'chat_id' => $chatId,
                    'user_id' => $userId
                ]);

                if ($responseChannelData->status != 'left')
                    Telegram::sendMessage([
                        'chat_id' => $userId,
                        'text' => Messages::getInstance()->successRegister('payment_registration'),
                        'parse_mode' => 'HTML',
                    ]);
                else
                    Telegram::sendMessage([
                        'chat_id' => $userId,
                        'text' => Messages::getInstance()->unSuccessRegister(),
                        'parse_mode' => 'HTML',
                    ]);
            }
        }
    }
}
