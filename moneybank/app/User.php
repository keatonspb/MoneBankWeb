<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'account_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function createWithAccount($data) {
        $Account = Account::create([
            'debit'=>0,
            'credit'=>0
        ]);
        $data['account_id'] = $Account->id;
        $User = parent::create($data);
        return $User;
    }

    /**
     * Аккаунт пользователя
     *
     * @return Account
     */
    public function Account() {
        return Account::find($this->account_id);
    }
}
