<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trial;
use DateTime;

class TrialController extends Controller
{
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
	    $newTrial->date = (new DateTime(mt_rand(2021, 2030) . '-' . mt_rand(1, 12) . '-' . mt_rand(1, 31)))->format('Y-m-d');
	    $newTrial->save();
        }
	
        return Trial::where('file_id', $trial->file_id)->get();
    }
      
}
