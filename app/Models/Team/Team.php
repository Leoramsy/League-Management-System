<?php

namespace App\Models\Team;

use Illuminate\Database\Eloquent\Model;

class Team extends Model {

    protected $table = "teams";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "name",
        "nick_name",
        "contact_person",
        "phone_number",
        "email",
        "home_color_id",
        "away_color_id",
        "home_ground",
        "active",
    ];

    /**
     * Get the Season that belong to this Season
     * 
     * @return Season
     */
    public function seasons() {
        return $this->belongsToMany('App\Models\System\Season', 'season_teams', 'team_id', 'season_id');
    }

    /**
     * Is this model linked to any data that would break integrity if it were deleted
     * 
     * @return string
     */
    public function isLinked() {
        return false; //Could be updated to query portal links. For now, we simply return false for testing 02/07/2020
    }

}
