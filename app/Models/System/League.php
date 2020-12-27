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
    protected $fillable = ['season_id', 'league_format_id', 'description', 'active'];
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
     * Get the season that this league belongs to
     * 
     * @return Season
     */
    public function season() {
        return $this->belongsTo('App\Models\System\Season');
    }

    /**
     * Get the league format that this league belongs to
     * 
     * @return LeagueFormat
     */
    public function format() {
        return $this->belongsTo('App\Models\System\LeagueFormat');
    }

    /**
     * 
     * @return boolean
     */
    public function isLinked() {
        //return $this->clientPaymentRefunds()->count() > 0;
    }

}
