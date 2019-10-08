<?php

use Carbon\Carbon;

/*
 * A helper file, creating global functions to assist in common goals
 * 
 * https://laracasts.com/discuss/channels/general-discussion/best-practices-for-custom-helpers-on-laravel-5
 */

/**
 * 
 * @param type $row_id
 * @return type
 */
function formatRowID($row_id) {
    $id = null;
    switch (true) {
        case (is_numeric($row_id)):
            $id = $row_id;
            break;
        case (is_array($row_id)):
            $id = explode(',', $row_id);
            break;
        case (str_contains($row_id, ',')):
            $row_ids = explode(',', $row_id);
            $id = array_map(function($row_id) {
                return substr($row_id, 4);
            }, $row_ids);
            break;
        case (is_string($row_id)):
            $id = substr($row_id, 4);
            break;
    }
    return $id;
}

/**
 * Helper method to create lists for the in: validation
 * 
 * @param collection $query_results
 * @param boolean - return an array of ids or string
 * @return type
 */
function createValidateList($query_results, $array = false) {
    $list = ($array ? [] : "");
    foreach ($query_results as $key => $query_result) {
        ($array ? array_push($list, $query_result->id) : $list .= ($key == count($query_results) - 1 ? $query_result->id : $query_result->id . ", "));
    }
    return $list;
}

/**
 * TODO: Tweak this method to enable it to return select2 for Editor or Select2
 *  -> i.e. value vs id && label vs text
 * This method is not currently being used, but will be in the future once code is refactored
 * 
 * @return type
 */
function editorOptions($results, array $default = null, $key = "value", $value = "label", array $extras = []) {
    $options = [];
    if (!is_null($default)) {
        $options[] = $default;
    }
    foreach ($results AS $result) {
        $option = [(is_null($key) ? "value" : $key) => $result->id, (is_null($value) ? "label" : $value) => $result->description];
        if (count($extras) > 0) {
            $attributes = [];
            foreach ($extras AS $k => $v) {
                //$option['data-' . $k] = $result->$v;
                if (is_null($result->$v)) {
                    $attributes[$k] = $v;
                } else {
                    $attributes['data-' . $k] = $result->$v;
                }
            }
            $option['attr'] = $attributes;
        }
        $options[] = $option;
    }
    return $options;
}

/**
 *  
 * @return type
 */
function normalOptions($results = null, array $default = null, $key = "value", $value = "label") { //, $key = 'id', $value = 'description'
    $options = [];
    if (!is_null($default)) {
        $options[] = $default;
    }
    foreach ($results AS $result) {
        $options[] = [$key => $result->id, $value => $result->description];
        //$options[$result->$key] = $result->$value;
    }
    return $options;
}

function normalGroupOptions($collection, $first_option = null, $title = 'select_group', $key = 'id', $value = 'description') {
    $options = [];
    if (!is_null($first_option)) {
        $options[] = $first_option;
    }
    $groups = $collection->unique($title)->pluck($title)->all();
    foreach ($groups AS $index => $group) {
        $children = $collection->where($title, $group)->all();
        foreach ($children AS $child) {
            $child_options[$child->$key] = $child->$value;
        }
        $options[$group] = $child_options;
    }
    return $options;
}

function selectTwoOptions($results, $first_option = null, $key = 'id', $value = 'description') {
    $options = [];
    if (!is_null($first_option)) {
        $options[0] = $first_option;
    }
    foreach ($results AS $index => $result) {
        $options[(is_array($results) ? $index : $result->$key)] = (is_array($results) ? $result : $result->$value);
    }
    return $options;
}

function selectTwoGroupOptions($collection, $title = 'select_group', $key = 'id', $value = 'description') {
    $options = [];
    $groups = $collection->unique($title)->pluck($title)->all();
    foreach ($groups AS $index => $group) {
        $child_options = [];
        $option = [$key => $index, $value => $group];
        $children = $collection->where($title, $group)->all();
        foreach ($children AS $child) {
            $child_options[$child->$key] = $child->$value;
        }
        $option['children'] = $child_options;
        $options[] = $option;
    }
    return $options;
}

function updateSelectTwo($results, $first_option = null, $key = 'id', $value = 'description', array $extras = []) {
    $options = [];
    if (!is_null($first_option)) {
        array_push($options, ["id" => 0, "text" => $first_option]);
    }
    foreach ($results as $result) {
        $option = ["id" => $result->$key, "text" => $result->$value];
        foreach ($extras AS $k => $v) {
            $option[$k] = $result->$v;
        }
        $options[] = $option;
    }
    return $options;
}

function toDateString($date, $format = null) {
    $carbon = ($date instanceof Carbon ? $date : getCarbon($date, $format));
    return $carbon->toDateString();
}

function getCarbon($date, $format = null) {
    //For now just return carbon::parse 
    return is_null($format) ? Carbon::parse($date) : Carbon::createFromFormat($format, $date);
}

function setFilters($request) {
    $filters = $request->input();
    if (!is_null($request->session()->get($request->route()->getName()))) {
        $request->session()->forget($request->route()->getName());
    }
    $request->session()->push($request->route()->getName(), $filters);
}

function getFilters($request) {
    $filters = null;    
    if (!is_null($request->session()->get($request->route()->getName() . '.index'))) {
        $previous_filters = $request->session()->get($request->route()->getName() . '.index');
        $filters = current($previous_filters);     
        //dd($filters);
        if (isset($filters['planned_date']) && in_array($filters['planned_date'], $filters) && strlen($filters['planned_date']) > 0) {
            $planned_date = Carbon::createFromFormat('D M d Y H:i:s e+', $filters['planned_date']);
            $filters['planned_date'] = $planned_date->format('d/m/Y');
        }
        
        if (isset($filters['start_date']) && in_array($filters['start_date'], $filters) && strlen($filters['start_date']) > 0) {
            $start_date = Carbon::createFromFormat('D M d Y H:i:s e+', $filters['start_date']);
            $filters['start_date'] = $start_date->format('d/m/Y');
        }
        
        if (isset($filters['end_date']) && in_array($filters['end_date'], $filters) && strlen($filters['end_date']) > 0) {
            $end_date = Carbon::createFromFormat('D M d Y H:i:s e+', $filters['end_date']);
            $filters['end_date'] = $end_date->format('d/m/Y');
        }
    }
    return $filters;
}
