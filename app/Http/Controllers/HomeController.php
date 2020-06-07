<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function viewManagement() {
        return view('management');
    }

    public function viewStatistic() {
        return view('statistic');
    }

    public function viewQuestions() {
        return view('questions');
    }

    public function viewMailer() {
        return view('mailer');
    }

    public function viewPayments() {
        return view('payments');
    }

}
