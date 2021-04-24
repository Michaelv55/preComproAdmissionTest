<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Order extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'client_id', 'seller_id', 'total', 'status_id', 'created_at'];

    /**
     * The name of the "created at" column.
     *
     * @var string|null
     */
    const CREATED_AT = 'created_at';

    /**
     * The name of the "updated at" column.
     *
     * @var string|null
     */
    const UPDATED_AT = null;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'id', 'int',
        'client_id' => 'int',
        'seller_id' => 'int',
        'total' => 'int',
        'status_id' => 'int',
        'created_at' => 'datetime',
    ];


    // Relationships

    public function client(){
        return $this->belongsTo(Client::class);
    }

    public function seller(){
        return $this->belongsTo(Seller::class);
    }

    public function status(){
        return $this->belongsTo(OrderStatus::class);
    }

    public function products(){
        return $this->hasMany(ProductByOrder::class, 'order_id', 'id');
    }

    //methods

    public function cancel(){
        return $this->update(['status_id'=>OrderStatus::getByAcronym(OrderStatus::CANCEL)->id]);
    }

    public function close(){
        return $this->update(['status_id'=>OrderStatus::getByAcronym(OrderStatus::FINISHED)->id]);
    }
}
