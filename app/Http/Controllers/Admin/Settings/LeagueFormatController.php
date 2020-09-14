<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Models\System\League;
use Illuminate\Http\Request;
use App\Http\Controllers\EditorController;

class LeagueFormatController extends EditorController {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request) {
        parent::__construct($request);
        $this->middleware('auth');
        $this->setPrimaryClass('App\Models\System\LeagueFormat');
    }

    /**
     * Show the view for this controller
     * 
     * @return \Illuminate\Http\Response
     */
    public function view() {
        $page = 'League Formats';
        return view('admin.settings.league_formats', compact('page'));
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
        $query = $object::select(['league_formats.*']);
        if ($id > 0) {
            return $query->where('league_formats.id', $id)->first();
        }
        return $query->get();
    }

    protected function format($data): array {
        return [
            "league_formats" => [
                "id" => $data->id,
                "description" => $data->description,
                "slug" => $data->slug
            ]
        ];
    }

    protected function setRules(array $rules = array()): array {
        $this->rules = [
            'league_formats.description' => 'required|string|min:3',
            'league_formats.slug' => 'required|string|min:3',
        ];
        if (count($rules) > 0) {
            $this->rules = array_merge($this->rules, $rules);
        }
        return $this->rules;
    }

}
