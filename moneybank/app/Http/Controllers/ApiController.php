<?php

namespace App\Http\Controllers;

use App\Account;
use App\Bill;
use App\CreditPay;
use App\Reason;
use App\StatisticDaily;
use Illuminate\Foundation\Auth\User;
use Illuminate\Foundation\Testing\HttpException;
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
                if($e->getCode() == 403) {
                    abort(403, 'Unauthorized action.');
                }
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
        $data['list'] = $reasons->get();
        if($request->get("with_popular")) {
            $data['popular_expenses'] = Bill::getPopular();
        }
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
        Bill::addBill($request->get("type"), $request->get("sum"), $request->get("sud_reason_id", $request->get("reason_id")), $request->get("description"), $request->get("credit", false),
            $request->get("lat", false), $request->get("lng", false));
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
            throw new \Exception("
             не найден");
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
        return ['list'=>$Bills->get(), 'credit' => round($Account->credit), 'debit' => round($Account->debit)];
    }

    /**
     * Ежедневная статистика
     * @param int $days
     * @return array
     */
    protected function dayly_stats($days = 30) {
        $stats = StatisticDaily::where("date", ">", (new \DateTime("-30 days"))->format("Y-m-d 00:00:00"))->get();
        $data = [
            "labels" => [],
            "datasets" => [

            ]
        ];
        $debit = [];
        $expense = [];
        foreach ($stats as $stat) {
            $data['labels'][] = $stat->date;
            $debit[] = $stat->debit;
            $expense[] = $stat->expense;
        }

        $data['datasets'][] = [
            "label" => "Затраты",
            "fill"=>false,
            "borderColor"=>"#bf5329",
            "backgroundColor" => "#bf5329",
            "data" => $expense
        ];
        $data['datasets'][] = [
            "label" => "Состояние счета",
            "fill"=>true,
            "borderColor"=>"#2ab27b",
            "backgroundColor"=>"rgba(42,178,123,0.5)",
            "data" => $debit
        ];
        return $data;
    }

}
