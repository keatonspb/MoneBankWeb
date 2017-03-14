<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reason extends Model
{
    protected $fillable = [
        'name', 'type', 'user_id', 'parent_id'
    ];
}
