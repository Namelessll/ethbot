<?php

namespace App\Http\Controllers;

use App\Models\ServerModel;
use App\UserModel;
use Illuminate\Http\Request;
use function GuzzleHttp\Promise\all;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    static public $activityAr = array();
    static public $activityStatus = 'on';

    public function __construct()
    {
        $serverModel = new ServerModel();
        self::$activityAr = $serverModel->getUserActivity();
        self::$activityStatus = $serverModel->getSetting('activity');
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $serverModel = new ServerModel();
        $data['user_activity'] = self::$activityAr;
        $data['status_activity'] = self::$activityStatus;
        $data['server_api'] = $serverModel->getSetting('server_api');
        return view('home', $data);
    }

    public function viewManagement() {
        $data['user_activity'] = self::$activityAr;
        $data['status_activity'] = self::$activityStatus;
        $serverModel = new ServerModel();
        $data['bot_settings'] = $serverModel->getBotSettings();

        return view('management', $data);
    }

    public function viewStatistic() {
        $data['user_activity'] = self::$activityAr;
        $data['status_activity'] = self::$activityStatus;
        $data['users'] = UserModel::getUsers();
        return view('statistic', $data);
    }

    public function viewQuestions() {
        $data['user_activity'] = self::$activityAr;
        $data['status_activity'] = self::$activityStatus;
        return view('questions', $data);
    }

    public function viewMailer() {
        $data['user_activity'] = self::$activityAr;
        $data['status_activity'] = self::$activityStatus;
        return view('mailer', $data);
    }

    public function viewPayments() {
        $data['user_activity'] = self::$activityAr;
        $data['status_activity'] = self::$activityStatus;
        $data['payments'] = UserModel::getAllTransaction();
        return view('payments', $data);
    }

}
