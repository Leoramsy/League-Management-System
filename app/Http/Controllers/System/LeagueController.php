<?php

namespace App\Http\Controllers;

use App\Models\League;
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
        $this->setPrimaryClass('App\Models\League');
    }

    protected function format($entry): array {
        
    }

    protected function setRules(array $rules = array()): array {
        
    }

}
