<?php


namespace App\Http\Controllers\Bot\Api\Login;


use App\Models\Bot\LoginModel;

class Login
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

    public function checkUser($userId) {
        $loginModel = new LoginModel();
        $userRs = $loginModel->getUserById($userId);
        if (count($userRs) > 0)
            return true;
        else
            return false;
    }
}
