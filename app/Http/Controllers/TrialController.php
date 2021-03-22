<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trial;
use App\Models\Court;
use App\Models\File;
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
            $newTrial->file_id = $trial->file_id;
            $newTrial->court_id = $request->court_id;
            $newTrial->type = 'waiting';
            $newTrial->date = date('Y-m-d', strtotime($request->newtrial_date));
            $newTrial->save();
        }
        
        return Trial::where('file_id', $trial->file_id)->with('court')->get();
    }
    
}
