<?php

namespace App\Http\Controllers;

use App\Account;
use App\Bill;
use App\Reason;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends InnerPageController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */


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
            'reasons' => $reasons,
            'last_income' => Bill::where("bills.type", Bill::TYPE_INCOME)->join('reasons', 'reason_id', '=', 'reasons.id')
                ->select('bills.*', 'reasons.name as reason_name')->orderBy("created_at", "DESC")->limit(5)->get(),
            'last_expense' => Bill::where("bills.type", Bill::TYPE_EXPENSE)->join('reasons', 'reason_id', '=', 'reasons.id')
                ->select('bills.*', 'reasons.name as reason_name')->orderBy("created_at", "DESC")->limit(5)->get(),
            'last_week_expense' => Bill::where("bills.type", Bill::TYPE_EXPENSE)
                ->where("bills.created_at", ">", (new \DateTime("-1 week"))->format("Y-m-d 00:00:00"))
                ->whereNotNull("lat")
                ->join('reasons', 'reason_id', '=', 'reasons.id')
                ->select('bills.*', 'reasons.name as reason_name')->orderBy("created_at", "DESC")->get()
        ]);
    }
}
