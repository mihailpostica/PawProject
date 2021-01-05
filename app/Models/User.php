<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;


class User extends Authenticatable
{
    use HasFactory, Notifiable,HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nume',
        'username',
        'prenume',
        'imagine',
        'rol_id',
        'email',
        'password',
        'isActiv',
        'timestamp'

    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
        'rol',
        'email_verified_at',
        'password',
        'created_at',
        'updated_at',
        'rol_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function Continut(){
        return $this->hasMany(Continut::class,'id','idUtilizator');
    }

    public function rol(){
        return $this->belongsTo(Roluri::class);
    }

    public function setPasswordAttribute($parola){
        if(trim($parola)===""){
            return;
        }
        $this->attributes['password']=Hash::make($parola);

    }
    public function Categorii(){
        return $this->belongsToMany(Categorii::class,'categorii_user','user_id','categorii_id');
    }


}
