<?php

namespace App\Http\Controllers\Bot\Api;

use App\Http\Controllers\Bot\Api\Login\Login;
use App\Http\Controllers\Bot\Api\Messages\Messages;
use App\Http\Controllers\Controller;
use App\Models\Bot\LoginModel;
use App\UserModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Bot\Api\Sender\Sender;

use Telegram;

class UpdateController extends Controller
{

    public function transactionAccept(Request $request) {
        $data = $request->all();
        Telegram::sendMessage([
            'chat_id' => $data['user_id'],
            'text' => "✅ Ваша заявка на вывод была одобрена, ожидайте выполнения!",
            'parse_mode' => 'HTML',
        ]);
        UserModel::updateTransaction($data['transaction_id'], $data['user_id'], 1);
        return redirect()->back();
    }

    public function transactionDecline(Request $request) {
        $data = $request->all();
        Telegram::sendMessage([
            'chat_id' => $data['user_id'],
            'text' => "🚫 Ваша заявка на вывод была отклонена!",
            'parse_mode' => 'HTML',
        ]);
        UserModel::updateTransaction($data['transaction_id'], $data['user_id'], 2);
        return redirect()->back();
    }

    public function banStatusUser(Request $request) {
        Telegram::sendMessage([
            'chat_id' => $request->all()['user_id'],
            'text' => "🚫 Ваш аккаунт был заблокирован за нарушение правил пользования ботом!",
            'parse_mode' => 'HTML',
        ]);
        UserModel::updateUserField($request->all()['user_id'], 'ban', 1);
        return redirect()->back();
    }

    public function unBanStatusUser(Request $request) {
        Telegram::sendMessage([
            'chat_id' => $request->all()['user_id'],
            'text' => "✅ Ваш аккаунт был разблокирован!",
            'parse_mode' => 'HTML',
        ]);
        UserModel::updateUserField($request->all()['user_id'], 'ban', 0);
        return redirect()->back();
    }

    protected function getWebhookUpdates(Request $request) {

        try {
            if (isset($request['message']['text'])) {

                if (stristr($request['message']['text'], 'start=')) {
                    die();
                }

                if (Login::getInstance()->checkUser($request['message']['from']['id'])) {
                    $loginModel = new LoginModel();
                    if ($loginModel->getUserField($request['message']['from']['id'], 'ban')[0]->ban != 0) {
                        Telegram::sendMessage([
                            'chat_id' => $request['message']['from']['id'],
                            'text' => "Ваш аккаунт заблокирован! Доступ к функциям бота запрещен.",
                            'parse_mode' => 'HTML',
                        ]);
                    }
                }

                Sender::getInstance()->backToMenu($request['message']['text'], $request['message']['from']['id']);

                if (Login::getInstance()->checkUser($request['message']['from']['id'])) {
                    $loginModel = new LoginModel();
                    if ($loginModel->getUserField($request['message']['from']['id'], 'valet')[0]->valet != 0) {
                        Sender::getInstance()->setPayValet($request['message']['from']['id'], $request['message']['text']);
                        Sender::getInstance()->setPaySum($request['message']['from']['id'], $request['message']['text']);

                        if ($request['message']['text'] != "💸 Вывести")
                            UserModel::updateUserField($request['message']['from']['id'], 'valet', 0);
                    }

                    if ($loginModel->getUserField($request['message']['from']['id'], 'convert')[0]->convert != 0) {
                        Sender::getInstance()->setConvert($request['message']['from']['id'], $request['message']['text']);
                    }
                }


                Sender::getInstance()->startBot($request['message']['text'], $request['message']['from']['first_name'], $request['message']['from']['id']);
                Sender::getInstance()->checkSubscribe($request['message']['text'], $request['message']['from']['id']);
                Sender::getInstance()->getReferalMessage($request['message']['text'], $request['message']['from']['id']);
                Sender::getInstance()->getAskQuestionMessage($request['message']['text'], $request['message']['from']['id']);
                Sender::getInstance()->getAnswersQuestionsMessage($request['message']['text'], $request['message']['from']['id']);
                Sender::getInstance()->getCoinCourse($request['message']['text'], $request['message']['from']['id']);
                Sender::getInstance()->getBonus($request['message']['text'], $request['message']['from']['id']);
                Sender::getInstance()->getValet($request['message']['text'], $request['message']['from']['id']);
                Sender::getInstance()->getConvert($request['message']['text'], $request['message']['from']['id']);
                Sender::getInstance()->getPay($request['message']['text'], $request['message']['from']['id']);
            } elseif (isset($request['callback_query'])) {
                Sender::getInstance()->getReward($request['callback_query']['message']['message_id'], $request['callback_query']['data'], $request['callback_query']['message']['chat']['id']);
            }
        } catch (\Throwable $e) {
            Telegram::sendMessage([
                'chat_id' => 509940535,
                'text' => $e->getMessage() . PHP_EOL,
                'parse_mode' => 'HTML',
            ]);
        }
    }
}
