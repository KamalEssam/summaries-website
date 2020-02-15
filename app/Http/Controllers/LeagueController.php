<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\League;
use File;

class LeagueController extends Controller
{
    
    protected $league;

    public function __construct(League $league)
    {
        $this->league = $league;
        $this->middleware('auth');
    }

    public function index()
    {
        $leagues = $this->league->orderBy('name','asc')->paginate(10);
        return view('league.index', compact('leagues'));
    }

    public function create(){
        return view('league.create');
    }

    public function store(request $request){
        
        $this->validate($request,[
            'name'     => 'required|string|max:191',
            'logo'     => 'required|image',
            'priority' => 'required|integer',
        ]);

        // UPLOAD NEW IMAGE
        $logo = time().'.'.$request->logo->getClientOriginalExtension();
        $request->logo->move('uploads/leagues/', $logo);

        $created = $this->league->create([
            'name'     => $request->name,
            'priority' => $request->priority,
            'logo'     => $logo,
        ]);

        return redirect('/leagues')->with(['success' => "تم أضافة البطولة"]);
    }

    public function edit($id){
        $league = $this->league->find($id);
        return view('league.edit', compact('league'));
    }

    public function update(request $request, $id){
        
        $this->validate($request,[
            'name'     => 'required|string|max:191',
            'priority' => 'required|integer',
        ]);
        
        $league = $this->league->find($id);
        $league->name     = $request->name;
        $league->priority = $request->priority;

        if($request->logo){
            // DELETE OLD IMAGE
    		$deleteOldImage = explode('/', $league->image);
            $deleteOldImage = end($deleteOldImage);
            File::delete('uploads/leagues/'.$deleteOldImage);

            // UPLOAD NEW IMAGE
            $logo = time().'.'.$request->logo->getClientOriginalExtension();
            $request->logo->move('uploads/leagues/', $logo);
	        $league->logo = $logo;
        }

        $league->save();

        return redirect('/leagues')->with(['success' => "تم تعديل البطولة"]);
    }

    public function destroy($id){

        $deleted = $this->league->find($id)->delete();

        return redirect('/leagues')->with(['success' => "تم حذف البطولة"]);
    }


}