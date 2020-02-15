<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class League extends Model
{

    protected $fillable = [
        'name',
        'logo',
        'priority',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'priority',
    ];

    public function getLogoAttribute($value){
        return $value != NULL ? URL('/').'/uploads/leagues/'.$value : '' ;
    }

    public function matches(){
        return $this->hasMany(Match::class);
    }

}
