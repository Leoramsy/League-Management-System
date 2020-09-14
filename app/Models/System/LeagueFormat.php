<?php

namespace App\Models\System;

use Illuminate\Database\Eloquent\Model;

class LeagueFormat extends Model {

    /**
     * Constants for League Formats
     */
    const SEASON = 'season'; // full season
    const TOURNAMENT = 'tournament'; // normal tournament
    const KNOCK_OUT = 'knock_out';
    const ROUND_ROBIN = 'round_robin';
    const ELIMINATION = 'elimination';

    protected $table = "league_formats";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "description",
        "slug"
    ];

    /**
     * Is this model linked to any data that would break integrity if it were deleted
     * 
     * @return string
     */
    public function isLinked() {
        return false; //Could be updated to query portal links. For now, we simply return false for testing 02/07/2020
    }

}
