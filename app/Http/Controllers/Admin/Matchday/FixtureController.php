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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    protected function create(Request $request) {
        $class = $this->getPrimaryClass();
        $object = new $class();
        $data = $this->data[$object->getTable()];
        $object->fill($data);
        $object->kick_off = (strlen($data['kick_off']) > 0 ? Carbon::createFromFormat('d/m/Y h:i a', $data['kick_off']) : null);
        if (!$object->save()) {
            $this->setError('Failed to create the entry');
        }
        return $this->getRows($request, $object->id);
    }

    /**
     * Update an existing item resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    protected function edit(Request $request) {
        $class = $this->getPrimaryClass();
        $object = $class::findOrFail($this->primary_key);
        $data = $this->data[$object->getTable()];
        $object->fill($data);
        if (isset($data['kick_off'])) {
            $object->kick_off = (strlen($data['kick_off']) > 0 ? Carbon::createFromFormat('d/m/Y h:i a', $data['kick_off']) : null);
        }
        if (!$object->save()) {
            $this->setError('Failed to save the entry');
        }
        return $this->getRows($request, $object->id);
    }

    public function data($season_id) {
        try {
            $season = Season::find($season_id);
            // get match days linked to this season
            $match_days = editorOptions(MatchDay::where('season_id', $season->id)->orderBy('description', 'ASC')->get(), ["value" => 0, "label" => "Select a Match Day"]);
            // get teams linked to this season
            $teams = editorOptions(Team::select('teams.id', 'teams.name AS description')
                            ->join('season_teams', 'teams.id', '=', 'season_teams.team_id')
                            ->where('season_teams.season_id', $season->id)
                            ->where('teams.active', TRUE)
                            ->orderBy('teams.name', 'ASC')
                            ->get(), ["value" => 0, "label" => "Select a Team"]);
            return response()->json(["matchday_options" => $match_days, "team_options" => $teams]);
        } catch (Exception $ex) {
            return response()->json(['error' => $ex->getMessage()]);
        }
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
                ->join('teams AS away_team', 'fixtures.away_team_id', '=', 'away_team.id');
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
                'kick_off' => (is_null($data->kick_off) ? 'Not Set' : $data->kick_off->format('d/m/Y H:i'))
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
            'fixtures.home_team_id' => 'required|integer|different:fixtures.away_team_id|in:' . $team_list,
            "fixtures.away_team_id" => 'required|integer|different:fixtures.home_team_id|in:' . $team_list,
            "fixtures.home_team_score" => "nullable|integer|min:0",
            "fixtures.drawn_match" => "required|boolean",
            "fixtures.away_team_score" => "nullable|integer|min:0",
            "fixtures.completed" => "required|boolean",
            "fixtures.postponed" => "required|boolean",
                //"fixtures.kick_off" => "nullable|date_format:d/m/Y h:mm A"
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
        $season_options = editorOptions(Season::where('active', TRUE)->orderBy('description')->get(), ["value" => 0, "label" => "Select a Season"]);
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
