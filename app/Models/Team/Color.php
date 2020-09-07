<?php

namespace App\Models\Team;

use Illuminate\Database\Eloquent\Model;

class Color extends Model {

    protected $table = 'team_colors';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "name",
        "color_code",
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
