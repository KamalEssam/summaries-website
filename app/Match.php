<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Match extends Model
{

    protected $fillable = [
        'match_date',
        'match_time',
        'team_home_country_id',
        'team_home_id',
        'team_home_result',
        'team_away_country_id',
        'team_away_id',
        'team_away_result',
        'league_id',
        'channel_id',
        'commentator_id',
        'live_stream_url',
        'summary_url',
        'goals_url',
        'finished',
    ];
    
    protected $with = [
        'team_home',
        'team_away',
        'channel',
        'commentator',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'team_home_id',
        'team_away_id',
        'league_id',
        'commentator_id',
        'channel_id',
    ];

    protected $attributes = [
        'finished' => 0,
    ];

    public function getFinishedAttribute($value){
        return $value == 1 ? true : false ;
    }

    public function team_home()
    {
        return $this->belongsTo(Team::class,'team_home_id','id');
    }

    public function team_away()
    {
        return $this->belongsTo(Team::class,'team_away_id','id');
    }

    public function league(){
        return $this->belongsTo(League::class);
    }

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    public function commentator()
    {
        return $this->belongsTo(Commentator::class);
    }


}
