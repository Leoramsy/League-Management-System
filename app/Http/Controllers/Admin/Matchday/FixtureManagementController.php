<?php

namespace App\Http\Controllers\Admin\Matchday;

use DB;
use Carbon\Carbon;
use App\Models\Team\Team;
use App\Models\System\League;
use App\Models\Matchday\MatchDay;
use App\Models\Matchday\FixtureType;
use App\Models\Matchday\FixtureManagement\TeamSheet;
use Illuminate\Http\Request;
use App\Http\Controllers\EditorController;

class FixtureManagementController extends EditorController {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request) {
        parent::__construct($request);
        $this->middleware('auth');
        $this->setPrimaryClass('App\Models\Matchday\Fixture');
    }

    /**
     * Show the view for this controller
     * 
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $fixture_id) {        
        $class = $this->getPrimaryClass();
        $fixture = $class::select(['fixtures.*', 'away_team.name AS away_team', 'home_team.name AS home_team', 'fixture_types.description AS fixture_type',
                    'match_days.description AS match_day', 'leagues.description AS league', 'leagues.id AS league_id'])
                ->join('match_days', 'fixtures.match_day_id', '=', 'match_days.id')
                ->join('leagues', 'match_days.league_id', '=', 'leagues.id')
                ->join('teams AS home_team', 'fixtures.home_team_id', '=', 'home_team.id')
                ->join('teams AS away_team', 'fixtures.away_team_id', '=', 'away_team.id')
                ->leftJoin('fixture_types', 'fixtures.fixture_type_id', '=', 'fixture_types.id')
                ->where('fixtures.id', $fixture_id)
                ->first();
        if (is_null($fixture)) {
            flash()->error("failed to retrieve the selected Fixture");
            return back();
        }
        $goals = $fixture->completed ? $fixture->home_team_score + $fixture->away_team_score : 0;
        $teams_options = Team::select('id', 'name AS description')->whereIn('id', [$fixture->home_team_id, $fixture->away_team_id])->get();
        $teams = selectTwoOptions($teams_options);
        $home_team_players = $away_team_players = [];
        if ($fixture->completed) {
            // get the team sheets here and populate team players
            $home_team_players = selectTwoOptions(TeamSheet::select('players.id', 'players.name AS description')
                            ->join('players', 'fixture_players.player_id', '=', 'players.id')
                            ->where('fixture_players.fixture_id', $fixture->id)
                            ->where('fixture_players.team_id', $fixture->home_team_id)
                            ->orderBy('players.name')
                            ->get()
                    , "Select Goal Scorer");
            $away_team_players = selectTwoOptions(TeamSheet::select('players.id', 'players.name AS description')
                            ->join('players', 'fixture_players.player_id', '=', 'players.id')
                            ->where('fixture_players.fixture_id', $fixture->id)
                            ->where('fixture_players.team_id', $fixture->away_team_id)
                            ->orderBy('players.name')
                            ->get()
                    , "Select Goal Scorer");
        }
        $has_goals = DB::table('fixture_goals')->select('player_id')->where('fixture_id', $fixture->id)->count();
        return view('admin.matchday.fixture_management.show', compact('fixture', 'teams', 'goals', 'home_team_players', 'away_team_players', 'has_goals'));
    }

    protected function format($entry): array {
        return [];
    }

    protected function setRules(array $rules = array()): array {
        return $rules;
    }

}
