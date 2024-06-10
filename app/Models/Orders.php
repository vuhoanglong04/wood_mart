<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;
    protected $table = "orders";

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function shipping(){
        return $this->belongsTo(ShippingMethod::class);
    }
    public function payment(){
        return $this->belongsTo(PaymentType::class);
    }

}
