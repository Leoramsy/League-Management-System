<?php

namespace App\Http\Controllers\Admin\Settings;

use DB;
use Exception;
use Carbon\Carbon;
use App\Models\Team\Color;
use Illuminate\Http\Request;
use App\Models\System\Season;
use Illuminate\Support\Arr;
use App\Http\Controllers\EditorController;

class TeamController extends EditorController {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request) {
        parent::__construct($request);
        $this->middleware('auth');
        $this->setPrimaryClass('App\Models\Team\Team');
    }

    /**
     * Show the view for this controller
     * 
     * @return \Illuminate\Http\Response
     */
    public function view() {
        $page = 'Teams';
        return view('admin.settings.teams', compact('page'));
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    protected function create(Request $request) {
        $now = Carbon::now();
        $class = $this->getPrimaryClass();
        $object = new $class();
        $data = $this->data[$object->getTable()];
        $entries = $request->input('data');
        $entry = current($entries);
        $seasons = ($entry["season_teams-many-count"] > 0 ? Arr::pluck($entry["season_teams"], 'season_id') : []);
        $object->fill($data);
        if (!$object->save()) {
            $this->setError('Failed to create the entry');
        }
        $object->seasons()->attach($seasons, ['created_at' => $now, 'updated_at' => $now]);
        return $this->getRows($request, $object->id);
    }

    /**
     * Update a newly resource in storage.
     * 
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    protected function edit(Request $request) {
        $now = Carbon::now();
        $class = $this->getPrimaryClass();
        $object = $class::findOrFail($this->primary_key);
        $data = $this->data[$object->getTable()];
        $entries = $request->input('data');
        $entry = current($entries);
        $seasons = ($entry["season_teams-many-count"] > 0 ? Arr::pluck($entry["season_teams"], 'season_id') : []);
        $object->fill($data);
        if (!$object->save()) {
            $this->setError('Failed to create the entry');
        }
        $object->seasons()->sync($seasons, ['updated_at' => $now]);
        return $this->getRows($request, $object->id);
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
        $query = $object::select(['teams.*']);
        if ($id > 0) {
            return $query->where('teams.id', $id)->first();
        }
        return $query->get();
    }

    /**
     * @return \App\Http\Controllers\type|array
     */
    protected function getOptions() {
        $color_options = editorOptions(Color::select('id', 'name AS description')->orderBy('name')->get(), ["value" => 0, "label" => "Select a Color"]);
        $season_options = editorOptions(Season::orderBy('description')->where('active', TRUE)->get(), ["value" => 0, "label" => "Select a Season"]);
        return [
            "teams.home_color_id" => $color_options,
            "teams.away_color_id" => $color_options,
            'season_teams[].season_id' => $season_options,
        ];
    }

    protected function format($data): array {
        $season_teams = DB::table('season_teams')->select('season_id')
                        ->where('team_id', $data->id)
                        ->get()->all(); //->pluck('country_location_id');
        return [
            "teams" => [
                "name" => $data->name,
                "nick_name" => $data->nick_name,
                "contact_person" => $data->contact_person,
                "phone_number" => $data->phone_number,
                "email" => $data->email,
                "home_color_id" => $data->home_color_id,
                "away_color_id" => $data->away_color_id,
                "home_ground" => $data->home_ground,
                "active" => $data->active
            ],
            "season_teams[]" => $season_teams,
        ];
    }

    protected function setRules(array $rules = array()): array {
        $this->rules = [
            'teams.name' => 'required|string|min:3',
            'teams.nick_name' => 'required|string|min:3',
            'teams.contact_person' => 'required|string|min:3',
            'teams.phone_number' => 'required|string|min:3',
            'teams.email' => 'required|email|min:3',
            'teams.away_color_id' => 'required|integer',
            'teams.away_color_id' => 'required|integer',
            'teams.home_ground' => 'required|string|min:3',
            'teams.active' => 'required|boolean',
        ];
        if (count($rules) > 0) {
            $this->rules = array_merge($this->rules, $rules);
        }
        return $this->rules;
    }

}
