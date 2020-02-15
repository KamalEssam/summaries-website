<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\League;

class MatchController extends Controller
{
    
    public function index(request $request)
    {
        $leagues = League::whereHas('matches', function($query) use($request) {
            $query->where('match_date', $request->date);
        })->with(['matches' => function($query) use($request) { 
            $query->where('match_date', $request->date);
            $query->orderBy('match_date','asc');
            $query->orderBy('match_time','asc');
        }])->orderBy('priority','ASC')->get();

        return response()->json(['date' => $leagues]);
    }

}
