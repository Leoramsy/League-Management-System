<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

abstract class DataTablesController extends Controller
{

    /**
     * Constants
     */
    const ACTION_READ = "read";

    /**
     * Create a new controller instance
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        if ($request->has('action')) {
            $this->setAction($request->action);
        }
    }

    /**
     * If an error occurred
     *
     * @var type
     */
    protected $error = "";

    /**
     * The current action taking place
     *
     * @var type
     */
    protected $action = self::ACTION_READ;
    
    /**
     * The final JSON output to be returned
     *
     * @var array
     */
    protected $output = [];

    /**
     * The data to be returned
     *
     * @var array
     */
    protected $data = [];

    /**
     * Option lists to be given to DataTables
     *
     * @var array
     */
    protected $options = [];

    /**
     * Files to be given to DataTables
     *
     * @var array
     */
    protected $files = [];

    /**
     *
     * @var type
     */
    protected $primary_class = null;
    
    /**
     * Serverside processing indicator
     *
     * @var array
     */
    protected $serverside = false;
    
    /**
     * The total records of the dataset
     * when using serverside
     */
    protected $recordsTotal = 0;
    
    /**
     * The number of filtered records from the dataset
     * when using serverside
     */
    protected $recordsFiltered = 0;

    /**
     * Gets the data of this model formatted for use by DataTables
     *
     * @param type $entry
     * @return array
     */
    abstract protected function format($entry);

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {        
        //$entries = ($this->serverside ? $this->getRows($request) : $this->getRows($request));
        $entries = $this->getRows($request);
        foreach ($entries AS $entry) {
            $this->data[] = $this->process($entry);
        }
        //$output = ["data" => $this->data, "options" => $this->getOptions(), "files" => $this->getFiles()];
        $this->output['data'] = $this->data;
        $this->output['options'] = $this->getOptions();
        $this->output['files'] = $this->getFiles();
        if($this->serverside){
            $this->output["recordsTotal"] = $this->recordsTotal; //TODO
            $this->output["recordsFiltered"] = $this->recordsFiltered; //TODO
        }
        return response()->json($this->output);
    }

    /**
     *
     * @param type $primary_class
     */
    protected function setPrimaryClass($primary_class)
    {
        $this->primary_class = $primary_class;
    }

    /**
     *
     * @return type
     */
    protected function getPrimaryClass()
    {
        return $this->primary_class;
    }

    /**
     *
     * @return type
     */
    protected function getData()
    {
        return $this->data;
    }

    /**
     *
     * @return type
     */
    protected function setData($data)
    {
        $this->data = $data;
    }

    /**
     *
     * @return type
     */
    protected function addData($data)
    {
        $this->data[] = $data;
    }

    /**
     *
     * @return type
     */
    protected function getOptions()
    {
        return $this->options;
    }

    /**
     *
     * @return type
     */
    protected function setOptions($options = [])
    {
        $this->options = $options;
    }

    /**
     *
     * @return type
     */
    protected function addOption($option)
    {
        $this->options[] = $option;
    }

    /**
     *
     * @return type
     */
    protected function getFiles()
    {
        return $this->files;
    }

    /**
     *
     * @return type
     */
    protected function setFiles($files = [])
    {
        $this->files = $files;
    }

    /**
     *
     * @return type
     */
    protected function addFile($file, $key = null)
    {
        if (is_null($key)) {
            $this->files[key($file)] = current($file);
        } else {
            $this->files[$key][key($file)] = current($file);
        }
    }

    /**
     *
     * @param type $entries
     * @return type
     
    protected function output($entries)
    {
        if ($this->hasError()) {
            return ['error' => $this->getError()];
        }
        $json = [];
        if ($entries instanceof $this->primary_class) {
            $json = $this->process($entries); //$json = array_merge(["DT_RowId" => "row_" . $entries->id], $this->format($entries));
        } else {
            foreach ($entries AS $entry) {
                $json[] = $this->process($entry); //$json[] = array_merge(["DT_RowId" => "row_" . $entry->id], $this->format($entry));
            }
        }
        return ["data" => $json];
    }
    */
    
    /**
     * Returns row information for this model
     *
     * @return type
     */
    protected function process($entry)
    {
        //dd($entry);
        return array_merge(["DT_RowId" => "row_" . $entry->id], $this->format($entry));
        $json = [];
        if ($entries instanceof $this->primary_class) {
            $json = array_merge(["DT_RowId" => "row_" . $entries->id], $this->format($entries));
        } else {
            foreach ($entries AS $entry) {
                $json[] = array_merge(["DT_RowId" => "row_" . $entry->id], $this->format($entry));
            }
        }
        return $json;
    }

    /**
     * Check to see if this model has an error
     *
     * @return type
     */
    protected function hasError()
    {
        return (strlen($this->error) > 0);
    }

    /**
     *
     * @param string $error
     */
    protected function setError($error)
    {
        $this->error = $error;
    }

    /**
     *
     * @return string
     */
    protected function getError()
    {
        return $this->error;
    }

    /**
     *
     * @param string $action
     */
    protected function setAction($action = self::ACTION_READ)
    {
        $this->action = $action;
    }

    /**
     *
     * @return string
     */
    protected function getAction()
    {
        return $this->action;
    }

}
