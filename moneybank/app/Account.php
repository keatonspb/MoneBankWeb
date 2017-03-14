<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Account extends Model
{
    protected $fillable = [
        'debit', 'credit',
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
