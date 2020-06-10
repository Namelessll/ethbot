<?php


namespace App\Http\Controllers\Bot\Api\Balance;


use App\UserModel;
use Carbon\Carbon;

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

}
