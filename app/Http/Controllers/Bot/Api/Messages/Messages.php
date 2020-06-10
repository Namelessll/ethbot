<?php


namespace App\Http\Controllers\Bot\Api\Messages;


use App\Models\ServerModel;

class Messages
{
    protected static $_instance;

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

    private static $coin = "XXX";
    private static $botName = "VBotisbot";

    public function getMessageStartMessage($code) {
        $serverModel = new ServerModel();
        return $serverModel->getBotSetting($code)[0]->$code;
    }

    public function getAskQuestionMessage($code) {
        $serverModel = new ServerModel();
        return $serverModel->getBotSetting($code)[0]->$code;
    }

    public function getMessageStartDemand($code) {
        $serverModel = new ServerModel();
        return "Чтобы продолжить работу с ботом, вам нужно подписаться на наш телеграмм канал - " . $serverModel->getBotSetting($code)[0]->$code;
    }

    public function successRegister($value) {
        return "✅ Отлично!\nВаш аккаунт активирован и вам начислено на кошелек " . $value . " " . self::$coin . " coin";
    }

    public function referalRegister($value) {
        return "👍 <b>Хорошие новости!</b>\nПо вашей ссылке перешел ваш друг и выполнил условия для регистрации.\n\n💵 <b>На ваш счет зачисленно:</b> " . $value . " " . self::$coin . " coin";
    }

    public function unSuccessRegister() {

        return "❌ Ошибка!\nВаш аккаунт не подписан на канал. Чтобы продолжить работу с ботом, вам нужно подписаться на наш телеграмм канал.";
    }

    public function getReferalMessage($userId, $botName) {
        $serverModel = new ServerModel();
        return "🎁 Зарабатывайте серьезные деньги приглашая друзей в бота. Каждый человек кто пришел в бота по вашей ссылке будет считаться вашим рефералом.\n\n💵Вознаграждения за рефералов:\n- ".$serverModel->getBotSetting('payment_by_refer')[0]->payment_by_refer." ".self::$coin." coin за каждого реферала, который пришел по вашей ссылке. \n- ".$serverModel->getBotSetting('payment_by_refer_percent')[0]->payment_by_refer_percent." % от каждого бонуса полученным вашим рефералом. \n\n<b>Ваша ссылка для приглашения:</b> https://t.me/".$botName."?start=" . $userId;
    }

    public function getCourseCoinMessage($code) {
        $serverModel = new ServerModel();
        return "💲 <b>Текущий курс " . self::$coin . ":</b> \n\n1 токен => " . $serverModel->getBotSetting($code)[0]->$code . "$";
    }

    public function getBonus() {
        return 'Ты перешел в раздел <b>"🎁 Получить бонус"</b>. Выбери один из квадратов получи приз.';
    }

    public function getBonusFailTimeout($timeout) {
        return '⏱ <b>До следющего получения бонуса:</b> ' . $timeout;
    }
}
