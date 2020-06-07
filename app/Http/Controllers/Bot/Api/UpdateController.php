<?php

namespace App\Http\Controllers\Bot\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Bot\Api\Sender\Sender;

use Telegram;

class UpdateController extends Controller
{
    public function getWebhookUpdates(Request $request) {
        Sender::getInstance()->startBot($request['message']['text'], $request['message']['from']['id']);
        try {

        } catch (\Throwable $e) {

        }
    }
}
