<?php

namespace App\Http\Controllers\System;

use DB;
use App\Models\System\News;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NewsController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $featured = News::select("news.*", DB::raw("IFNULL(users.name, 'Admin') AS author"), DB::raw("DATE_FORMAT(news.published_date, '%d %M %Y') AS date"))
                ->leftJoin('users', 'news.created_by', '=', 'users.id')
                ->where('news.featured', TRUE)
                ->where('news.active', TRUE)
                ->orderBy('news.published_date', 'DESC')
                ->get();
        $news = News::select("news.*", DB::raw("IFNULL(users.name, 'Admin') AS author"), DB::raw("DATE_FORMAT(news.published_date, '%d %M %Y') AS date"))
                ->leftJoin('users', 'news.created_by', '=', 'users.id')
                ->where('news.active', TRUE)
                ->orderBy('news.published_date', 'DESC')
                ->get();
        return view('client.news.index', compact('news', 'featured'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\News  $news
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id) {
        $article = News::select("news.*", DB::raw("IFNULL(users.name, 'Admin') AS author"), DB::raw("DATE_FORMAT(news.published_date, '%d %M %Y') AS date"))
                ->leftJoin('users', 'news.created_by', '=', 'users.id')
                ->where('news.id', $id)
                ->first();
        if (is_null($article)) {
            flash()->error("invalid News Article selected");
            return back();
        }
        $featured = News::select("news.*", DB::raw("IFNULL(users.name, 'Admin') AS author"), DB::raw("DATE_FORMAT(news.published_date, '%d %M %Y') AS date"))
                ->leftJoin('users', 'news.created_by', '=', 'users.id')
                ->where('news.featured', TRUE)
                ->where('news.active', TRUE)
                ->orderBy('news.published_date', 'DESC')
                ->get();
        return view('client.news.show', compact('article', 'featured'));
    }

}
