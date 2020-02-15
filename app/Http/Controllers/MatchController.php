<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Match;
use App\Team;
use App\Country;
use App\League;
use App\Channel;
use App\Commentator;
use File;

class MatchController extends Controller
{
    
    protected $match;
    protected $team;
    protected $country;
    protected $league;
    protected $channel;
    protected $commentator;

    public function __construct(Match $match, Team $team, Country $country, League $league,Channel $channel, Commentator $commentator)
    {
        $this->match   = $match;
        $this->team    = $team;
        $this->country = $country;
        $this->league  = $league;
        $this->channel = $channel;
        $this->commentator = $commentator;
        $this->middleware('auth');
    }

    public function index(request $request)
    {
        $matches = $this->match->orderBy('match_date','desc')->orderBy('match_time','desc');
        if($request->month){
            $matches = $matches->whereMonth('match_date', $request->month);
        }
        if($request->year){
            $matches = $matches->whereYear('match_date', $request->year);
        }
        $matches = $matches->paginate(10);
        return view('match.index', compact('matches'));
    }

    public function create()
    {
        $countries    = $this->country->orderBy('name','asc')->get(); 
        $leagues      = $this->league->orderBy('name','asc')->get(); 
        $channels     = $this->channel->orderBy('name','asc')->get(); 
        $commentators = $this->commentator->orderBy('name','asc')->get();
        return view('match.create', compact('countries','leagues','channels','commentators'));
    }

    public function store(request $request)
    {
        
        $this->validate($request,[
            'match_date'           => 'required|max:191',
            'match_time'           => 'required',
            'team_home_country_id' => 'required|integer',
            'team_home_id'         => 'required|integer',
            'team_home_result'     => 'nullable|integer',
            'team_away_country_id' => 'required|integer',
            'team_away_id'         => 'required|integer',
            'team_away_result'     => 'nullable|integer',
            'league_id'            => 'required|integer',
            'channel_id'           => 'required|integer',
            'commentator_id'       => 'required|integer',
            'live_stream_url'      => 'nullable|url',
            'summary_url'          => 'nullable|url',
            'goals_url'            => 'nullable|url',
        ]);

        $created = $this->match->create([
            'match_date'           => $request->match_date,
            'match_time'           => $request->match_time,
            'team_home_country_id' => $request->team_home_country_id,
            'team_home_id'         => $request->team_home_id,
            'team_home_result'     => $request->team_home_result,
            'team_away_country_id' => $request->team_away_country_id,
            'team_away_id'         => $request->team_away_id,
            'team_away_result'     => $request->team_away_result,
            'league_id'            => $request->league_id,
            'channel_id'           => $request->channel_id,
            'commentator_id'       => $request->commentator_id,
            'live_stream_url'      => $request->live_stream_url,
            'summary_url'          => $request->summary_url,
            'goals_url'            => $request->goals_url,
        ]);

        return redirect('/matches')->with(['success' => "تم أضافة مباراة"]);
    }

    public function edit($id){
        $match        = $this->match->find($id);
        $countries    = $this->country->orderBy('name','asc')->get(); 
        $leagues      = $this->league->orderBy('name','asc')->get(); 
        $channels     = $this->channel->orderBy('name','asc')->get(); 
        $commentators = $this->commentator->orderBy('name','asc')->get(); 
        $home_teams   = $this->team->where('country_id', $match->team_home_country_id)->orderBy('name','asc')->get(); 
        $away_teams   = $this->team->where('country_id', $match->team_away_country_id)->orderBy('name','asc')->get(); 
        return view('match.edit', compact('match','countries','leagues','channels','commentators','home_teams','away_teams'));
    }

    public function update(request $request, $id){
        
        $this->validate($request,[
            'match_date'           => 'required|max:191',
            'match_time'           => 'required',
            'team_home_country_id' => 'required|integer',
            'team_home_id'         => 'required|integer',
            'team_home_result'     => 'nullable|integer',
            'team_away_country_id' => 'required|integer',
            'team_away_id'         => 'required|integer',
            'team_away_result'     => 'nullable|integer',
            'league_id'            => 'required|integer',
            'channel_id'           => 'required|integer',
            'commentator_id'       => 'required|integer',
            'live_stream_url'      => 'nullable|url',
            'summary_url'          => 'nullable|url',
            'goals_url'            => 'nullable|url',
            'finished'             => 'nullable',
        ]);
        
        $match = $this->match->find($id)->update([
            'match_date'           => $request->match_date,
            'match_time'           => $request->match_time,
            'team_home_country_id' => $request->team_home_country_id,
            'team_home_id'         => $request->team_home_id,
            'team_home_result'     => $request->team_home_result,
            'team_away_country_id' => $request->team_away_country_id,
            'team_away_id'         => $request->team_away_id,
            'team_away_result'     => $request->team_away_result,
            'league_id'            => $request->league_id,
            'channel_id'           => $request->channel_id,
            'commentator_id'       => $request->commentator_id,
            'live_stream_url'      => $request->live_stream_url,
            'summary_url'          => $request->summary_url,
            'goals_url'            => $request->goals_url,
            'finished'             => $request->finished,
        ]);

        return redirect('/matches')->with(['success' => "تم تعديل المباراة"]);
    }

    public function destroy($id){

        $deleted = $this->match->find($id)->delete();

        return redirect('/matches')->with(['success' => "تم حذف المباراة"]);
    }


}