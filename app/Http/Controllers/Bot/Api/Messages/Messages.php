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

    public function getMessageStartMessage($code) {
        $serverModel = new ServerModel();
        return $serverModel->getBotSetting($code)[0]->$code;
    }

    public function getMessageStartDemand($code) {
        $serverModel = new ServerModel();
        return "Чтобы продолжить работу с ботом, вам нужно подписаться на наш телеграмм канал - " . $serverModel->getBotSetting($code)[0]->$code;
    }

    public function successRegister($code) {
        $serverModel = new ServerModel();
        return "✅ Отлично!\nВаш аккаунт активирован и вам начислено на кошелек " . $serverModel->getBotSetting($code)[0]->$code . " " . self::$coin . " coin";
    }

    public function unSuccessRegister() {

        return "❌ Ошибка!\nВаш аккаунт не подписан на канал. Чтобы продолжить работу с ботом, вам нужно подписаться на наш телеграмм канал.";
    }
}
