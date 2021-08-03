<?php

namespace App\Http\Controllers\Admin\Matchday;

use Carbon\Carbon;
use App\Models\Team\Team;
use App\Models\System\League;
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
        $start_date = Carbon::createFromFormat('d/m/Y', $data['start_date'])->startOfDay();
        $end_date = Carbon::createFromFormat('d/m/Y', $data['end_date'])->startOfDay();
        $object->fill($data);
        $object->start_date = $start_date;
        $object->end_date = $end_date;
        if (!$object->save()) {
            $this->setError('Failed to create the entry');
        }
        return $this->getRows($request, $object->id);
    }

    /**
     * Update resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    protected function edit(Request $request) {
        $class = $this->getPrimaryClass();
        $object = $class::findOrFail($this->primary_key);
        $data = $this->data[$object->getTable()];
        $start_date = Carbon::createFromFormat('d/m/Y', $data['start_date'])->startOfDay();
        $end_date = Carbon::createFromFormat('d/m/Y', $data['end_date'])->startOfDay();
        $object->fill($data);
        $object->start_date = $start_date;
        $object->end_date = $end_date;
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
        $query = $object::select(['match_days.*', 'leagues.description AS league'])
                ->join('leagues', 'match_days.league_id', '=', 'leagues.id');
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
                'league_id' => $data->league_id,
                'completed' => $data->completed,
                'start_date' => (is_null($data->start_date) ? null : $data->start_date->format('d/m/Y')),
                'end_date' => (is_null($data->end_date) ? null : $data->end_date->format('d/m/Y')),
            ],
            "leagues" => [
                "description" => $data->league,
            ]
        ];
    }

    protected function setRules(array $rules = array()): array {
        $league_list = createValidateList(League::all());
        $this->rules = [
            'match_days.league_id' => 'required|integer|in:' . $league_list,
            "match_days.start_date" => "nullable|date_format:d/m/Y",
            "match_days.end_date" => "nullable|date_format:d/m/Y",
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
        $league_options = editorOptions(League::all(), ["value" => 0, "label" => "Select a League"]);
        return [
            'match_days.league_id' => $league_options,
        ];
    }

}
