<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Commentator;

class CommentatorController extends Controller
{
    
    protected $commentator;

    public function __construct(Commentator $commentator)
    {
        $this->commentator = $commentator;
        $this->middleware('auth');
    }

    public function index()
    {
        $commentators = $this->commentator->orderBy('name','asc')->paginate(10);
        return view('commentator.index', compact('commentators'));
    }

    public function create(){
        return view('commentator.create');
    }

    public function store(request $request){
        
        $this->validate($request,[
            'name' => 'required|string|max:191',
        ]);

        $created = $this->commentator->create([
            'name' => $request->name,
        ]);

        return redirect('/commentators')->with(['success' => "تم أضافة المعلق"]);
    }

    public function edit($id){
        $commentator = $this->commentator->find($id);
        return view('commentator.edit', compact('commentator'));
    }

    public function update(request $request, $id){
        
        $this->validate($request,[
            'name' => 'required|string|max:191',
        ]);

        $updated = $this->commentator->find($id)->update([
            'name' => $request->name,
        ]);

        return redirect('/commentators')->with(['success' => "تم تعديل المعلق"]);
    }

    public function destroy($id){

        $deleted = $this->commentator->find($id)->delete();

        return redirect('/commentators')->with(['success' => "تم حذف المعلق"]);
    }


}