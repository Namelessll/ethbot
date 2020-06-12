<?php


namespace App\Http\Controllers\Bot\Api\Balance;


use App\Http\Controllers\Bot\Api\Login\Login;
use App\Models\ServerModel;
use App\UserModel;
use Carbon\Carbon;
use GuzzleHttp\Client;

class BalanceClass
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

    public function changeUserBalance($userId, $value, $balanceType, $typeOperation) {
        $userModel = new UserModel();
        return $userModel->changeBalance($userId, $value, $balanceType, $typeOperation);
    }

    public function viewBonusKeyboard($userId) {
        $userModel = new UserModel();
        $userTimeAtBonus = $userModel->getFieldTableBonus($userId, 'created_at');
        if (!isset($userTimeAtBonus[0]->created_at)) {
            $userModel->addUserToTableBonus($userId);
            return true;
        }

        if (Carbon::now()->diffInHours(Carbon::parse($userTimeAtBonus[0]->created_at)) >= 24) {
            $userModel->updateBonusTime($userId);
            return true;
        } else {
            return false;
        }
    }

    public function tryGetPay($userId) {
        $serverModel = new ServerModel();
        $minPay = $serverModel->getBotSetting('payment_out')[0]->payment_out;
        $userBalance = Login::getInstance()->getUserField($userId, 'balanceEth')[0]->balanceEth;

        if ($userBalance < $minPay)
            return false;
        else
            return true;
    }

    public function tryGetPayOnStep($userId, $pay) {
        $serverModel = new ServerModel();
        $minPay = $serverModel->getBotSetting('payment_out')[0]->payment_out;
        $userBalance = Login::getInstance()->getUserField($userId, 'balanceEth')[0]->balanceEth;

        if ($userBalance >= $pay && $pay >= $minPay)
            return true;
        else
            return false;
    }

    public function getEthCourseInfo() {
        $serverModel = new ServerModel();
        return $serverModel->getEthCourse();
    }

    public function updateEthCourseInfo() {
        $serverModel = new ServerModel();
        $client = new Client(['base_uri' => 'https://api.binance.com/api/v1/ticker/24hr?symbol=ETHUSDT']);
        $value = json_decode($client->request('GET', '')->getBody()->getContents());
        $serverModel->updateEthCourse($value->askPrice);
        return $value->askPrice;
    }

}
