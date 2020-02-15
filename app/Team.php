<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = [
        'name',
        'logo',
        'country_id',
    ];

    protected $with = [
        'country',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'country_id',
    ];

    public function getLogoAttribute($value)
    {
        return $value != NULL ? URL('/').'/uploads/teams/'.$value : '' ;
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
