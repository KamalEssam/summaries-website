<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Country;
use App\Team;

class CountryController extends Controller
{
    
    protected $country;
    protected $team;

    public function __construct(Country $country, Team $team)
    {
        $this->country = $country;
        $this->team    = $team;
        $this->middleware('auth');
    }

    public function index()
    {
        $countries = $this->country->orderBy('name','asc')->paginate(10);
        return view('country.index', compact('countries'));
    }

    public function create(){
        return view('country.create');
    }

    public function store(request $request){
        
        $this->validate($request,[
            'name' => 'required|string|max:191',
        ]);

        $created = $this->country->create([
            'name' => $request->name,
        ]);

        return redirect('/countries')->with(['success' => "تم أضافة الدولة"]);
    }

    public function edit($id){
        $country = $this->country->find($id);
        return view('country.edit', compact('country'));
    }

    public function update(request $request, $id){
        
        $this->validate($request,[
            'name' => 'required|string|max:191',
        ]);

        $updated = $this->country->find($id)->update([
            'name' => $request->name,
        ]);

        return redirect('/countries')->with(['success' => "تم تعديل الدولة"]);
    }

    public function destroy($id){

        $deleted = $this->country->find($id)->delete();

        return redirect('/countries')->with(['success' => "تم حذف الدولة"]);
    }


    public function teams($countryId){
        $teams = $this->team->where('country_id', $countryId)->get();
        return $teams;
    }


}