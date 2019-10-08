<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models;

/**
 *
 * @author ZakS
 */
interface EditorInterface {

    /**
     * Sets the rules for this given model
     * 
     * @return array
     */
    public function setRules(array $rules = []);
    
     /**
     * Sets the rules for this given model
     * 
     * @return array
     */
    public function setMessages(array $message = []);

    /**
     * Create a query that will be used to fetch the relevant data
     * 
     * @return array
     */
    public function queryData();

    /**
     * Gets the data of this model formatted for use by DataTables
     * 
     * @return array
     */
    public function getData();

    /**
     * Checks to see if this model has-many models linked to it
     * i.e. is this models id being used as a foreign key
     * 
     * @return boolean
     */
    public function isLinked();
}
