<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use DB;

class ServerModel extends Model
{
    public function getUserActivity() {
        return DB::table('table_user_activity')
            ->orderBy('table_user_activity.created_at', 'desc')
            ->select('table_user_activity.*')
            ->get(10);
    }

    public function getBotSettings() {
        return DB::table('table_settings_bot')
            ->select('table_settings_bot.*')
            ->get();
    }

    public function getBotSetting($code) {
        return DB::table('table_settings_bot')
            ->select('table_settings_bot.' . $code)
            ->get();
    }

    public function putUserActivity($activity) {
        $activityStatus = DB::table('table_server_settings')
            ->where('table_server_settings.setting_code', 'activity')
            ->select('table_server_settings.setting_code', 'table_server_settings.setting_value')
            ->get();
        if (isset($activityStatus[0]->setting_value) && $activityStatus[0]->setting_value != 'off')
            return DB::table('table_user_activity')
                ->insert([
                    'activity_code' => $activity['activity_code'],
                    'activity_name' => $activity['activity_name'],
                    'activity_description' => $activity['activity_description'],
                    'created_at' => Carbon::now()
                ]);
    }

    public function getSetting($settingCode) {
        return DB::table('table_server_settings')
            ->where('table_server_settings.setting_code', $settingCode)
            ->select('table_server_settings.setting_code', 'table_server_settings.setting_value')
            ->get();
    }

    public function getSettings($settingsCode = array()) {
        $settingsAr = array();
        foreach ($settingsCode as $code)
            $settingsAr[] = DB::table('table_server_settings')
                ->where('table_server_settings.setting_code', $code)
                ->select('table_server_settings.setting_code', 'table_server_settings.setting_value')
                ->get();

        return $settingsAr;


    }

    public function saveSettings($code, $data) {
        $count = DB::table('table_server_settings')
            ->where('table_server_settings.setting_code', $code)
            ->count();
        if ($count > 0)
            return DB::table('table_server_settings')
                ->where('table_server_settings.setting_code', $code)
                ->update([
                    'setting_value' => $data[$code]
                ]);
        else
            return DB::table('table_server_settings')
                ->insert([
                    'setting_code' => $code,
                    'setting_value' => $data[$code]
                ]);
    }

    public function saveBotSettings($data) {
        $count = DB::table('table_settings_bot')
            ->count();

        if ($count > 0)
            return DB::table('table_settings_bot')
                ->update([
                    'captcha_question' => $data['captcha_question'],
                    'captcha_answer' => $data['captcha_answer'],
                    'welcome_message' => $data['welcome_message'],
                    'payment_registration' => $data['payment_registration'],
                    'payment_out' => $data['payment_out'],
                    'payment_min' => $data['payment_min'],
                    'payment_max' => $data['payment_max'],
                    'payment_by_refer' => $data['payment_by_refer'],
                    'payment_by_refer_percent' => $data['payment_by_refer_percent'],
                ]);
        else
            return DB::table('table_settings_bot')
                ->insert([
                    'captcha_question' => $data['captcha_question'],
                    'captcha_answer' => $data['captcha_answer'],
                    'welcome_message' => $data['welcome_message'],
                    'payment_registration' => $data['payment_registration'],
                    'payment_out' => $data['payment_out'],
                    'payment_min' => $data['payment_min'],
                    'payment_max' => $data['payment_max'],
                    'payment_by_refer' => $data['payment_by_refer'],
                    'payment_by_refer_percent' => $data['payment_by_refer_percent'],
                ]);
    }
}
