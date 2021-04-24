<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Product extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'description', 'value', 'status_id'];

    /**
     * The name of the "created at" column.
     *
     * @var string|null
     */
    const CREATED_AT = null;

    /**
     * The name of the "updated at" column.
     *
     * @var string|null
     */
    const UPDATED_AT = null;

    //relationships

    public function oders(){
        return $this->belongsToMany(Order::class, 'product_by_orders', 'id', 'order_id', 'id');
    }

    public function status(){
        return $this->belongsTo(ProductStatus::class);
    }

}
