<?php

namespace App\Models\Matchday\FixtureManagement;

use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    protected $table = "fixture_goals";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'team_id',
        'fixture_id',
        'player_id',
        'goal_number',
        'own_goal',
    ];
    protected $dates = [];

    /**
     * Is this model linked to any data that would break integrity if it were deleted
     * 
     * @return string
     */
    public function isLinked() {
        return false; //Could be updated to query portal links. For now, we simply return false for testing 02/07/2020
    }
}
