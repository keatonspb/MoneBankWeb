<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Bill extends Model
{
    public static function addBill( $type, $sum, $reason_id, $desc)
    {   try {
        Bill::create([
            "value"=>$sum,
            "type"=>$type,
            "reason_id"=>$reason_id,
            "description"=>$desc
        ]);
    } catch (\Exception $e) {

    }



    }
}
