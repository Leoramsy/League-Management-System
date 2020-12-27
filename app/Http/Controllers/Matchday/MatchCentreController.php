<?php

namespace App\Http\Controllers\Matchday;

use App\Models\Team\Team;
use App\Models\System\League;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MatchCentreController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('guest');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $type) {
        $league_options = League::where('active', TRUE)->orderBy('description')->get();
        $leagues = selectTwoOptions($league_options);
        if (count($league_options) > 0) {
            $team_options = Team::select('teams.id', 'teams.name AS description')
                            ->join('league_teams', 'teams.id', 'league_teams.team_id')
                            ->where('league_teams.league_id', key($leagues))
                            ->orderBY('name')->get();
        } else {
            $team_options = [];
        }
        $teams = selectTwoOptions($team_options, "All Teams");
        if ($request->ajax()) {
            return response()->json(["data" => []]);
        }        
        return view('client.match_centre', compact('type', 'leagues', 'teams'));
    }    

}
