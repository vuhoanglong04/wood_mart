<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Topics extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'topics';
    public function parent_topic_name(){
        return $this->belongsTo(Topics::class);
    }
}
