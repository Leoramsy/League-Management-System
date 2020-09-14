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
function formatEditorPrimaryKey($row_id) {
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
            $id = array_map(function ($row_id) {
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
 * Allows for HTML5 data-global attributes?
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
 * Pass a collection in from a query, where you query the parent first then leftJoin the children in.
 *
 * @param $collection
 * @param string $parent_id
 * @param string $parent
 * @param string $child_key
 * @param string $child_value
 * @return array
 */
function editorSelectTwoGroupOptions($collection, $parent_id = 'parent_id', $parent = 'select_group', $child_key = 'id', $first_option = null) {
    $options = [];
    $groups = $collection->where($child_key, null)->unique($parent)->pluck($parent, $parent_id)->all();
    if (!is_null($first_option)) {
        $options[] = $first_option;
    }
    //Only has the groups
    foreach ($groups AS $index => $group) {
        $child_options = [];
        $children = $collection->where($child_key, $index)->all();
        ;
        if (count($children) > 0) {
            $option = ['text' => $group];
            $child_options[] = ['id' => $index, 'text' => $group];
        } else {
            $option = ['id' => $index, 'text' => $group];
        }
        foreach ($children AS $child) {
            $child_options[] = ['id' => $child->$parent_id, 'text' => $child->$parent];
        }
        $option['children'] = $child_options;
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

/**
 *
 * @param type $collection
 * @param type $first_option
 * @param type $title
 * @param type $key
 * @param type $value
 * @return type
 */
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

/**
 *
 * @param type $results
 * @param type $first_option
 * @param type $key
 * @param type $value
 * @return type
 */
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

/**
 *
 * @param type $collection
 * @param type $title
 * @param type $key
 * @param type $value
 * @return type
 */
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

/**
 *
 * @param type $results
 * @param type $first_option
 * @param type $key
 * @param type $value
 * @param array $extras
 * @return type
 */
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

/**
 *
 * @param Carbon $date
 * @param type $format
 * @return type
 */
function toDateString($date, $format = null) {
    $carbon = ($date instanceof Carbon ? $date : getCarbon($date, $format));
    return $carbon->toDateString();
}

/**
 *
 * @param Carbon $date
 * @param type $format
 * @return type
 */
function toCarbon($date, $format = null) {
    if (is_null($date)) {
        return Carbon::now();
    }
    $carbon = ($date instanceof Carbon ? $date : getCarbon($date, $format));
    return $carbon;
}

/**
 *
 * @param type $date
 * @param type $format
 * @return type
 */
function getCarbon($date, $format = null) {
    //For now just return carbon::parse 
    return is_null($format) ? Carbon::parse($date) : Carbon::createFromFormat($format, $date);
}

/**
 * 
 * @param Carbon $date
 * @param int $start
 * @param int $end
 */
function getYearSelect($date, $start, $end) {
    $years = [];
    for ($i = -5; $i <= 5; $i++) {
        //$years .= "{label: '" . ($currentyear + $i) . "', value: '" . ($currentyear + $i) . "'},";
        $years[] = ['label' => ($date + $i), 'value' => ($date + $i)];
    }
    return $years;
}

/**
 * @param int $length
 * @return bool|string
 */
function str_quick_random($length = 16) {
    $pool = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    return substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
}

/**
 *
 * http://php.net/manual/en/exception.gettraceasstring.php
 * ernest at vogelsinger dot at
 *
 * @param $e
 * @param null $seen
 * @return array|string
 */
function jTraceEx($e, $seen = null) {
    $starter = $seen ? 'Caused by: ' : '';
    $result = array();
    if (!$seen)
        $seen = array();
    $trace = $e->getTrace();
    $prev = $e->getPrevious();
    $result[] = sprintf('%s%s: %s', $starter, get_class($e), $e->getMessage());
    $file = $e->getFile();
    $line = $e->getLine();
    while (true) {
        $current = "$file:$line";
        if (is_array($seen) && in_array($current, $seen)) {
            $result[] = sprintf(' ... %d more', count($trace) + 1);
            break;
        }
        $result[] = sprintf(' at %s%s%s(%s%s%s)', count($trace) && array_key_exists('class', $trace[0]) ? str_replace('\\', '.', $trace[0]['class']) : '', count($trace) && array_key_exists('class', $trace[0]) && array_key_exists('function', $trace[0]) ? '.' : '', count($trace) && array_key_exists('function', $trace[0]) ? str_replace('\\', '.', $trace[0]['function']) : '(main)', $line === null ? $file : basename($file), $line === null ? '' : ':', $line === null ? '' : $line);
        if (is_array($seen))
            $seen[] = "$file:$line";
        if (!count($trace))
            break;
        $file = array_key_exists('file', $trace[0]) ? $trace[0]['file'] : 'Unknown Source';
        $line = array_key_exists('file', $trace[0]) && array_key_exists('line', $trace[0]) && $trace[0]['line'] ? $trace[0]['line'] : null;
        array_shift($trace);
    }
    $result = join("\n", $result);
    if ($prev)
        $result .= "\n" . jTraceEx($prev, $seen);

    return $result;
}
