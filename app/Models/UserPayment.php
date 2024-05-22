<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPayment extends Model
{
    use HasFactory;
    protected $table = 'user_payment';

    public function payment(){
        return $this->belongsTo(PaymentType::class);
    }
}
