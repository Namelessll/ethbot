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
Route::get('/', function () {
    return redirect('/dashboard');
});

Auth::routes();
Route::get('/dashboard', 'HomeController@index')->name('index');
Route::get('/dashboard/management', 'HomeController@viewManagement')->name('viewManagement');
Route::get('/dashboard/statistic', 'HomeController@viewStatistic')->name('viewStatistic');
Route::get('/dashboard/questions', 'HomeController@viewQuestions')->name('viewQuestions');
Route::get('/dashboard/mailer', 'HomeController@viewMailer')->name('viewMailer');
Route::get('/dashboard/payments', 'HomeController@viewPayments')->name('viewPayments');

/*POST*/
Route::post('/api/send-mail', 'Bot\Mail\MailController@sendMailToUsers')->name('sendMailToUsers');
