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
    ];

    /**
     * Get the Team that belong to this Player
     * 
     * @return Team
     */
    public function teams() {
        return $this->belongsToMany('App\Models\Team\Team', 'team_players', 'team_id', 'player_id');
    }

}
