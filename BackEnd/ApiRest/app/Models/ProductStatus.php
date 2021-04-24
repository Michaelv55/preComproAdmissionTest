<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductStatus extends Model
{
    const EXIST = 'E';

    public function ifThere(){
        return $this->acronym == ProductStatus::EXIST;
    }
}
