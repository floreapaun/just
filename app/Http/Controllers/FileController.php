<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\File;
use App\Models\Part;
use App\Models\Trial;
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
	$files = array();

	//search by number
	$pieces_term = explode("/", $request->term);
	if (count($pieces_term) === 3) 
	{
	    $file = File::find($pieces_term[0]);
	    if ($file)
		$date_pieces = explode("-", $file->date_registered);
		if ($pieces_term[2] === $date_pieces[0])
		{
		    array_push($files, $file);
		    return $files;
		}
	}
	    
	//search by part name
	$parts = Part::where('name', 'like', '%' . $request->term . '%')->get();
	if ($parts->isNotEmpty())
	{
	    foreach ($parts as $part)
		if (!in_array($part->file, $files))
		    array_push($files, $part->file);
	  return $files;
	}

	//search by crime 
	$crime_files = File::where('crime', 'like', '%' . $request->term . '%')->get();
	if ($crime_files->isNotEmpty())
	  return $crime_files;
	
	return false;  
    }  


    public function index()
    {
        return view('files.index')
	       ->withFiles(File::orderBy('date_registered', 'DESC')
               ->get());
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
       return File::where('id', $request->id)->get();
    }

    public function parts(Request $request)
    {
       return File::find($request->id)->parts;
    }

    public function court(Request $request)
    {
       return File::find($request->id)->court;
    }

    public function trials(Request $request)
    {
       return Trial::where('file_id', $request->file_id)->get();
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
        $newFile->court_id = $request->court_id;
        $newFile->crime = $request->crime;
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
