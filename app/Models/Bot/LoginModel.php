<?php

namespace App\Models\Bot;

use Illuminate\Database\Eloquent\Model;
use DB;

class LoginModel extends Model
{
    /*Проверка на наличие пользователя в базе*/
    public function getUserById($userId) {
        return DB::table('table_bot_users')
            ->where('table_bot_users.user_id', $userId)
            ->select('table_bot_users.*')
            ->get();
    }

    /*Регистрация нового пользователя*/
    public function registerNewUser($userId, $userName, $inviteId) {
        return DB::table('table_bot_users')
            ->insert([
                'user_id' => $userId,
                'username' => $userName,
                'invite' => $inviteId,
            ]);
    }

    /*Получение значение поля по коду*/
    public function getUserField($userId, $code) {
        return DB::table('table_bot_users')
            ->where('table_bot_users.user_id', $userId)
            ->select('table_bot_users.' . $code)
            ->get();
    }



}
