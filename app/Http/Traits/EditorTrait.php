<?php

namespace App\Http\Traits;

use DB;
use Exception;
use Validator;
use Carbon\Carbon;

trait EditorTrait {

    /**
     * The current action taking place
     * 
     * @var type 
     */
    protected $action = self::ACTION_READ;

    /**
     * The validator instance for this model
     * Initiated when isValid() is invoked.
     */
    protected $v = null;

    /**
     * The rules to create
     * 
     * @var array
     */
    protected $rules = [];

    /**
     * The messages that are applied to each validation check
     * These are generic messages applied to the checks,
     * more specific messages can be applied in each Model.
     * 
     * @var array 
     */
    protected $messages = [
        'required' => 'This field is required',
        'in' => 'The selected option does not match our records',
        'min' => 'A minimum value of at least :min is required',
    ];

    /**
     * If an error occurred
     * 
     * @var type 
     */
    protected $error = "";

    /**
     * If multiple errors occur
     * 
     * @var array
     */
    protected $fieldErrors = [];

    /**
     * Fields that shouldn't be included in the fieldErrors response, as they aren't shown on the <form>
     * 
     * @var array
     */
    protected $excludeFields = [];

    /**
     * Fields that aren't apart of the database, but need to be filled in for validation purposes (i.e. confirmation password for users)
     * 
     * @var array
     */
    protected $includeFields = [];

    /**
     * A combination of $excludeFields and $includeFields
     * Allows inputs in the Editor <form> to show fieldErrors from other fields that aren't shown in the <form>
     * 
     * @var array
     */
    protected $mappedFields = [];

    /**
     * The "booting" method of the model.
     * 
     * @return void 
     */
    protected static function boot() {
        parent::boot();
    }

    /**
     * && strlen($value) > 0 (When using 'sometimes' validation, this would still set the value and it would fail as it's present in the model)
     * 
     * @param array $data
     */
    public function setData(array $data) {
        foreach ($data AS $key => $value) {
            //Prevents 'mass assigning' on key fields!
            if (is_string($key) && in_array($key, $this->fillable)) {
                $this->$key = $this->formatData($key, $value);
            }
        }
    }

    private function formatData($key, $value) {
        switch (true) {
            case (in_array($key, $this->dates)): // && !$key instanceof Carbon
                $value = (($value instanceof Carbon) ? $value : Carbon::createFromFormat('d/m/yy', $value)); //->startOfDay();
                break;
        }
        return $value;
    }

    /**
     * Validates the incoming data against the models rules
     * TODO: Look into the Validator->mergeRules() method
     * @return boolean
     */
    public function isValid() {
        if ($this->getAction() != self::ACTION_REMOVE) {
            $this->initRules();
            $this->initMessages();
            $data = $this->getValidationData();
            $this->v = Validator::make($data, $this->getRules(), $this->getMessages()); //$this->complex(); //Removed, as the laravel function for making complex 'sometimes' rule wasn't working.
            if ($this->v->fails()) {
                $messages = $this->v->messages();
                foreach (array_keys($this->rules) as $key) {
                    $fieldError = $this->getValidationError($key, $messages->first($key));
                    if (count($fieldError) > 0) {
                        array_push($this->fieldErrors, $fieldError); //['name' => $this->table . '.' . $mappedField, 'status' => $message]
                    }
                }
                return false;
            }
        }
        return true;
    }

    /**
     * 
     */
    public function complex() {
        //blank...to be overwritten
    }

    /**
     * 
     * @param type $type
     * @return type
     */
    public function getJSON() {
        if ($this->hasError()) {
            return ['error' => $this->getError()];
        } if ($this->hasFieldErrors()) {
            return ['fieldErrors' => $this->getFieldErrors()];
        }
        return ["data" => [$this->process()]];
    }

    /**
     * Returns row information for this model
     * 
     * @return type
     */
    public function process() {
        return array_merge(["DT_RowId" => "row_" . $this->id], $this->getData());
    }

    /**
     * Check to see if this model has any errors
     * 
     * @return type
     */
    public function hasErrors() {
        return ($this->hasFieldErrors() || $this->hasError());
    }

    /**
     * Check to see if this model has an error
     * 
     * @return type
     */
    public function hasError() {
        return (strlen($this->error) > 0);
    }

    /**
     * Check to see if this model has any field errors
     * 
     * @return type
     */
    public function hasFieldErrors() {
        return(count($this->fieldErrors) > 0);
    }

    /**
     * 
     * @param string $error
     */
    public function setError($error) {
        $this->error = $error;
    }

    /**
     * 
     * @param string $includeFields
     */
    public function setIncludedFields($includeFields) {
        $this->includeFields = array_merge($this->includeFields, $includeFields);
    }

    /**
     * 
     * @param array $excludedFields
     */
    public function setExcludedFields($excludedFields) {
        $this->excludeFields = $excludedFields;
    }

