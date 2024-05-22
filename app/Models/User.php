<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected $dates = ['deleted_at'];
    public function group()
    {
        return $this->belongsTo(Groups::class);
    }
    public function hasPermission($module , $action)
    {
        $permissions = json_decode(Auth::user()->group->permissions);
        if($permissions){
            for($i =0 ; $i<count($permissions->$module); $i++){
                if($permissions->$module[$i] == $action)return true;
            }
            return false;
        }else return false;
    }
    public function address(){
        return $this->hasMany(UserAddress::class);
    }
}
