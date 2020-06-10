<?php


namespace App\Http\Controllers\Bot\Api\Buttons;


class KeyboardBot
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

    public function getStartDemandButton() {
        return [
            ['🔎 Проверить подписку на канал']
        ];
    }
}