    /**
     * Automatically takes mapped fields and excludes them
     * 
     * @param string $mappedFields
     */
    public function setMappedFields($mappedFields) {
        $excludeFields = [];
        foreach ($mappedFields AS $key => $arrayFields) {
            $excludeFields = array_merge($excludeFields, $arrayFields);
            //foreach ($arrayFields AS $excludeField) {
            //$excludeFields[] = $excludeField;
            //}
        }
        $this->setExcludedFields($excludeFields);
        $this->mappedFields = array_merge($this->mappedFields, $mappedFields);
    }

    /**
     * 
     * @param type $fieldErrors
     */
    public function setFieldErrors($fieldErrors) {
        $this->fieldErrors = $fieldErrors;
    }

    /**
     * 
     * @return string
     */
    public function getIncludedFields($key = null) {
        return (is_null($key) ? $this->includeFields : $this->includeFields[$key]);
    }

    /**
     * 
     * @return string
     */
    public function getMappedFields() {
        return $this->mappedFields;
    }

    /**
     * 
     * @return string
     */
    public function getError() {
        return $this->error;
    }

    /**
     * 
     * @return array
     */
    public function getFieldErrors() {
        return $this->fieldErrors;
    }

    /**
     * @return array
     */
    public function getExcludedFields() {
        return $this->excludeFields;
    }

    /**
     * 
     * @return array
     */
    public function getRules() {
        return $this->rules;
    }

    /**
     * 
     * @return array
     */
    public function getMessages() {
        return $this->messages;
    }

    /**
     * 
     * @param type $key
     * @param type $value
     * @param type $append
     */
    public function setRule($key, $value, $append = false) {
        if ($append && key_exists($key, $this->rules)) {
            $this->rules[$key] .= "|" . $value;
        } else {
            $this->rules[$key] = $value;
        }
    }

    /**
     * 
     * @param string $action
     */
    public function setAction($action = self::ACTION_READ) {
        $this->action = $action;
    }

    /**
     * 
     * @return string
     */
    public function getAction() {
        return $this->action;
    }

    /**
     * Initiate the rules to be used in validation
     * Exclude any unwanted fields for a particular scenario
     */
    public function initRules() {
        if (count($this->getRules()) == 0) {
            $this->setRules();
        }
    }

    /**
     * 
     */
    public function initMessages() {
        $this->setMessages();
    }

    /**
     * Each field must contain at least one '.', set by the getValidationData() method.
     * Field is split up and mapped if required
     * 
     * @param type $key
     * @param type $message
     * @return type
     */
    private function getValidationError($key, $message) {
        if (strlen($message) == 0 || (strpos($key, '.') === false && !in_array($key, $this->getExcludedFields()))) {
            return [];
        }
        $fieldArray = explode('.', $key); //$field = substr($key, (strpos($key, '.') + 1));
        $field = (count($fieldArray) == 3 ? head($fieldArray) . "[]." . end($fieldArray) : head($fieldArray) . "." . end($fieldArray));
        if (!in_array($key, $this->getExcludedFields()) && !in_array(end($fieldArray), $this->getExcludedFields())) { //Key hasn't been Mapped or Excluded so we can return this error
            return ['name' => $field, 'status' => $message];
        }
        if (count($this->mappedFields) > 0) {
            foreach ($this->mappedFields AS $editorField => $mappedField) {
                if (in_array($key, $mappedField) || in_array(end($fieldArray), $mappedField)) { //$key might already be linked to a table, and sometimes our mappedField not include the table. So we check both ways.
                    //Mapped field has been used once, we don't want multiple errors in the $fieldError Array linked to the same field
                    unset($this->mappedFields[$editorField]);
                    return ['name' => (strpos($editorField, '.') !== false ? $editorField : $this->table . '.' . $editorField), 'status' => $message];
                }
            }
        }
    }

    /**
     * 
     * @return array
     */
    private function getValidationData() {
        $data = [$this->table => $this->toArray()];
        if (count($this->getIncludedFields()) == 0) {
            return $data;
        }
        foreach ($this->getIncludedFields() AS $field => $value) {
            if (strpos($field, '*') !== false) { //Special occasion, an array is involved, meaning there will be 3 '.'
                $tableField = explode('.', $field);
                $fieldArray = [];
                foreach ($value AS $k => $v) {
                    array_push($fieldArray, [end($tableField) => $v]);
                }
                if (isset($data[head($tableField)])) {
                    array_push($data[head($tableField)], $fieldArray);
                } else {
                    $data[head($tableField)] = $fieldArray;
                }
            } else if (strpos($field, '.') !== false) { //this field has been seperated by a '.', meaning there is a table name involved
                $tableField = explode('.', $field);
                if (isset($data[head($tableField)])) { //Table key has already been set, so add onto this array
                    $data[head($tableField)][end($tableField)] = $value;
                } else { //Else it hasn't, therefore set it for the first time!
                    $data[head($tableField)] = [end($tableField) => $value];
                }
            } else { //no table has been defined, so we set it to the default model table
                $data[$this->table] = [$field => $value];
            }
        }
        return $data;
    }

}
