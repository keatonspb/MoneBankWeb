<?php
namespace App\Console\Commands;
use App\Account;
use App\Bill;
use App\Reason;
use App\StatisticDaily;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

/**
 * Created by PhpStorm.
 * User: default
 * Date: 26.03.2017
 * Time: 22:15
 */
class RatingRecalc extends Command
{
    protected $signature = 'rating:make';
    public function handle()
    {
        DB::table((new Reason())->getTable())->update(["rating"=>NULL]);
        $DateFrom = new \DateTime("-14 days");
        $expenses = Bill::where("created_at", ">=", $DateFrom->format("Y-m-d"));
        $expenses->leftJoin("reasons", 'reason_id', '=', 'reasons.id');
        $expenses->select("reason_id", DB::raw("COUNT(bills.id) as co"));
        $expenses->groupBy("reason_id");

        foreach ($expenses->get() as $expens) {
            $Reason = Reason::find($expens->reason_id);
            $Reason->rating = $expens->co;
            $Reason->save();
        }
    }
}