<?php

namespace App\Http\Controllers\Admin\Matchday\FixtureManagement;

use DB;
use Exception;
use Carbon\Carbon;
use App\Models\Team\Player;
use App\Models\Team\Team;
use App\Models\Matchday\MatchDay;
use App\Models\Matchday\Fixture;
use Illuminate\Http\Request;
use App\Http\Controllers\EditorController;

class GoalScorerController extends EditorController {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request) {
        parent::__construct($request);
        $this->middleware('auth');
        $this->setPrimaryClass('App\Models\Matchday\FixtureManagement\Goal');
    }

    /**
     * Create a TeamSheet resource 
     *  
     * 
     * 
     * @param Request $request
     * @return type
     */
    public function add(Request $request, Fixture $fixture) {
        DB::beginTransaction();
        try {            
            foreach ($request->goal_scorers as $score) {                
                $class = $this->getPrimaryClass();
                $object = new $class();
                $object->player_id = $score['home_team_scorer'] > 0 ? $score['home_team_scorer'] : $score['away_team_scorer'];
                $object->team_id = $score['home_team_scorer'] > 0 && $score['own_goal'] == 'true' ? $fixture->away_team_id : $fixture->home_team_id;
                $object->fixture_id = $fixture->id;
                $object->goal_number = $score['number'];
                $object->own_goal = $score['own_goal'] == 'true' ? true : false;
                if (!$object->save()) {
                    throw new Exception('Failed to create the entry for Goal ' . $score['number']);
                }
            }
            DB::commit();
            flash()->success(count($request->goal_scorers) . " goal details successfully added to Fixture");
            return redirect()->route('admin.fixtures.management', [$fixture]);
        } catch (Exception $exc) {
            DB::rollback();
            //dd($exc->getMessage());
            flash()->error($exc->getMessage());
            return redirect()->route('admin.fixtures.management', [$fixture]);
        }
    }

    /**
     * Create a TeamSheet resource 
     *  
     * Validation:
     * Movement and Order Volume summed, mustn't exceed Vehicle Capacity!
     * 
     * @param Request $request
     * @return type
     */
    public function remove(Request $request, Fixture $fixture) {
        $class = $this->getPrimaryClass();
        DB::beginTransaction();
        try {
            $team = Team::find($request->team_id);
            if (is_null($team)) {
                throw new Exception("Failed to retrieve a Team linked to this Team Sheet");
            }
            $entries = $class::whereIn('player_id', $request->fixture_player_ids)->get();
            if (count($request->fixture_player_ids) != count($entries)) {
                throw new Exception("Invalid Entry count encountered, please try again");
            }
            foreach ($entries as $entry) {
                if (!$entry->delete()) {
                    throw new Exception('Failed to delete the entry'); //TODO This should be on create..if errors...
                }
            }
            DB::commit();
            flash()->success(count($entries) . " Players(s) successfully removed from the Team Sheet");
            return redirect()->route('admin.fixtures.management', [$fixture]);
        } catch (Exception $exc) {
            DB::rollback();
            //dd($exc->getMessage());
            flash()->error($exc->getMessage());
            return redirect()->route('admin.fixtures.management', [$fixture]);
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
        $query = $object::select(['fixture_goals.*', 'teams.name AS team', 'players.name AS player'])
                ->join('players', 'fixture_goals.player_id', '=', 'players.id')
                ->join('teams', 'fixture_goals.team_id', '=', 'teams.id');
        if ($request->has('fixture_id') && $request->fixture_id > 0) {
            $query->where('fixture_goals.fixture_id', $request->fixture_id);
        }
        if ($id > 0) {
            return $query->where('fixture_goals.id', $id)->first();
        }
        return $query->orderBy('fixture_goals.goal_number')->get();
    }

    protected function format($data): array {

        return [
            "fixture_goals" => [
                "id" => $data->id,
                "team_id" => $data->team_id,
                "player_id" => $data->player_id,
                "fixture_id" => $data->fixture_id,
                "goal_number" => $data->goal_number,
                "own_goal" => $data->own_goal ? 'Yes' : 'No',
            ],
            "players" => [
                "name" => $data->player
            ],
            "teams" => [
                "name" => $data->team
            ]
        ];
    }

    protected function setRules(array $rules = array()): array {
        
    }

}
