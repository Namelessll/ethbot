<?php

namespace App\Http\Controllers\Bot\Mail;

use App\Http\Controllers\Controller;
use App\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Telegram;

class MailController extends Controller
{
    public function sendMailToUsers(Request $request) {
        $users = UserModel::getUsers();
        $mail = $request->all()['mail'];
        foreach ($users as $user) {
            Telegram::sendMessage([
                'chat_id' => $user->user_id,
                'text' => $mail,
                'parse_mode' => 'HTML',
            ]);
        }
        return 1;
    }
}
