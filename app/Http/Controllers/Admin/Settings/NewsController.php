<?php

namespace App\Http\Controllers\Admin\Settings;

use DB;
use Exception;
use Carbon\Carbon;
use App\Models\Team\Color;
use Illuminate\Http\Request;
use App\Models\System\League;
use Illuminate\Support\Arr;
use App\Http\Controllers\EditorController;

class NewsController extends EditorController {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request) {
        parent::__construct($request);
        $this->middleware('auth');
        $this->setPrimaryClass('App\Models\System\News');
    }

    /**
     * Show the view for this controller
     * 
     * @return \Illuminate\Http\Response
     */
    public function view() {
        $page = 'News';
        return view('admin.settings.news', compact('page'));
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    protected function create(Request $request) {
        $user = $request->user();
        $class = $this->getPrimaryClass();
        $object = new $class();
        $data = $this->data[$object->getTable()];
        $date = Carbon::createFromFormat('d/m/Y', $data['published_date'])->startOfDay();
        $object->fill($data);
        $object->published_date = $date;
        $object->image = null;
        $object->created_by = $user->id;
        if (!$object->save()) {
            $this->setError('Failed to create the entry');
        }
        return $this->getRows($request, $object->id);
    }

    /**
     * Update a newly resource in storage.
     * 
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    protected function edit(Request $request) {
        $class = $this->getPrimaryClass();
        $object = $class::findOrFail($this->primary_key);
        $data = $this->data[$object->getTable()];
        $date = Carbon::createFromFormat('d/m/Y', $data['published_date'])->startOfDay();
        $object->fill($data);
        $object->published_date = $date;
        if (!$object->save()) {
            $this->setError('Failed to create the entry');
        }
        return $this->getRows($request, $object->id);
    }

    /**
     * Return a list of resource.
     * 
     * @param Request $request
     * @param int $id
     * @return mixed
     */
    protected function getRows(Request $request, $id = 0) {
        $object = $this->getPrimaryClass();
        $query = $object::select(['news.*', 'users.name'])
                ->leftJoin('users', 'news.created_by', '=', 'users.id');
        if ($id > 0) {
            return $query->where('news.id', $id)->first();
        }
        return $query->get();
    }

    /**
     * @return \App\Http\Controllers\type|array
     */
    protected function getOptions() {
        return [
        ];
    }

    protected function format($data): array {
        return [
            "news" => [
                "title" => $data->title,
                "content" => $data->body,
                "published_date" => $data->published_date->format('d/m/Y'),
                "active" => $data->active,
                "featured" => $data->featured,
                "created_by" => $data->name,
            ],
            "users" => [
                "name" => (is_null($data->name) ? 'System' : $data->name)
            ]
        ];
    }

    protected function setRules(array $rules = array()): array {
        $this->rules = [
            'news.title' => 'required|string|min:3',
            'news.content' => 'required|string|min:3',
            'news.active' => 'required|boolean',
            'news.featured' => 'required|boolean',
        ];
        if (count($rules) > 0) {
            $this->rules = array_merge($this->rules, $rules);
        }
        return $this->rules;
    }

}
