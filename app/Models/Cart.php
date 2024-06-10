<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $table = 'cart';
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function variant(){
        return $this->hasOne(ProductsVariant::class , 'id' , 'product_variant_id');
    }
}
