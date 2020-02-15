<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Channel;

class ChannelController extends Controller
{
    
    protected $channel;

    public function __construct(Channel $channel)
    {
        $this->channel = $channel;
        $this->middleware('auth');
    }

    public function index()
    {
        $channels = $this->channel->orderBy('name','asc')->paginate(10);
        return view('channel.index', compact('channels'));
    }

    public function create(){
        return view('channel.create');
    }

    public function store(request $request){
        
        $this->validate($request,[
            'name' => 'required|string|max:191',
        ]);

        $created = $this->channel->create([
            'name' => $request->name,
        ]);

        return redirect('/channels')->with(['success' => "تم أضافة القناة"]);
    }

    public function edit($id){
        $channel = $this->channel->find($id);
        return view('channel.edit', compact('channel'));
    }

    public function update(request $request, $id){
        
        $this->validate($request,[
            'name' => 'required|string|max:191',
        ]);

        $updated = $this->channel->find($id)->update([
            'name' => $request->name,
        ]);

        return redirect('/channels')->with(['success' => "تم تعديل القناة"]);
    }

    public function destroy($id){

        $deleted = $this->channel->find($id)->delete();

        return redirect('/channels')->with(['success' => "تم حذف القناة"]);
    }


}