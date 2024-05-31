<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Products extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'product_name',
        'price',
        'product_theme',
        'category_id',
        'product_description',
        'deleted_at',
        'created_at',
        'updated_at',
    ];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function variants(){
        return $this->hasMany(ProductsVariant::class , 'product_id' , 'id');
    }
}
