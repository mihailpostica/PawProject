<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Continut extends Model
{
    use HasFactory;
    protected $table = 'continut';
    protected $fillable=[
                            'data',
                            'categorie_id',
                            'titlu',
                            'descriere',
                            'user_id',
                            'verificat',
                            'stamp'
                        ];



public function utilizator(){
    return $this->belongsTo(User::class);
}


}
