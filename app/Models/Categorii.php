<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorii extends Model
{
    use HasFactory;

    protected $fillable=['nume'];

    public function Continut(){
        return $this->hasMany(Continut::class);
    }
}
