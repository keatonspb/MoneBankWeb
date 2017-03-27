<?php
namespace App\Console\Commands;

use App\Account;
use App\Bill;
use App\StatisticDaily;
use Illuminate\Console\Command;

/**
 * Created by PhpStorm.
 * User: default
 * Date: 26.03.2017
 * Time: 22:15
 */
class StatDaily extends Command
{
    protected $signature = 'dailystat:make';

    public function handle()
    {
        $Accounts = Account::all();

        foreach ($Accounts as $account) {
            $Date = new \DateTime();
            echo $Date->format("Y-m-d H:m:s");
            $row = [
                'date' => $Date->format("Y-m-d"),
                'debit' => $account->debit,
                'credit' => $account->credit,
                'income' => Bill::where("type", Bill::TYPE_INCOME)
                    ->whereBetween("created_at", [$Date->format("Y-m-d 00:00:00"), $Date->format("Y-m-d 23:59:59")])->sum("value"),
                'expense' => Bill::where("type", Bill::TYPE_EXPENSE)
                    ->whereBetween("created_at", [$Date->format("Y-m-d 00:00:00"), $Date->format("Y-m-d 23:59:59")])->sum("value")
            ];
            if ($stat = StatisticDaily::find($row['date'])) {
                $stat->fill($row);
                $stat->save();
            } else {
                StatisticDaily::create($row);
            }
        }
    }
}