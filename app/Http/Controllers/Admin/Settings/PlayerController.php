<?php

namespace App\Http\Controllers\Admin\Settings;

use Carbon\Carbon;
use App\Models\Team\Team;
use App\Models\Team\Position;
use Illuminate\Http\Request;
use App\Http\Controllers\EditorController;

class PlayerController extends EditorController {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request) {
        parent::__construct($request);
        $this->middleware('auth');
        $this->setPrimaryClass('App\Models\Team\Player');
    }

    /**
     * Show the view for this controller
     * 
     * @return \Illuminate\Http\Response
     */
    public function view() {
        $page = 'Players';
        return view('admin.settings.players', compact('page'));
    }

    /**
     * Show the view for this controller
     * 
     * @return \Illuminate\Http\Response
     */
    public function image() {
        if ($request->hasFile('image')) {
            //  Let's do everything here
            if ($request->file('image')->isValid()) {
                //
                $validated = $request->validate([                    
                    'image' => 'mimes:jpeg,png|max:1014',
                ]);
                $extension = $request->image->extension();
                $request->image->storeAs('/public', $validated['name'] . "." . $extension);
                $url = Storage::url($validated['name'] . "." . $extension);
                $file = File::create([
                            'name' => $validated['name'],
                            'url' => $url,
                ]);
                Session::flash('success', "Success!");
                return \Redirect::back();
            }
        }
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
        $teams = ($data["team_players-many-count"] > 0 ? array_pluck($data["team_players"], 'team_id') : []);
        $file = $request->file('image');
        $extension = $file->getClientOriginalExtension(); // getting image extension
        $filename = time() . '.' . $extension;
        $file->move(app() . '/images/players/', $filename);
        $dob = Carbon::createFromFormat('d/m/Y', $data['start_date'])->startOfDay();
        $object->fill($data);
        $object->date_of_birth = $dob;
        $object->image = app() . '/images/players/' . $filename;
        if (!$object->save()) {
            $this->setError('Failed to create the entry');
        }
        $object->teams()->attach($teams);
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
        $query = $object::select(['players.*', 'positions.description AS position'])
                ->join('positions', 'players.position_id', '=', 'positions.id');
        if ($id > 0) {
            return $query->where('league_formats.id', $id)->first();
        }
        return $query->get();
    }

    protected function format($data): array {
        return [
            "players" => [
                "id" => $data->id,
                "position_id" => $data->position_id,
                "name" => $data->name,
                "surname" => $data->surname,
                "nick_name" => $data->nick_name,
                "image" => $data->image,
                "active" => $data->active,
                "date_of_birth" => $data->date_of_birth->format('d/m/Y')
            ],
            "position" => [
                "description" => $data->position,
            ]
        ];
    }

    protected function setRules(array $rules = array()): array {
        $position_list = createValidateList(Position::all());
        $this->rules = [
            'players.name' => 'required|string|min:3',
            'players.nick_name' => 'required|string|min:3',
            'players.surname' => 'sometimes|nullable|string|min:3',
            'players.position_id' => 'required|integer|in:' . $position_list,
            'players.active' => 'required|boolean',
            "players.date_of_birth" => "required|date_format:d/m/Y|before:today",
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
        $position_options = editorOptions(Position::all(), ["value" => 0, "label" => "Select a Position"]);
        $team_options = editorOptions(Team::all(), ["value" => 0, "label" => "Select a Team"]);
        return [
            'players.position_id' => $position_options,
            'team_players[].team_id' => $team_options,
        ];
    }

}
