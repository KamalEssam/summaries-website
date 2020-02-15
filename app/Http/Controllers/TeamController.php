<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Team;
use App\Country;
use File;

class TeamController extends Controller
{
    
    protected $team;
    protected $country;

    public function __construct(Team $team, Country $country)
    {
        $this->team = $team;
        $this->country = $country;
        $this->middleware('auth');
    }

    public function index()
    {
        $teams = $this->team->orderBy('name','asc')->paginate(10);
        return view('team.index', compact('teams'));
    }

    public function create(){
        $countries = $this->country->all(); 
        return view('team.create', compact('countries'));
    }

    public function store(request $request){
        
        $this->validate($request,[
            'name'       => 'required|string|max:191',
            'logo'       => 'required|image',
            'country_id' => 'required|integer',
        ]);

        // UPLOAD NEW IMAGE
        $logo = time().'.'.$request->logo->getClientOriginalExtension();
        $request->logo->move('uploads/teams/', $logo);

        $created = $this->team->create([
            'name'       => $request->name,
            'logo'       => $logo,
            'country_id' => $request->country_id,
        ]);

        return redirect('/teams')->with(['success' => "تم أضافة الفريق"]);
    }

    public function edit($id){
        $team      = $this->team->find($id);
        $countries = $this->country->all(); 
        return view('team.edit', compact('team','countries'));
    }

    public function update(request $request, $id){
        
        $this->validate($request,[
            'name'       => 'required|string|max:191',
            'logo'       => 'image',
            'country_id' => 'required|integer',
        ]);
        
        $team = $this->team->find($id);
        $team->name       = $request->name;
        $team->country_id = $request->country_id;

        if($request->logo){
            // DELETE OLD IMAGE
    		$deleteOldImage = explode('/', $team->image);
            $deleteOldImage = end($deleteOldImage);
            File::delete('uploads/teams/'.$deleteOldImage);

            // UPLOAD NEW IMAGE
            $logo = time().'.'.$request->logo->getClientOriginalExtension();
            $request->logo->move('uploads/teams/', $logo);
	        $team->logo = $logo;
        }

        $team->save();

        return redirect('/teams')->with(['success' => "تم تعديل الفريق"]);
    }

    public function destroy($id){

        $deleted = $this->team->find($id)->delete();

        return redirect('/teams')->with(['success' => "تم حذف الفريق"]);
    }


}