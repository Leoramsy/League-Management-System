<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Models\System\League;
use Illuminate\Http\Request;
use App\Http\Controllers\EditorController;

class SeasonController extends EditorController {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request) {
        parent::__construct($request);
        $this->middleware('auth');
        $this->setPrimaryClass('App\Models\System\Season');
    }

    /**
     * Show the view for this controller
     * 
     * @return \Illuminate\Http\Response
     */
    public function view() {
        $page = 'Seasons';
        return view('admin.settings.seasons', compact('page'));
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
        $query = $object::select(['seasons.*', 'leagues.description AS league_name'])
                ->join('leagues', 'seasons.league_id', '=', 'leagues.id');
        if ($id > 0) {
            return $query->where('seasons.id', $id)->first();
        }
        return $query->get();
    }

    /**
     * @return \App\Http\Controllers\type|array
     */
    protected function getOptions() {
        $league_options = editorOptions(League::orderBy('description')->get(), ["value" => 0, "label" => "Select a League"]);
        return [
            "seasons.league_id" => $league_options,
        ];
    }

    protected function format($data): array {
        return [
            "seasons" => [
                "id" => $data->id,
                "description" => $data->description,
                "start_date" => $data->start_date->format('d/m/Y'),
                "end_date" => $data->end_date->format('d/m/Y'),
                "active" => $data->active
            ],
            "leagues" => [
                "description" => $data->league_name
            ]
        ];
    }

    protected function setRules(array $rules = array()): array {
        $leagues = createValidateList(League::all());
        $this->rules = [
            'seasons.league_id' => 'required|integer|in:' . $leagues,
            'seasons.start_date' => 'required|date',
            'seasons.end_date' => 'required|date',
            'seasons.description' => 'required|string|min:3',
            'seasons.active' => 'required|boolean',
        ];
        if (count($rules) > 0) {
            $this->rules = array_merge($this->rules, $rules);
        }
        return $this->rules;
    }

}
