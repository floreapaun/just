<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Court;
use App\Models\File;
use App\Models\Trial;

class CourtController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Court::where("active", true)->get();
    }

    public function new(Request $request) 
    {
        return Court::where([["active", true], ["id", "!=", $request->court_id]])->inRandomOrder()->first(); 
    }

    public function at_date(Request $request)
    {
 
	return Court::where('active', true)->with(['files' => function ($query) use($request) {
	           return $query->whereHas('trials', function ($query) use($request) {
		       return $query->where([['type', 'waiting'], ['date', date('Y-m-d', strtotime($request->date))]]);
		   })->with('crimes')->get();
	       }])->get();
    }

    public function random()
    {
        return Court::where("active", true)->inRandomOrder()->first(); 
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
        if (count(Court::where([['name', '=', $request->name], ['active', false]])->get()))
            return response()->json([
                'success' => false,
                'reason' => "inactive",
            ]);

        if (count(Court::where([['name', '=', $request->name], ['active', true]])->get()))
            return response()->json([
                'success' => false,
                'reason' => "active",
            ]);
        
        $newCourt = new Court;
        $newCourt->name = $request->name;
        $newCourt->judge = $request->judge;
        $newCourt->save();

        return response()->json([
            'success' => true,
        ]);
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
    public function entry(Request $request)
    {
       return Court::find($request->court_id); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        //if we get same name
        if (count(Court::where([['id', $request->court_id],
                                ['name', $request->name], 
                                ['active', true]])->get()))
        {
            //if we get same judge
            if (count(Court::where([['id', $request->court_id], 
                                    ['active', true], 
                                    ['judge', $request->judge]])->get()))
                return response()->json([
                    'success' => false,
                    'reason' => "same_values",
                ]);

            //otherwise update court judge
            else
            {
                $court = Court::find($request->court_id); 
                $court->judge = $request->judge;
                $court->save();
                return response()->json([
                    'success' => true,
                ]);
            }
        }
    
        else 
        {
            //if already there's an inactive court with this name
            if (count(Court::where([['name', $request->name], 
                                   ['active', false]])->get()))
                return response()->json([
                    'success' => false,
                    'reason' => "inactive",
                ]);

            //if already there's an active court with this name
            if (count(Court::where([['name', '=', $request->name], 
                                   ['active', true]])->get()))
                return response()->json([
                    'success' => false,
                    'reason' => "active",
                ]);

            $court = Court::find($request->court_id); 
            $court->name = $request->name;
            $court->judge = $request->judge;
            $court->save();

            return response()->json([
                'success' => true,
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //if the court has no trials 
        //remove it from database
        if (count (Trial::where('court_id', '=', $request->court_id)->get()) === 0)
        {
            Court::destroy($request->court_id);
            return response()->json([
                'success' => true,
            ]);
        }

        //otherwise update the trials which will happen in the future
        //assign new random court and set it inactive
        $newCourt = Court::where([['id', '!=', $request->court_id],
                                 ['active', true]])->inRandomOrder()->first(); 

        $trials = Trial::where([['court_id', '=', $request->court_id], 
                                ['type', '=', 'waiting'], 
                                ['date', '>', date('Y-m-d')]]);
        $trials->update(['court_id' => $newCourt->id]);  

        Court::find($request->court_id)->update(['active' => false]); 

        return response()->json([
            'success' => true,
        ]);
    }
}
