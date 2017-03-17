<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;



class Bill extends Model
{
    protected $fillable = [
        'type', 'account_id', 'user_id', 'reason_id','description', 'credit','value'
    ];
    const TYPE_EXPENSE = "expense";
    const TYPE_INCOME = "income";

    public static function addBill($type, $sum, $reason_id, $desc, $inCredit = false)
    {
        try {
            DB::beginTransaction();
            $Account = Account::getCurrentAccount();
            if ($type == self::TYPE_EXPENSE) {
                if ($inCredit) {
                    $Account->credit = $Account->credit + $sum;
                } else {
                    $Account->debit = $Account->debit - $sum;
                }
            } else {
                $Account->debit = $Account->debit + $sum;
            }
            $Account->save();
             $Bill = Bill::create([
                "value" => $sum,
                "type" => $type,
                "account_id" => $Account->id,
                "user_id" => Auth::user()->id,
                "reason_id" => $reason_id,
                "description" => $desc,
                "credit" => $inCredit
            ]);
            DB::commit();
            return $Bill;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function deleteBill() {
        try {
            DB::beginTransaction();
            $Account = Account::getCurrentAccount();
            if ($this->type == self::TYPE_EXPENSE) {
                if ($this->credit) {
                    $Account->credit = $Account->credit - $this->value;
                } else {
                    $Account->debit = $Account->debit + $this->value;
                }
            } else {
                $Account->debit = $Account->debit - $this->value;
            }
            $Account->save();
            $res = parent::delete();
            DB::commit();
            return $res;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

}
