<?php

namespace App\Models\System;

use Illuminate\Database\Eloquent\Model;

class Season extends Model {

    protected $table = "seasons";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "description",
        "active",
    ];
    protected $dates = ["start_date", "end_date"];

    /**
     * Gets the Seasons that belong to this league
     * 
     * @return Season
     */
    public function leagues() {
        return $this->hasMany('App\Models\System\League', 'id', 'season_id');
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
