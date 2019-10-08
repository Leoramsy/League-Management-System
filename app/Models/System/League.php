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
    protected $fillable = ['name', 'start_date', 'end_date','active'];

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
     * @return type
     */
    public function queryData() {
        return self;
    }

    /**
     * 
     * 
     * @return type
     */
    public function getData() {
                $data = ($this->getAction() == self::ACTION_READ ? $this : $this->queryData());
        return [
            $this->table => [
                "client_operating_unit_id" => $data->client_operating_unit_id,
                "billing_entity_id" => $data->billing_entity_id,
                "bank" => $data->bank,
                "name" => $data->name,
                "branch" => $data->branch,
                "account_name" => $data->account_name,
                "account_number" => $data->account_number,
                "branch_code" => $data->branch_code,
                "bank_code" => $data->bank_code,
                "for_invoice" => $data->for_invoice,                
            ]
        ];
    }

    public function setRules(array $rules = []) {       
        $this->rules = [            
            $this->table . '.name' => 'required|string|min:3',
            $this->table . '.branch' => 'nullable|string',
            $this->table . '.account_name' => 'required|string',
            $this->table . '.account_number' => 'required|string',
            $this->table . '.branch_code' => 'required|string',
            $this->table . '.bank_code' => 'required|string',
            $this->table . '.for_invoice' => 'required|boolean',            
        ];         
    }

    /**
     * 
     * @param type $messages
     */
    public function setMessages(array $messages = []) {
      $local_messages = [];
        $this->messages = [ 
            $this->table . '.client_operating_unit_id.in' => 'Please select a valid operating unit',
            $this->table . '.billing_entity_id.in' => 'Please select a valid billing entity',
            $this->table . '.bank.required' => 'Please enter the bank',
            $this->table . '.name.required' => 'Please enter the bank name',            
            $this->table . '.account_name.required' => 'Please enter bank account name',
            $this->table . '.account_number.required' => 'Please enter bank account number',
            $this->table . '.branch_code.required' => 'Please enter branch code',
            $this->table . '.bank_code.required' => 'Please enter bank code', 
            'min' => 'A minimum value of at least :min is required',
            'max' => 'A maximum value of at most :max is required',
        ];
        if (count($messages) > 0) {
            $this->messages = array_merge($this->messages, $messages, $local_messages);
        }  
    }

    /**
     * 
     * @return boolean
     */
    public function isLinked() {
        return $this->clientPaymentRefunds()->count() > 0;
    }
}
