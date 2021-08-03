<?php

namespace App\Models\Matchday\FixtureManagement;

use Illuminate\Database\Eloquent\Model;

class Assist extends Model
{
    //
    /**
     * Is this model linked to any data that would break integrity if it were deleted
     * 
     * @return string
     */
    public function isLinked() {
        return false; //Could be updated to query portal links. For now, we simply return false for testing 02/07/2020
    }
}
