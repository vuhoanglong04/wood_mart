<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class UserAddress extends Model
{
    use HasFactory , HasApiTokens;
    protected $table = 'user_address';
}
