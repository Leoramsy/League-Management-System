<?php

namespace App\Models\System;

use Illuminate\Database\Eloquent\Model;

class League extends Model {

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'leagues';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['league_format_id', 'description', 'active'];
    
    
    protected $date = ['start_date', 'end_date'];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     *
     * @var type 
     */
    protected $dates = ['start_date', 'end_date'];

    /**
     * Gets the Seasons that belong to this league
     * 
     * @return Season
     */
    public function seasons() {
        return $this->hasMany('App\Models\System\Season', 'league_id', 'id');
    }

    /**
     * 
     * @return boolean
     */
    public function isLinked() {
        //return $this->clientPaymentRefunds()->count() > 0;
    }

}
