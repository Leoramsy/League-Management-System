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

class TeamSheetController extends EditorController {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request) {
        parent::__construct($request);
        $this->middleware('auth');
        $this->setPrimaryClass('App\Models\Matchday\FixtureManagement\TeamSheet');
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
    public function add(Request $request, Fixture $fixture) {        
        DB::beginTransaction();
        try {
            $team = Team::find($request->team_id);
            if (is_null($team)) {
                throw new Exception("Failed to retrieve a Team linked to this Team Sheet");
            }
            $players = Player::whereIn('id', $request->player_ids)->get();
            if (count($request->player_ids) != count($players)) {
                throw new Exception("Invalid Player count encountered, please try again");
            }
            // TODO: Add validation to ensure that you can only add $league->matchday_players max
            foreach ($players as $player) {
                $class = $this->getPrimaryClass();
                $object = new $class();
                $object->player_id = $player->id;
                $object->team_id = $team->id;
                $object->fixture_id = $fixture->id;
                if (!$object->save()) {
                    throw new Exception('Failed to create the entry for Player ' . $player->name);
                }
            }
            DB::commit();
            flash()->success(count($players) . " Players(s) successfully added to Team Sheet");
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
        if ($request->has('team_sheet') && $request->team_sheet) {
            $object = $this->getPrimaryClass();
            $query = $object::select(['players.*', 'positions.description AS position'])
                    ->join('players', 'fixture_players.player_id', '=', 'players.id')
                    ->join('positions', 'players.position_id', '=', 'positions.id')
                    ->where('players.active', TRUE);
            if ($request->has('team_id') && $request->team_id > 0) {
                $query->where('fixture_players.team_id', $request->team_id);
            }
            if ($request->has('fixture_id') && $request->fixture_id > 0) {
                $query->where('fixture_players.fixture_id', $request->fixture_id);
            }            
            if ($id > 0) {
                return $query->where('players.id', $id)->first();
            }
            return $query->distinct('players.id')->get();
        } else {
            $query = Player::select(['players.*', 'positions.description AS position'])
                    ->join('positions', 'players.position_id', '=', 'positions.id')
                    ->join('team_players', 'players.id', '=', 'team_players.player_id')
                    ->where('players.active', TRUE);
            if ($request->has('team_id') && $request->team_id > 0) {
                $query->where('team_players.team_id', $request->team_id);
            }
            if ($request->has('fixture_id') && $request->fixture_id > 0) {
                $selected_players = DB::table('fixture_players')->select('player_id')
                        ->where('fixture_id', $request->fixture_id)
                        ->get();                
                $query->whereNotIn('players.id', $selected_players->pluck('player_id')->all());
            }
            if ($id > 0) {
                return $query->where('players.id', $id)->first();
            }
            return $query->distinct('players.id')->get();
        }
    }

    protected function format($data): array {

        return [
            "players" => [
                "id" => $data->id,
                "position_id" => $data->position_id,
                "name" => $data->name,
                "surname" => $data->surname,
                "nick_name" => $data->nick_name,
            ],
            "positions" => [
                "description" => $data->position,
            ]
        ];
    }

    protected function setRules(array $rules = array()): array {
        
    }

}
