<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\File;
use App\Models\Part;
use App\Models\Trial;
use App\Models\Crime;
use Illuminate\Support\Facades\Auth;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function search(Request $request) 
    {
	if ($request->term == "")
	  return File::with('crimes')->get();

	//search by number
	$pieces_term = explode("/", $request->term);
	if (count($pieces_term) === 3) 
	{
	    $file = File::where('id', $pieces_term[0])->with('crimes')->get();
	    if (count($file)) 
	    {
		$date_pieces = explode("-", $file[0]->date_registered);
		if ($pieces_term[2] === $date_pieces[0])
		    return $file;
	    }
	}
	    
	//search by part name
	$files = File::whereHas('parts', function ($query) use($request) {
		     return $query->where('name', 'like', '%' . $request->term . '%');
		 })->with('crimes')->get();
	if (count($files))
	    return $files;

	//search by crime 
	return File::whereHas('crimes', function ($query) use($request) {
	    return $query->where('name', 'like', '%' . $request->term . '%');
	})->with('crimes')->get();
	
    }  


    public function index()
    {
        return view('files.index')
	       ->withFiles(File::orderBy('date_registered', 'DESC')
               ->with('crimes')->get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function data(Request $request)
    {
       return File::where('id', $request->id)->with('parts', 'crimes', 'trials.court')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $newFile = new File;
        $newFile->user_id = Auth::id();
        $newFile->date_registered = date('Y-m-d', strtotime($request->date));
        $newFile->save();
        
        foreach($request->parts as $part)
        {
            $newPart = new Part;
            $newPart->file_id = $newFile->id;
            $newPart->name = $part['name'];
            $newPart->type = $part['type'];
            $newPart->save();

        }
    
	$newFile->crimes()->attach($request->crimesIds);
        
        $newTrial = new Trial;
        $newTrial->court_id = $request->court_id;
        $newTrial->file_id = $newFile->id;
        $newTrial->type = "waiting";
        $newTrial->date = date('Y-m-d', strtotime($request->date));
        $newTrial->save();
        
        return redirect()->route('home');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
