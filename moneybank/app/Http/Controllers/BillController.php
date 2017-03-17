<?php
/**
 * Created by PhpStorm.
 * User: Keaton
 * Date: 17.03.2017
 * Time: 16:32
 */

namespace App\Http\Controllers;


use App\Account;
use App\Bill;
use Illuminate\Http\Request;

class BillController extends InnerPageController
{
    public function index(Request $request) {
        $Account = Account::getCurrentAccount();
        $Bills = Bill::where("account_id", $Account->id);
        $Bills = $Bills->join('reasons', 'reason_id', '=', 'reasons.id')->select('bills.*', 'reasons.name as reason_name');
        $filter = [];
        if($request->get("start")) {
            $Date = new \DateTime($request->get("start"));
            $Bills = $Bills->where("created_at", ">=", $Date->format("Y-m-d"));
            $filter['start'] = $request->get("start");
        } else {
            $filter['start'] = "";
        }
        if($request->get("end")) {
            $Date = new \DateTime($request->get("end"));
            $Bills = $Bills->where("created_at", "<=", $Date->format("Y-m-d"));
            $filter['end'] = $request->get("end");
        } else {
            $filter['end'] = "";
        }
        if($request->get("type")) {
            $filter['type'] = $request->get("type");
            $Bills = $Bills->where("bills.type", "=", $request->get("type"));
        }

        $Expenses = clone $Bills;
        $Incomes = clone $Bills;

        $allSum = $Incomes->where("bills.type", "=", "income")->sum("value") - $Expenses->where("bills.type", "=", "expense")->sum("value");
        $bills = $Bills->orderBy("created_at", "DESC")->paginate(20);
        $bills->appends($filter);
        return view('bills', [
            'Account'=>$Account,
            'rows' => $bills,
            'allSum' =>$allSum,
            'filter' => $filter
        ]);
    }
}