<?php

namespace App\Models\Team;

use Illuminate\Database\Eloquent\Model;

class Player extends Model {

    protected $table = "players";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "name",
        "nick_name",
        "surname",
        "position_id",
        "date_of_birth",
        "image",
        "id_number",
        "home_ground",
        "active",
        "contact_number"
    ];
    
    
    protected $dates = ['date_of_birth'];

    /**
     * Get the Team that belong to this Player
     * 
     * @return Team
     */
    public function teams() {
        return $this->belongsToMany('App\Models\Team\Team', 'team_players', 'player_id', 'team_id');
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
