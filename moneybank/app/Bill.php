<?php

namespace App;

use Faker\Provider\DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;



class Bill extends Model
{
    protected $fillable = [
        'type', 'account_id', 'user_id', 'reason_id','description', 'credit','value', 'lat', 'lng'
    ];
    const TYPE_EXPENSE = "expense";
    const TYPE_INCOME = "income";

    public static function addBill($type, $sum, $reason_id, $desc, $inCredit = false, $lat = null, $lng = null)
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
            $row = [
                "value" => $sum,
                "type" => $type,
                "account_id" => $Account->id,
                "user_id" => Auth::user()->id,
                "reason_id" => $reason_id,
                "description" => $desc,
                "credit" => $inCredit,
                "lat"=>$lat,
                "lng"=>$lng
            ];
             $Bill = Bill::create([
                "value" => $sum,
                "type" => $type,
                "account_id" => $Account->id,
                "user_id" => Auth::user()->id,
                "reason_id" => $reason_id,
                "description" => $desc,
                "credit" => $inCredit,
                 "lat"=>$lat,
                 "lng"=>$lng
            ]);
            DB::commit();
            return $Bill;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Попудярные затраты
     * @param int $limit
     */
    public static function getPopular($limit = 3) {
        $Date = new \DateTime("-1 month");
        $Bills = self::where("created_at", ">", $Date->format("Y-m-d H:i:s"))->groupBy(['reason_id', 'value']);
        $Bills->where("bills.type", self::TYPE_EXPENSE);
        $Bills->join('reasons', 'reason_id', '=', 'reasons.id');
        $Bills->select(["value", "name", "reason_id"]);
        $Bills->limit($limit);
        return $Bills->get();

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
