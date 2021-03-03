<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\File;
use App\Models\Part;
use App\Models\Status;
use App\Models\Trial;
use Illuminate\Support\Facades\Auth;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return File::orderBy('date_registered', 'DESC')->get();
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        //var_dump(date('Y-m-d', strtotime($request->date)));

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
        
        $newStatus = new Status;
        $newStatus->type = 'waiting';
        $newStatus->save();

        
        $newTrial = new Trial;
        $newTrial->court_id = $request->court_id;
        $newTrial->file_id = $newFile->id;
        $newTrial->status_id = $newStatus->id;
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
