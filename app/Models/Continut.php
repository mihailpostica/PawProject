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
                            'titlu',
                            'descriere',
                            'user_id',
                            'verificat',
                            'stamp',
                            'categorie_id'
                        ];
    protected $appends =['avgRating'];
    protected $hidden = [
        'categorie_id',
        'stamp',
    ];
    /**
     * @var mixed
     */
    private $avgRating=0;

    public function getAvgRatingAttribute(){
    return $this->avgRating;
}
    public function setAvgRatingAttribute($value){
         $this->avgRating=$value;
    }
public function Utilizator(){
    return $this->belongsTo(User::Class,'user_id','id');
}
public function Categorie(){
    return $this->belongsTo(Categorii::class,'categorie_id','id');
}
    public function Ratings(){
        return $this->hasMany(Rating::class);
    }

}
