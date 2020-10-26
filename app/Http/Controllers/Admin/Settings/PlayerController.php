<?php

namespace App\Http\Controllers\Admin\Settings;

use DB;
use Exception;
use Carbon\Carbon;
use App\Models\Team\Team;
use App\Models\Team\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
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
     * if($request->hasFile('image')){
      $image = $request->file('image');
      $filename = time() . '.' . $image->getClientOriginalExtension();
      Image::make($image)->resize(300, 300)->save( storage_path('/uploads/' . $filename )
     * 
     * 
     * @return \Illuminate\Http\Response
     */
    public function image(Request $request) {
        try {
            if ($request->has('id')) {
                $class = $this->getPrimaryClass();
                $player = $class::findOrFail($request->id)->id;
            } else {
                $player = 0;
            }
            if ($request->hasFile('upload')) {
                //  Let's do everything here
                if ($request->file('upload')->isValid()) {
                    $request->validate([
                        'upload' => 'mimes:jpeg,png|max:1014',
                    ]);
                    $now = Carbon::now()->format('d_m_y_H_i_s');
                    $extension = $request->upload->extension();
                    $file_name = $now . "." . $extension;
                    $path = '/uploads/images/';
                    $request->upload->storeAs($path, $file_name);
                    return response()->json(['data' => [], 'files' => ['players' => [$player => ['filename' => $file_name,
                                            'web_path' => asset('storage/app') . $path]]]
                                , 'upload' => ['id' => $player]]);
                }
            } else {
                throw new Exception("Invalid image was encountered");
            }
        } catch (Exception $ex) {
            dd($ex->getMessage(), $ex->getLine());
            return response()->json(['error' => $ex->getMessage()]);
        }
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
        $teams = ($entry["team_players-many-count"] > 0 ? Arr::pluck($entry["team_players"], 'team_id') : []);
        $dob = Carbon::createFromFormat('d/m/Y', $data['date_of_birth'])->startOfDay();
        $object->fill($data);
        $object->date_of_birth = $dob;
        $object->image = null;
        if (!$object->save()) {
            $this->setError('Failed to create the entry');
        }
        $object->teams()->attach($teams, ['created_at' => $now, 'updated_at' => $now]);
        return $this->getRows($request, $object->id);
    }

    /**
     * Edit a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    protected function edit(Request $request) {
        $now = Carbon::now();
        $entries = $request->input('data');
        $entry = current($entries);
        $class = $this->getPrimaryClass();
        $object = $class::findOrFail($this->primary_key);
        $data = $this->data[$object->getTable()];
        $teams = ($entry["team_players-many-count"] > 0 ? Arr::pluck($entry["team_players"], 'team_id') : []);
        $dob = Carbon::createFromFormat('d/m/Y', $data['date_of_birth'])->startOfDay();
        $object->fill($data);
        $object->date_of_birth = $dob;
        $object->image = null;
        if (!$object->save()) {
            $this->setError('Failed to create the entry');
        }
        $object->teams()->sync($teams, ['updated_at' => $now]);
        return $this->getRows($request, $object->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id) {
        DB::beginTransaction();
        try {
            if ($object = $this->isValid()) {
                $object->teams()->detach();
                if (!$object->delete()) {
                    $this->setError('Failed to delete the entry'); //TODO This should be on create..if errors...
                }
            }
            ($this->hasErrors() ? DB::rollback() : DB::commit());
            return response()->json($this->output([]));
        } catch (Exception $ex) {
            DB::rollback();
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
        $query = $object::select(['players.*', 'positions.description AS position'])
                ->join('positions', 'players.position_id', '=', 'positions.id');
        if ($id > 0) {
            return $query->where('players.id', $id)->first();
        }
        return $query->get();
    }

    protected function format($data): array {
        $team_players = DB::table('team_players')->select('team_id')
                        ->where('player_id', $data->id)
                        ->get()->all(); //->pluck('country_location_id');
        return [
            "players" => [
                "id" => $data->id,
                "position_id" => $data->position_id,
                "name" => $data->name,
                "surname" => $data->surname,
                "nick_name" => $data->nick_name,
                "image" => $data->image,
                "contact_number" => $data->contact_number,
                "active" => $data->active,
                "date_of_birth" => $data->date_of_birth->format('d/m/Y')
            ],
            "positions" => [
                "description" => $data->position,
            ],
            "team_players[]" => $team_players,
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
        $team_options = editorOptions(Team::select('id', 'name AS description')->get(), ["value" => 0, "label" => "Select a Team"]);
        return [
            'players.position_id' => $position_options,
            'team_players[].team_id' => $team_options,
        ];
    }

}
