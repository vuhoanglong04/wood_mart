<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;
    protected $table = 'order_detail';
    public function product(){
        return $this->belongsTo(Products::class);
    }
    public function color(){
        return $this->belongsTo(Colors::class);
    }
    public function material(){
        return $this->belongsTo(Materials::class);
    }

}
