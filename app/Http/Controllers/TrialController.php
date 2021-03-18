<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trial;
use App\Models\Court;
use DateTime;

class TrialController extends Controller
{

    public function courts(Request $request)
    {
        $courts = Court::where('active', true)->get();
        foreach($courts as $court)
        {
          $files_arr = array();
          $trials = Trial::where('type', '=', 'waiting')->where('date', '=', date('Y-m-d', strtotime($request->date)))
               ->where('court_id', '=', $court->id)->get();
          foreach($trials as $trial)
            array_push($files_arr, $trial->file);
          $court->files = $files_arr;
        }
        return $courts;
    }

    public function update(Request $request) 
    {
	$trial = Trial::find($request->id);
	$trial->type = $request->type;
	$trial->document = $request->document;
	$trial->solution = $request->solution;
	$trial->save();

	if ($request->type === 'continued') 
	{
	    $newTrial = new Trial;
	    $newTrial->court_id = $trial->court_id;
	    $newTrial->file_id = $trial->file_id;
	    $newTrial->type = 'waiting';
	    $newTrial->date = date('Y-m-d', strtotime($request->newtrial_date));
	    $newTrial->save();
        }
	
        return Trial::where('file_id', $trial->file_id)->with('court')->get();
    }
      
}
