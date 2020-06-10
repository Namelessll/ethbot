<?php

namespace App\Http\Controllers\Bot\Mail;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class MailController extends Controller
{
    public function sendMailToUsers(Request $request) {

        Cookie::put('name', 'Fred', 60);
        sleep(155);
        return 1;
    }
}
