<?php

namespace App\Http\Controllers\Bot\Connect;

use App\Http\Controllers\Controller;
use App\Models\ServerModel;
use Illuminate\Http\Request;
use Telegram;

class ConnectController extends Controller
{
    private static $token = "941359684:AAFDmLrGeY5AGuRhCaa6xIFYRShE3E7450w";

    public function saveBotSetting(Request $request) {
        $serverModel = new ServerModel();
        $serverModel->saveBotSettings($request->all());
        $activity = array(
            'activity_code' => 'server',
            'activity_name' => 'Настройки бота обновлены.',
            'activity_description' => 'Администратор обновил основные параметры бота.'
        );
        $serverModel->putUserActivity($activity);

        return redirect()->back()->with('success', 'Настройки бота успешно обновлены');
    }

    public function saveActivitySetting(Request $request) {
        $serverModel = new ServerModel();
        $status = (isset($request->all()['status'])) ? 'on' : 'off';
        $serverModel->saveSettings('activity', array(
            'activity' => $status
        ));
        return redirect()->back();
    }

    public function saveServerSetting(Request $request) {
        $serverModel = new ServerModel();
        $serverModel->saveSettings('server_api', $request->all());
        $activity = array(
            'activity_code' => 'server',
            'activity_name' => 'Изменена конфигурация сервера.',
            'activity_description' => 'Администратор изменил Domain API на "' .$request->all()['server_api'] . '".'
        );
        $serverModel->putUserActivity($activity);

        return redirect()->back()->with('success', 'Настройки сервера успешно обновлены');
    }

    public function setWebhook(Request $request) {
        $serverModel = new ServerModel();
        $data['server_api'] = $serverModel->getSetting('server_api');
        $result = Telegram::setWebhook([
            'url' => $data['server_api'][0]->setting_value . '/' . self::$token . '/webhook'
        ]);
        $status = Telegram::getWebhookInfo();
        $activity = array(
            'activity_code' => 'webhook',
            'activity_name' => 'Установлен веб-хук',
            'activity_description' => 'Администратор установил веб-хук на домен ' . str_ireplace('https://', '', $data['server_api'][0]->setting_value) . '. Бот активен.'
        );
        $serverModel->putUserActivity($activity);

        return redirect()->back()->with('success', 'Веб-хук успешно установлен');
    }

    public function removeWebhook(Request $request) {
        $serverModel = new ServerModel();
        $response = Telegram::removeWebhook();
        $activity = array(
            'activity_code' => 'webhook',
            'activity_name' => 'Удален веб-хук',
            'activity_description' => 'Администратор удалил веб-хук. Бот не активен.'
        );
        $serverModel->putUserActivity($activity);


        return redirect()->back()->with('error', 'Веб-хук успешно удален');
    }
}
