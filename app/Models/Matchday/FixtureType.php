<?php

namespace App\Models\Matchday;

use Illuminate\Database\Eloquent\Model;

class FixtureType extends Model {

    /**
     * Constants for Fixture Types
     */
    const GROUP_STAGES = 'group_stages';
    const ROUND_OF_16 = 'round_of_16';
    const ROUND_OF_32 = 'round_of_32';
    const QUARTER_FINALS = 'quarter_finals';
    const QUARTER_FINALS_FIRST_LEG = 'quarter_finals_second_leg';
    const QUARTER_FINALS_SECOND_LEG = 'quarter_finals_second_leg';
    const SEMI_FINALS = 'semi_finals';
    const SEMI_FINALS_FIRST_LEG = 'semi_finals_first_leg';
    const SEMI_FINALS_SECOND_LEG = 'semi_finals_second_leg';
    const FINALE = 'finale';

    protected $table = "fixture_types";

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
