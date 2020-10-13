<?php

namespace App\Models\Matchday;

use Illuminate\Database\Eloquent\Model;

class Fixture extends Model {

    protected $table = "fixtures";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'match_day_id',
        'home_team_id',
        'away_team_id',
        'home_team_score',
        'away_team_score',
        'drawn_match',
        'completed',
        'postponed'
    ];
    
    
    protected $dates = ['kick_off'];
    
    /**
     * Is this model linked to any data that would break integrity if it were deleted
     * 
     * @return string
     */
    public function isLinked() {
        return false; //Could be updated to query portal links. For now, we simply return false for testing 02/07/2020
    }

}
