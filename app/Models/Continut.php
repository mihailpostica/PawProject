<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Continut extends Model implements Searchable
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
                            'categorii_id'
                        ];
    protected $appends =['avgRating'];
    protected $hidden = [
        'categorii_id',
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
        return $this->belongsTo(Categorii::class,'categorii_id','id');
    }
    public function Ratings(){
        return $this->hasMany(Rating::class);
    }

    public function getSearchResult(): SearchResult
    {
       // $url = route('members.show', $this->id);

        return new SearchResult($this, $this->titlu);
    }

}
