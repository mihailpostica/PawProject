<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Categorii extends Model implements Searchable
{
    use HasFactory;
    protected $table = 'categorii';
    protected $fillable=['nume'];

    public function Continut(){
        return $this->hasMany(Continut::class);
    }

    public function User(){
        return $this->belongsToMany(User::class);
}
    public function getSearchResult(): SearchResult
    {
        // $url = route('members.show', $this->id);

        return new SearchResult($this, $this->nume);
    }


}
