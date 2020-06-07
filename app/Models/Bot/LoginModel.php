<?php

namespace App\Models\Bot;

use Illuminate\Database\Eloquent\Model;

class LoginModel extends Model
{
    public function getUserById($userId) {
        return DB::table('table_bot_users')
            ->where('table_bot_users.user_id', $userId)
            ->select('table_bot_users.*')
            ->get();
    }
}
