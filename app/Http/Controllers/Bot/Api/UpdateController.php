<?php

namespace App\Http\Controllers\Bot\Api;

use App\Http\Controllers\Bot\Api\Messages\Messages;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Bot\Api\Sender\Sender;

use Telegram;

class UpdateController extends Controller
{
    public function getWebhookUpdates(Request $request) {

        try {
            if (isset($request['message']['text'])) {
                Sender::getInstance()->startBot($request['message']['text'], $request['message']['from']['first_name'], $request['message']['from']['id']);
                Sender::getInstance()->checkSubscribe($request['message']['text'], $request['message']['from']['id']);
            }
        } catch (\Throwable $e) {
            Telegram::sendMessage([
                'chat_id' => $request['message']['from']['id'],
                'text' => $e->getMessage() . PHP_EOL,
                'parse_mode' => 'HTML',
            ]);
        }
    }
}
