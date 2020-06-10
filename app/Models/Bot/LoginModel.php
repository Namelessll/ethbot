<?php

namespace App\Models\Bot;

use Carbon\Carbon;
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
                'created_at' => Carbon::now()
            ]);
    }

    /*Получение значение поля по коду*/
    public function getUserField($userId, $code) {
        return DB::table('table_bot_users')
            ->where('table_bot_users.user_id', $userId)
            ->select('table_bot_users.' . $code)
            ->get();
    }

    /*Верификация пользователя*/
    public function verifyUser($userId) {
        return DB::table('table_bot_users')
            ->where('table_bot_users.user_id', $userId)
            ->update([
               'status' => true
            ]);
    }

    /*Добавление реферала пользователю по ID*/
    public function addReferalToUser($userId) {
        $userReferals = DB::table('table_bot_users')
            ->where('table_bot_users.user_id', $userId)
            ->select('table_bot_users.referals')
            ->get()[0]->referals;

        return DB::table('table_bot_users')
            ->where('table_bot_users.user_id', $userId)
            ->update([
                'referals' => $userReferals + 1
            ]);
    }


}
