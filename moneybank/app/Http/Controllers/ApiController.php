<?php

namespace App\Http\Controllers;

use App\Account;
use App\Bill;
use App\CreditPay;
use App\Reason;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiController extends Controller
{
    public function __construct()
    {

    }


    public function index(Request $request, $method) {
        if(!Auth::user() && $method != "login") {
            abort(403, 'Unauthorized action.');
        }
        if(method_exists($this, $method)) {
            $json = ["success"=>true];
            try {
                $json['data'] = $this->$method($request);
            } catch (\Exception $e) {
                $json['success'] = false;
                $json['message'] = $e->getMessage();
            }
            return response()->json($json);
        } else {
            abort(404, 'Not found');
        }
    }

    public function login(Request $request) {
        Auth::login(User::find(1), true);
    }


    protected function reasons(Request $request) {
        $data = [];
        $reasons = new Reason();
        if($request->get("parent_id")) {
            $reasons = $reasons->where("parent_id", $request->get("parent_id"));
        }
        if($request->get("type")) {
            $reasons = $reasons->where("type", $request->get("type"));
        }
        $data = $reasons->get();
        return $data;
    }

    protected function bill(Request $request) {
        if(!$request->get("sum")) {
            throw new \Exception("Укажите сумму");
        }
        if(!$request->get("reason_id")) {
            throw new \Exception("Укажите причину затраты");
        }
        if(!$request->get("type")) {
            throw new \Exception("Не указан тип");
        }
        Bill::addBill($request->get("type"), $request->get("sum"), $request->get("sud_reason_id", $request->get("reason_id")), $request->get("description"), $request->get("credit", false));
        return true;
    }

    protected function credit_pay(Request $request) {
        CreditPay::pay($request->get("sum"));
    }

    protected function bill_info(Request $request) {
        if(!$request->get("id")) {
            throw new \Exception("Платеж не найден");
        }
        if(!$Bill = Bill::find($request->get("id"))) {
            throw new \Exception("Платеж не найден");
        }
        $Account = Account::getCurrentAccount();
        if($Bill->account_id != $Account->id) {
            throw new \Exception("Это не ваш платеж!");
        }
        $Reason = Reason::find($Bill->reason_id);
        $Bill['reason_name'] = $Reason->name;
        return $Bill;
    }

    protected function delete_bill(Request $request) {
        if(!$request->get("id")) {
            throw new \Exception("Платеж не найден");
        }
        if(!$Bill = Bill::find($request->get("id"))) {
            throw new \Exception("Платеж не найден");
        }
        $Account = Account::getCurrentAccount();
        if($Bill->account_id != $Account->id) {
            throw new \Exception("Это не ваш платеж!");
        }
        $Bill->deleteBill();

    }

    protected function bills(Request $request) {
        $Account = Account::getCurrentAccount();
        $Bills = Bill::where("account_id", $Account->id)->join('reasons', 'reason_id', '=', 'reasons.id')->select('bills.*', 'reasons.name as reason_name')->orderBy("created_at", "DESC");
        $Bills->limit(30);
        return ['list'=>$Bills->get(), 'credit' => round($Account->credit)];
    }

}
