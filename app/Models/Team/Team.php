<?php

namespace App\Models\Team;

use Illuminate\Database\Eloquent\Model;

class Team extends Model {

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
     * Is this model linked to any data that would break integrity if it were deleted
     * 
     * @return string
     */
    public function isLinked() {
        return false; //Could be updated to query portal links. For now, we simply return false for testing 02/07/2020
    }

}
