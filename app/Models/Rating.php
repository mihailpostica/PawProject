<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;
    protected $table='rating';
    protected $fillable=[
        'user_id',
        'continut_id',
        'descriere',

        'rating'
    ];

    public function Utilizator(){
        return $this->belongsTo(User::Class,'user_id','id');
    }
    public function Continut(){
        return $this->belongsTo(Continut::class,'continut_id','id');
    }
}
