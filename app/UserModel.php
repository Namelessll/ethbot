<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use DB;

class UserModel extends Model
{
    /*Обновление поля Balance*/
    public function changeBalance($userId, $value, $balanceType, $typeOperation) {
        $userBalanceNow = DB::table('table_bot_users')
            ->where('table_bot_users.user_id', $userId)
            ->select('table_bot_users.' . $balanceType)
            ->get()[0]->$balanceType;

        if ($typeOperation == '-')
            return DB::table('table_bot_users')
                ->where('table_bot_users.user_id', $userId)
                ->update([
                    $balanceType => ($userBalanceNow - $value < 0) ? 0 : $userBalanceNow - $value
                ]);
        else
            return DB::table('table_bot_users')
                ->where('table_bot_users.user_id', $userId)
                ->update([
                    $balanceType => $userBalanceNow + $value
                ]);
    }

    /*Забираем поле из таблицы с бонусами, для конкретного пользователя*/
    public function getFieldTableBonus($userId, $filed) {
        return DB::table('table_bot_bonus')
            ->where('table_bot_bonus.user_id', $userId)
            ->select('table_bot_bonus.' . $filed)
            ->get();
    }

    public function addUserToTableBonus($userId) {
        return DB::table('table_bot_bonus')
            ->insert([
                'user_id' => $userId,
                'created_at' => (string) Carbon::now()
            ]);
    }

    public function updateBonusTime($userId) {
        return DB::table('table_bot_bonus')
            ->where('table_bot_bonus.user_id', $userId)
            ->update([
                'created_at' => (string) Carbon::now()
            ]);
    }

}
