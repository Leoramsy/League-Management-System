<?php

namespace App\Http\Controllers\Admin\Matchday;

use Carbon\Carbon;
use App\Models\Team\Team;
use App\Models\System\Season;
use App\Models\Matchday\MatchDay;
use Illuminate\Http\Request;
use App\Http\Controllers\EditorController;

class FixtureController extends EditorController {

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
    public function view() {
        return view('admin.matchday.fixtures');
    }

    /**
     * Return a list of resource.
     * 
     * @param Request $request
     * @param int $id
     * @return mixed
     */
    protected function getRows(Request $request, $id = 0) {
        $object = $this->getPrimaryClass();
        $query = $object::select(['fixtures.*', 'away_team.name AS away_team', 'home_team.name AS home_team',
                    'match_days.description AS match_day', 'seasons.description AS season'])
                ->join('match_days', 'fixtures.match_day_id', '=', 'match_days.id')
                ->join('seasons', 'match_days.season_id', '=', 'seasons.id')
                ->join('teams AS home_team', 'fixtures.home_team_id', '=', 'home_team.id')
                ->join('teams AS away_team', 'fixtures.home_team_id', '=', 'away_team.id');
        if ($id > 0) {
            return $query->where('fixtures.id', $id)->first();
        }
        return $query->get();
    }

    protected function format($data): array {
        return [
            "fixtures" => [
                'id' => $data->id,
                'match_day_id' => $data->match_day_id,
                'home_team_id' => $data->home_team_id,
                'away_team_id' => $data->away_team_id,
                'home_team_score' => $data->home_team_score,
                'away_team_score' => $data->away_team_score,
                'drawn_match' => $data->drawn_match,
                'completed' => $data->completed,
                'postponed' => $data->postponed,
            ],
            "match_days" => [
                "description" => $data->match_day,
            ],
            "seasons" => [
                "description" => $data->season,
            ],
            "home_team" => [
                "name" => $data->home_team,
            ],
            "away_team" => [
                "name" => $data->away_team,
            ]
        ];
    }

    protected function setRules(array $rules = array()): array {
        $matchday_list = createValidateList(MatchDay::all());
        $team_list = createValidateList(Team::all());
        $this->rules = [
            'fixtures.match_day_id' => 'required|integer|in:' . $matchday_list,
            'fixtures.home_team_id' => 'required|integer|in:' . $team_list,
            "fixtures.away_team_id" => 'required|integer|in:' . $team_list,
            "fixtures.home_team_score" => "required|integer|min:0",
            "fixtures.drawn_match" => "required|boolean",
            "fixtures.away_team_score" => "required|integer|min:0",
            "fixtures.completed" => "required|boolean",
            "fixtures.postponed" => "required|boolean",
        ];
        if (count($rules) > 0) {
            $this->rules = array_merge($this->rules, $rules);
        }
        return $this->rules;
    }

    /**
     * @return \App\Http\Controllers\type|array
     */
    protected function getOptions() {
        $season_options = editorOptions(Season::all(), ["value" => 0, "label" => "Select a Season"]);
        $matchday_options = editorOptions([], ["value" => 0, "label" => "Select a Matchday"]);
        $home_options = editorOptions([], ["value" => 0, "label" => "Select a Home Team"]);
        $away_options = editorOptions([], ["value" => 0, "label" => "Select an Away Team"]);
        return [
            'fixtures.season_id' => $season_options,
            'fixtures.match_day_id' => $matchday_options,
            'fixtures.home_team_id' => $home_options,
            'fixtures.away_team_id' => $away_options,
        ];
    }

}
