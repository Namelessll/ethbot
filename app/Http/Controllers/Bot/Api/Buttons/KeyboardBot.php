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

    public function getStartBotKeyboard() {
        return [
            ['💰 Мой кошелек', '🎁 Получить бонус'],
            ['👫 Пригласить друзей', '❓ Задать вопрос'],
            ['💲 XXX TOKEN', '💬 Вопрос/Ответ']
        ];
    }

    public function getStartDemandButton() {
        return [
            ['🔎 Проверить подписку на канал']
        ];
    }

    public function getProfileKeyboard() {
        return [
            ['💸 Вывести', '⚖️ Конвертировать']
        ];
    }

    public function generateBonusKeyBoard($min, $max) {
        return [
            [['text' => "🔲", 'callback_data' => "bonus_" . rand($min, $max)],['text' => "🔲", 'callback_data' => "bonus_" . rand($min, $max)],['text' => "🔲", 'callback_data' => "bonus_" . rand($min, $max)],['text' => "🔲", 'callback_data' => "bonus_" . rand($min, $max)],['text' => "🔲", 'callback_data' => "bonus_" . rand($min, $max)]],
            [['text' => "🔲", 'callback_data' => "bonus_" . rand($min, $max)],['text' => "🔲", 'callback_data' => "bonus_" . rand($min, $max)],['text' => "🔲", 'callback_data' => "bonus_" . rand($min, $max)],['text' => "🔲", 'callback_data' => "bonus_" . rand($min, $max)],['text' => "🔲", 'callback_data' => "bonus_" . rand($min, $max)]],
            [['text' => "🔲", 'callback_data' => "bonus_" . rand($min, $max)],['text' => "🔲", 'callback_data' => "bonus_" . rand($min, $max)],['text' => "🔲", 'callback_data' => "bonus_" . rand($min, $max)],['text' => "🔲", 'callback_data' => "bonus_" . rand($min, $max)],['text' => "🔲", 'callback_data' => "bonus_" . rand($min, $max)]],
            [['text' => "🔲", 'callback_data' => "bonus_" . rand($min, $max)],['text' => "🔲", 'callback_data' => "bonus_" . rand($min, $max)],['text' => "🔲", 'callback_data' => "bonus_" . rand($min, $max)],['text' => "🔲", 'callback_data' => "bonus_" . rand($min, $max)],['text' => "🔲", 'callback_data' => "bonus_" . rand($min, $max)]],
            [['text' => "🔲", 'callback_data' => "bonus_" . rand($min, $max)],['text' => "🔲", 'callback_data' => "bonus_" . rand($min, $max)],['text' => "🔲", 'callback_data' => "bonus_" . rand($min, $max)],['text' => "🔲", 'callback_data' => "bonus_" . rand($min, $max)],['text' => "🔲", 'callback_data' => "bonus_" . rand($min, $max)]],
        ];
    }
}
