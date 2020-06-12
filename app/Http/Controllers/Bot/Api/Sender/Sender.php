<?php


namespace App\Http\Controllers\Bot\Api\Sender;
use App\Http\Controllers\Bot\Api\Balance\BalanceClass;
use App\Http\Controllers\Bot\Api\Buttons\KeyboardBot;
use App\Http\Controllers\Bot\Api\Login\Login;
use App\Http\Controllers\Bot\Api\Messages\Messages;
use App\Models\Bot\LoginModel;
use App\Models\ServerModel;
//use Telegram\Bot\Api;
use App\UserModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
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

    public function setConvert($userId, $value) {
        $loginModel = new LoginModel();
        if ($loginModel->getUserField($userId, 'convert')[0]->convert == 1) {

            try {
                $reply_markup = Keyboard::make([
                    'keyboard' => KeyboardBot::getInstance()->getStartBotKeyboard(),
                    'resize_keyboard' => true,
                ]);
                $balance = $loginModel->getUserField($userId, 'balanceToken')[0]->balanceToken;
                if ((int) $value <= $balance) {
                    $lastCheck = BalanceClass::getInstance()->getEthCourseInfo();
                    $course = $lastCheck[0]->value;
                    if (Carbon::now()->diffInMinutes(Carbon::parse($lastCheck[0]->created_at)) > 5) {
                        $course = BalanceClass::getInstance()->updateEthCourseInfo();
                    }

                    $serverModel = new ServerModel();
                    $userModel = new UserModel();

                    $tokenCourse = $serverModel->getBotSetting('token_course')[0]->token_course;
                    $result = round($tokenCourse * $value / $course, 5);

                    $userModel->changeBalance($userId, $value, 'balanceToken', '-');
                    $userModel->changeBalance($userId, $result, 'balanceEth', '+');
                    Telegram::sendMessage([
                        'chat_id' => $userId,
                        'text' => Messages::getInstance()->getConvertReady($result),
                        'parse_mode' => 'HTML',
                        'reply_markup' => $reply_markup
                    ]);

                } else {
                    Telegram::sendMessage([
                        'chat_id' => $userId,
                        'text' => Messages::getInstance()->getConvertError(),
                        'parse_mode' => 'HTML',
                        'reply_markup' => $reply_markup
                    ]);
                }
            } catch (\Throwable $exception) {
                $reply_markup = Keyboard::make([
                    'keyboard' => KeyboardBot::getInstance()->getStartBotKeyboard(),
                    'resize_keyboard' => true,
                ]);
                Telegram::sendMessage([
                    'chat_id' => $userId,
                    'text' => "Ошибка! Введенное сообщение не является числом!",
                    'parse_mode' => 'HTML',
                    'reply_markup' => $reply_markup
                ]);
            }
            UserModel::updateUserField($userId, 'convert', 0);
        }
    }

    public function setPayValet($userId, $value) {
        $loginModel = new LoginModel();
        if ($loginModel->getUserField($userId, 'valet')[0]->valet == 1) {
            UserModel::updateUserField($userId, 'valetCode', $value);
            UserModel::updateUserField($userId, 'valet', 2);
            Telegram::sendMessage([
                'chat_id' => $userId,
                'text' => Messages::getInstance()->getPaySuccessSecond(),
                'parse_mode' => 'HTML',
            ]);
            die();
        }
    }

    public function setPaySum($userId, $value) {
        $loginModel = new LoginModel();
        if ($loginModel->getUserField($userId, 'valet')[0]->valet == 2) {
            try {
                $value = (int) $value;
                if (BalanceClass::getInstance()->tryGetPayOnStep($userId, $value)) {
                    $reply_markup = Keyboard::make([
                        'keyboard' => KeyboardBot::getInstance()->getStartBotKeyboard(),
                        'resize_keyboard' => true,
                    ]);
                    Telegram::sendMessage([
                        'chat_id' => $userId,
                        'text' => Messages::getInstance()->getPaySuccessThird(),
                        'parse_mode' => 'HTML',
                        'reply_markup' => $reply_markup
                    ]);
                    $userModel = new UserModel();
                    $userModel->changeBalance($userId, $value, 'balanceEth', '-');
                    $userModel->addTransaction($userId, $loginModel->getUserField($userId, 'valetCode')[0]->valetCode, $value);
                } else {
                    $serverModel = new ServerModel();
                    $minPay = $serverModel->getBotSetting('payment_out')[0]->payment_out;
                    $reply_markup = Keyboard::make([
                        'keyboard' => KeyboardBot::getInstance()->getStartBotKeyboard(),
                        'resize_keyboard' => true,
                    ]);
                    Telegram::sendMessage([
                        'chat_id' => $userId,
                        'text' => Messages::getInstance()->getPayErrorSecond($minPay),
                        'parse_mode' => 'HTML',
                        'reply_markup' => $reply_markup
                    ]);
                }
            } catch (\Throwable $exception) {
                $reply_markup = Keyboard::make([
                    'keyboard' => KeyboardBot::getInstance()->getStartBotKeyboard(),
                    'resize_keyboard' => true,
                ]);
                Telegram::sendMessage([
                    'chat_id' => $userId,
                    'text' => "Ошибка! Введенное сообщение не является числом!",
                    'parse_mode' => 'HTML',
                    'reply_markup' => $reply_markup
                ]);
            }

            UserModel::updateUserField($userId, 'valet', 0);
        }
    }

    public function backToMenu($messageText, $userId) {
        if ($messageText == '🔙 Назад') {
            if (Login::getInstance()->checkUser($userId)) {
                $statusUser = Login::getInstance()->getUserField($userId, 'status');
                if ($statusUser[0]->status) {
                    $reply_markup = Keyboard::make([
                        'keyboard' => KeyboardBot::getInstance()->getStartBotKeyboard(),
                        'resize_keyboard' => true,
                    ]);
                    Telegram::sendMessage([
                        'chat_id' => $userId,
                        'text' => Messages::getInstance()->getMessageStartMessage('welcome_message'),
                        'parse_mode' => 'HTML',
                        'reply_markup' => $reply_markup
                    ]);
                }
                UserModel::updateUserField($userId, 'valet', 0);
                UserModel::updateUserField($userId, 'convert', 0);
            }
        }
    }

    public function startBot($messageText, $userName, $userId) {
        if (stristr($messageText, '/start')) {
            if (Login::getInstance()->checkUser($userId)) {
                $statusUser = Login::getInstance()->getUserField($userId, 'status');
                if ($statusUser[0]->status) {
                    $reply_markup = Keyboard::make([
                        'keyboard' => KeyboardBot::getInstance()->getStartBotKeyboard(),
                        'resize_keyboard' => true,
                    ]);
                    Telegram::sendMessage([
                        'chat_id' => $userId,
                        'text' => Messages::getInstance()->getMessageStartMessage('welcome_message'),
                        'parse_mode' => 'HTML',
                        'reply_markup' => $reply_markup
                    ]);
                } else {
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
                if (isset( explode(' ', $messageText)[1])) {
                    $inviteId = (int) explode(' ', $messageText)[1];
                    Login::getInstance()->registerUser($userId, $userName, $inviteId);
                } else
                    Login::getInstance()->registerUser($userId, $userName);

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
        }
    }

    public function checkSubscribe($messageText, $userId) {
        if ($messageText == '🔎 Проверить подписку на канал') {
            $statusUser = Login::getInstance()->getUserField($userId, 'status');
            if (!$statusUser[0]->status) {
                $serverModel = new ServerModel();
                $chatId = $serverModel->getBotSetting('channel_id')[0]->channel_id;

                $responseChannelData = Telegram::getChatMember([
                    'chat_id' => $chatId,
                    'user_id' => $userId
                ]);

                if ($responseChannelData->status != 'left') {
                    $reply_markup = Keyboard::make([
                        'keyboard' => KeyboardBot::getInstance()->getStartBotKeyboard(),
                        'resize_keyboard' => true,
                    ]);

                    $inviteUser = Login::getInstance()->getUserField($userId, 'invite');
                    if (isset($inviteUser[0]->invite) && $inviteUser[0]->invite != 0) {
                        $statusInvite = Login::getInstance()->getUserField($inviteUser[0]->invite, 'status');
                        if ($statusInvite[0]->status) {
                            $sumReferRegister = $serverModel->getBotSetting('payment_by_refer')[0]->payment_by_refer;
                            BalanceClass::getInstance()->changeUserBalance($inviteUser[0]->invite, $sumReferRegister, 'balanceToken', '+');
                            Login::getInstance()->addReferalToUser($inviteUser[0]->invite);
                            Telegram::sendMessage([
                                'chat_id' => $inviteUser[0]->invite,
                                'text' => Messages::getInstance()->referalRegister($sumReferRegister),
                                'parse_mode' => 'HTML',
                            ]);
                        }
                    }

                    $sumSuccessRegister = $serverModel->getBotSetting('payment_registration')[0]->payment_registration;
                    Telegram::sendMessage([
                        'chat_id' => $userId,
                        'text' => Messages::getInstance()->successRegister($sumSuccessRegister),
                        'parse_mode' => 'HTML',
                        'reply_markup' => $reply_markup
                    ]);
                    BalanceClass::getInstance()->changeUserBalance($userId, $sumSuccessRegister, 'balanceToken', '+');
                    Login::getInstance()->verifyUser($userId);
                } else
                    Telegram::sendMessage([
                        'chat_id' => $userId,
                        'text' => Messages::getInstance()->unSuccessRegister(),
                        'parse_mode' => 'HTML',
                    ]);
            }
        }
    }

    public function getReferalMessage($messageText, $userId) {
        if ($messageText == '👫 Пригласить друзей') {
            $botName = Telegram::getMe();
            Telegram::sendMessage([
                'chat_id' => $userId,
                'text' => Messages::getInstance()->getReferalMessage($userId, $botName['username']),
                'parse_mode' => 'HTML',
            ]);
        }
    }

    public function getAskQuestionMessage($messageText, $userId) {
        if ($messageText == '❓ Задать вопрос') {

            $serverModel = new ServerModel();
            $keyboard = array("inline_keyboard"=> array_values(KeyboardBot::getInstance()->getManagerButton($serverModel->getBotSetting('manager')[0]->manager)), 'one_time_keyboard' => true);
            $keyboard = json_encode($keyboard);
            Telegram::sendMessage([
                'chat_id' => $userId,
                'text' => Messages::getInstance()->getAskQuestionMessage('ask_question_message'),
                'parse_mode' => 'HTML',
                'reply_markup' => $keyboard
            ]);
        }
    }

    public function getAnswersQuestionsMessage($messageText, $userId) {
        if ($messageText == '💬 Вопрос/Ответ') {
            Telegram::sendMessage([
                'chat_id' => $userId,
                'text' => Messages::getInstance()->getAskQuestionMessage('question_answers'),
                'parse_mode' => 'HTML',
            ]);
        }
    }

    public function getCoinCourse($messageText, $userId) {
        if ($messageText == '💲 XXX TOKEN') {
            Telegram::sendMessage([
                'chat_id' => $userId,
                'text' => Messages::getInstance()->getCourseCoinMessage('token_course'),
                'parse_mode' => 'HTML',
            ]);
        }
    }

    public function getBonus($messageText, $userId) {
        if ($messageText == '🎁 Получить бонус') {
            if(BalanceClass::getInstance()->viewBonusKeyboard($userId)) {
                $serverModel = new ServerModel();
                $keyboard = array("inline_keyboard"=> array_values(KeyboardBot::getInstance()->generateBonusKeyBoard($serverModel->getBotSetting('payment_min')[0]->payment_min, $serverModel->getBotSetting('payment_max')[0]->payment_max)), 'one_time_keyboard' => true);
                $keyboard = json_encode($keyboard);
                Telegram::sendMessage([
                    'chat_id' => $userId,
                    'text' => Messages::getInstance()->getBonus(),
                    'parse_mode' => 'HTML',
                    'reply_markup' => $keyboard
                ]);
            } else {
                $userModel = new UserModel();
                $timeLast = $userModel->getFieldTableBonus($userId, 'created_at')[0]->created_at;
                Telegram::sendMessage([
                    'chat_id' => $userId,
                    'text' => Messages::getInstance()->getBonusFailTimeout(Carbon::parse($timeLast)->addMinutes(1440)->diffAsCarbonInterval(Carbon::now())->locale('ru')),
                    'parse_mode' => 'HTML',
                ]);
            }
        }
    }

    public function getValet($messageText, $userId) {
        if ($messageText == '💰 Мой кошелек') {
            $reply_markup = Keyboard::make([
                'keyboard' => KeyboardBot::getInstance()->getProfileKeyboard(),
                'resize_keyboard' => true,
            ]);

            $token = Login::getInstance()->getUserField($userId, 'balanceToken')[0]->balanceToken;
            $eth = Login::getInstance()->getUserField($userId, 'balanceEth')[0]->balanceEth;


            Telegram::sendMessage([
                'chat_id' => $userId,
                'text' => Messages::getInstance()->getMyValet($token, $eth),
                'parse_mode' => 'HTML',
                'reply_markup' => $reply_markup
            ]);
        }
    }

    public function getPay($messageText, $userId) {
        if ($messageText == '💸 Вывести') {
            if (BalanceClass::getInstance()->tryGetPay($userId)) {
                $reply_markup = Keyboard::make([
                    'keyboard' => KeyboardBot::getInstance()->getBack(),
                    'resize_keyboard' => true,
                ]);
                Telegram::sendMessage([
                    'chat_id' => $userId,
                    'text' => Messages::getInstance()->getPaySuccessFirst(),
                    'parse_mode' => 'HTML',
                    'reply_markup' => $reply_markup
                ]);
                UserModel::updateUserField($userId, 'valet', 1);

            } else {
                $serverModel = new ServerModel();
                $reply_markup = Keyboard::make([
                    'keyboard' => KeyboardBot::getInstance()->getStartBotKeyboard(),
                    'resize_keyboard' => true,
                ]);
                Telegram::sendMessage([
                    'chat_id' => $userId,
                    'text' => Messages::getInstance()->getPayError($serverModel->getBotSetting('payment_out')[0]->payment_out),
                    'parse_mode' => 'HTML',
                    'reply_markup' => $reply_markup
                ]);
            }
        }
    }

    public function getConvert($messageText, $userId) {
        if ($messageText == '⚖️ Конвертировать') {
            $reply_markup = Keyboard::make([
                'keyboard' => KeyboardBot::getInstance()->getBack(),
                'resize_keyboard' => true,
            ]);
            Telegram::sendMessage([
                'chat_id' => $userId,
                'text' => Messages::getInstance()->getCourseConverterMessage('token_course'),
                'parse_mode' => 'HTML',
                'reply_markup' => $reply_markup
            ]);
            UserModel::updateUserField($userId, 'convert', 1);
        }
    }

    /*CALLBACK*/
    public function getReward($messageId, $callbackData, $userId) {
        if (strpos($callbackData, 'bonus_') !== false) {
            $rewardInt = explode('_', $callbackData)[1];
            BalanceClass::getInstance()->changeUserBalance($userId, $rewardInt, 'balanceToken', '+');
            Telegram::editMessageText([
                'message_id' => $messageId,
                'chat_id' => $userId,
                'text' => Messages::getInstance()->getRewardMessage($rewardInt),
                'parse_mode' => 'HTML',
            ]);
        }
    }

}
