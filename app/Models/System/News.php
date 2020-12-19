<?php

namespace App\Models\System;

use Illuminate\Database\Eloquent\Model;

class News extends Model {

    protected $table = "news";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "title",
        "content",
        "featured",
        "active",
    ];
    protected $dates = ["published_date"];    

    /**
     * Is this model linked to any data that would break integrity if it were deleted
     * 
     * @return string
     */
    public function isLinked() {
        return false; //Could be updated to query portal links. For now, we simply return false for testing 02/07/2020
    }

}
