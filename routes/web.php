<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
$token = "941359684:AAFDmLrGeY5AGuRhCaa6xIFYRShE3E7450w";

Route::get('/', function () {
    return redirect('/admin/dashboard');
});

Route::post('/' . $token . '/webhook', 'Bot\Api\UpdateController@getWebhookUpdates')->name('getWebhookUpdates');

Auth::routes();
Route::get('/admin/dashboard', 'HomeController@index')->name('index');
Route::get('/admin/dashboard/management', 'HomeController@viewManagement')->name('viewManagement');
Route::get('/admin/dashboard/statistic', 'HomeController@viewStatistic')->name('viewStatistic');
Route::get('/admin/dashboard/questions', 'HomeController@viewQuestions')->name('viewQuestions');
Route::get('/admin/dashboard/mailer', 'HomeController@viewMailer')->name('viewMailer');
Route::get('/admin/dashboard/payments', 'HomeController@viewPayments')->name('viewPayments');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/admin', function () {
        return redirect('/admin/dashboard');
    });

    Route::post('/api/send-mail', 'Bot\Mail\MailController@sendMailToUsers')->name('sendMailToUsers');
    Route::post('/api/save/settings', 'Bot\Connect\ConnectController@saveServerSetting')->name('saveServerSetting');
    Route::post('/api/save/bot/settings', 'Bot\Connect\ConnectController@saveBotSetting')->name('saveBotSetting');

    Route::post('/api/user/ban', 'Bot\Api\UpdateController@banStatusUser')->name('banStatusUser');
    Route::post('/api/user/unban', 'Bot\Api\UpdateController@unBanStatusUser')->name('unBanStatusUser');


    Route::post('/api/transaction/accept', 'Bot\Api\UpdateController@transactionAccept')->name('transactionAccept');
    Route::post('/api/transaction/decline', 'Bot\Api\UpdateController@transactionDecline')->name('transactionDecline');

    Route::post('/api/save/settings/activity', 'Bot\Connect\ConnectController@saveActivitySetting')->name('saveActivitySetting');

    Route::post('/setwebhook', 'Bot\Connect\ConnectController@setWebhook')->name('setWebhook');
    Route::post('/removewebhook', 'Bot\Connect\ConnectController@removeWebhook')->name('removeWebhook');

});

