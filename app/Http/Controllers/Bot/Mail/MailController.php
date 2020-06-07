<?php

namespace App\Http\Controllers\Bot\Mail;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MailController extends Controller
{
    public function sendMailToUsers(Request $request) {


        sleep(5);
        return 1;
    }
}
