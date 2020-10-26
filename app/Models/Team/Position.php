<?php

namespace App\Models\Team;

use Illuminate\Database\Eloquent\Model;

class Position extends Model {

    protected $table = "positions";

    const GOAL_KEEPER = 'goal_keeper';
    const LEFT_BACK = 'left_back';
    const CENTER_BACK = 'center_back';
    const RIGHT_BACK = 'right_back';
    const DEFENSIVE_MIDFIELDER = 'defensive_midfielder';
    const LEFT_MIDFIELDER = 'left_midfielder';
    const RIGHT_MIDFIELDER = 'right_midfielder';
    const ATTACKING_MIDFIELDER = 'attacking_midfielder';
    const STRIKER = 'striker';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "description",
        "slug",
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
