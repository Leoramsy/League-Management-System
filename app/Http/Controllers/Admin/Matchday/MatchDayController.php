<?php

namespace App\Http\Controllers\Admin\Matchday;

use Carbon\Carbon;
use App\Models\Team\Team;
use App\Models\System\Season;
use Illuminate\Http\Request;
use App\Http\Controllers\EditorController;

class MatchDayController extends EditorController {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request) {
        parent::__construct($request);
        $this->middleware('auth');
        $this->setPrimaryClass('App\Models\Matchday\MatchDay');
    }

    /**
     * Show the view for this controller
     * 
     * @return \Illuminate\Http\Response
     */
    public function view() {
        return view('admin.matchday.match_days');
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
        $date = Carbon::createFromFormat('d/m/Y', $data['date'])->startOfDay();
        $object->fill($data);
        $object->date = $date;        
        if (!$object->save()) {
            $this->setError('Failed to create the entry');
        }        
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
        $query = $object::select(['match_days.*', 'seasons.description AS season'])
                ->join('seasons', 'match_days.season_id', '=', 'seasons.id');
        if ($id > 0) {
            return $query->where('match_days.id', $id)->first();
        }
        return $query->get();
    }

    protected function format($data): array {
        return [
            "match_days" => [
                'id' => $data->id,
                'description' => $data->description,
                'season_id' => $data->season_id,
                'completed' => $data->completed,
                'date' => (is_null($data->date) ? null : $data->date->format('d/m/Y')),
            ],
            "seasons" => [
                "description" => $data->season,
            ]
        ];
    }

    protected function setRules(array $rules = array()): array {
        $season_list = createValidateList(Season::all());
        $this->rules = [
            'match_days.season_id' => 'required|integer|in:' . $season_list,
            "match_days.date" => "nullable|date_format:d/m/Y",
            "match_days.description" => "required|string|min:3",           
            "match_days.completed" => "required|boolean",
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
        return [
            'match_days.season_id' => $season_options,
        ];
    }

}
