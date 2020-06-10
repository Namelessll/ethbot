<?php

namespace App\Http\Controllers\Bot\Api;

use App\Http\Controllers\Bot\Api\Messages\Messages;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Bot\Api\Sender\Sender;

use Telegram;

class UpdateController extends Controller
{
    protected function getWebhookUpdates(Request $request) {

        try {
            if (isset($request['message']['text'])) {
                Sender::getInstance()->startBot($request['message']['text'], $request['message']['from']['first_name'], $request['message']['from']['id']);
                Sender::getInstance()->checkSubscribe($request['message']['text'], $request['message']['from']['id']);
                Sender::getInstance()->getReferalMessage($request['message']['text'], $request['message']['from']['id']);
                Sender::getInstance()->getAskQuestionMessage($request['message']['text'], $request['message']['from']['id']);
                Sender::getInstance()->getAnswersQuestionsMessage($request['message']['text'], $request['message']['from']['id']);
                Sender::getInstance()->getCoinCourse($request['message']['text'], $request['message']['from']['id']);
                Sender::getInstance()->getBonus($request['message']['text'], $request['message']['from']['id']);
            } elseif ( isset($request['message']['text']) ){

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
