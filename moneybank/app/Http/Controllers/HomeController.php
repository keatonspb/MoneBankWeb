<?php

namespace App\Http\Controllers;

use App\Account;
use App\Reason;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Account = Account::getCurrentAccount();
        $reasons = Reason::whereNull('parent_id')->get();
        return view('home', [
            'Account'=>$Account,
            'reasons' => $reasons
        ]);
    }
}
