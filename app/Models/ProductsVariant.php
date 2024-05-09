<?php

namespace App\Models;

use App\Models\Colors;
use App\Models\Materials;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductsVariant extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table='products_variant';

    public function color()
    {
        return $this->belongsTo(Colors::class);
    }
    public function material()
    {
        return $this->belongsTo(Materials::class);
    }
}
