<?php

namespace App\Http\Controllers\Matchday;

use App\MatchDay;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MatchCentreController extends Controller {
    
   /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $type) { 
        if ($request->ajax()){
            return response()->json(["data" => []]);
        }
        return view('client.match_centre', compact('type'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\MatchDay  $matchDay
     * @return \Illuminate\Http\Response
     */
    public function show(MatchDay $matchDay) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\MatchDay  $matchDay
     * @return \Illuminate\Http\Response
     */
    public function edit(MatchDay $matchDay) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\MatchDay  $matchDay
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MatchDay $matchDay) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\MatchDay  $matchDay
     * @return \Illuminate\Http\Response
     */
    public function destroy(MatchDay $matchDay) {
        //
    }

    /*
     * Get AJAX Data for Match Centre
     */

    public function getData(Request $request) {        
        dd($request);
        
    }

}
