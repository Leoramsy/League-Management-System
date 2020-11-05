<?php

namespace App\Http\Controllers\Admin\Settings;

use Carbon\Carbon;
use App\Models\System\Season;
use App\Models\System\LeagueFormat;
use Illuminate\Http\Request;
use App\Http\Controllers\EditorController;

class LeagueController extends EditorController {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request) {
        parent::__construct($request);
        $this->middleware('auth');
        $this->setPrimaryClass('App\Models\System\League');
    }

    /**
     * Show the view for this controller
     * 
     * @return \Illuminate\Http\Response
     */
    public function view() {
        $page = 'Leagues';
        return view('admin.settings.leagues', compact('page'));
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
        $end_date = Carbon::createFromFormat('d/m/Y', $data['end_date'])->endOfDay();
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
        $query = $object::select(['leagues.*', 'league_formats.description AS league_format', 'seasons.description AS season'])
                ->join('seasons', 'leagues.season_id', '=', 'seasons.id')
                ->join('league_formats', 'leagues.league_format_id', '=', 'league_formats.id');
        if ($id > 0) {
            return $query->where('league_formats.id', $id)->first();
        }
        return $query->get();
    }

    protected function format($data): array {
        return [
            "leagues" => [
                "id" => $data->id,
                "description" => $data->description,
                "league_format_id" => $data->league_format_id,
                "season_id" => $data->season_id,
                "active" => $data->active,
                "start_date" => $data->start_date->format('d/m/Y'),
                "end_date" => $data->end_date->format('d/m/Y')
            ],
            "league_formats" => [
                "description" => $data->league_format,
            ],
            "seasons" => [
                "description" => $data->league_format,
            ]
        ];
    }

    protected function setRules(array $rules = array()): array {
        $format_list = createValidateList(LeagueFormat::all());
        $season_list = createValidateList(Season::where('active', TRUE)->get());
        $this->rules = [
            'leagues.description' => 'required|string|min:3',
            'leagues.league_format_id' => 'required|integer|in:' . $format_list,
            'leagues.season_id' => 'required|integer|in:' . $season_list,
            'leagues.active' => 'required|boolean',
            "leagues.start_date" => "required|date_format:d/m/Y",
            "leagues.end_date" => "required|date_format:d/m/Y|after_or_equal:leagues.start_date",
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
        $format_options = editorOptions(LeagueFormat::all(), ["value" => 0, "label" => "Select a League Format"]);
        $season_options = editorOptions(Season::where('active', TRUE)->orderBy('description')->get(), ["value" => 0, "label" => "Select a Season"]);
        return [
            'leagues.league_format_id' => $format_options,
            'leagues.season_id' => $season_options,
        ];
    }

}
