<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class StatisticDaily extends Model
{
    protected $table = "statistic_daily";
    public $timestamps = false;
    protected $fillable = [
        'date', 'debit', 'credit', 'income', 'expense'
    ];

    /**
     * Аккаунт текущего пользователя
     * @return Account
     */
    public static function getCurrentAccount()
    {
        return Auth::user()->Account();
    }
}
