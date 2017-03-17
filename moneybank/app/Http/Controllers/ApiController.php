<?php

namespace App\Http\Controllers;

use App\Account;
use App\Bill;
use App\CreditPay;
use App\Reason;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request, $method) {
        if(method_exists($this, $method)) {
            $json = ["success"=>true];
            try {
                $json['data'] = $this->$method($request);
            } catch (\Exception $e) {
                $json['success'] = false;
                $json['message'] = $e->getMessage();
            }
            return response()->json($json);
        }
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

}
