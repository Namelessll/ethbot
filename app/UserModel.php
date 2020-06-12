<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use DB;

class UserModel extends Model
{
    /*Обновление поля userId и field*/
    public static function updateUserField($userId, $field, $value) {
        return DB::table('table_bot_users')
            ->where('table_bot_users.user_id', $userId)
            ->update([
                $field => $value
            ]);
    }

    public static function getUsers() {
        return DB::table('table_bot_users')
            ->select('table_bot_users.*')
            ->paginate(10);
    }

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

    public function addTransaction($userId, $valet, $value) {
        return DB::table('table_transactions')
            ->insert([
                'user_id' => $userId,
                'valet' => $valet,
                'value' => $value,
                'created_at' => Carbon::now()
            ]);
    }

    public static function updateTransaction($id, $userId, $status) {
        return DB::table('table_transactions')
            ->where('table_transactions.id', $id)
            ->where('table_transactions.user_id', $userId)
            ->update([
                'status' => $status
            ]);
    }

    public static function getAllTransaction() {
        return DB::table('table_transactions')
            ->select('table_transactions.*')
            ->paginate();
    }

}
