<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    const OPEN = 'A';
    const FINISHED = 'F';
    const CANCEL = 'C';

    public static function getByAcronym($acronym){
        return self::where('acronym', $acronym)->first();
    }

}
