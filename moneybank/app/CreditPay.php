<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CreditPay extends Model
{
    protected $fillable = [
        'value'
    ];

    /**
     * Платеж по кредиту
     * @param $sum
     * @return
     * @throws \Exception
     */
    public static function pay($sum) {
        try {
            DB::beginTransaction();
            $Account = Account::getCurrentAccount();
            $Account->credit = $Account->credit - $sum;
            $Account->save();
            $CreditPay = CreditPay::create([
                "value" => $sum,
            ]);
            DB::commit();
            return $CreditPay;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
