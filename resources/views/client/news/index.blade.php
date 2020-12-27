@extends('layouts.app', ['page' => 'News', 'page_slug' => 'news','category' => 'news'])
@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card" style="margin-bottom: 10px">
            <div class="card-header" style="padding-bottom: 15px">Latest News</div>            
        </div>        
        @forelse($news AS $index => $article)
        <div class="card" style="width: 49%;float: {{ $index % 2 ? 'left' : 'right'}}">
            <div class="col-md-12" style="padding-top: 15px">
                <a href="{{ route('news.view', $article->id) }}">
                    <img class="img-fluid" src="{{(is_null($article->image) ? 'https://via.placeholder.com/350x150?text=No+image+to+show' : '/images/news/' . $article->image)}}" alt="Loading..." style="max-height: 200px;">
                </a>
            </div>
            <div class="col-md-12">
                <a href="{{ route('news.view', $article->id) }}"><h4 style="color: black">{{$article->title}}</h4></a>
                <h6>{{$article->date}}</h6>
                {!! substr($article->content, 0, 150) !!}...                
                <a href="{{ route('news.view', $article->id) }}" style="font-weight: bold">(read more)</a>            
            </div>
        </div>
        @empty
        <p>No exciting news yet, check back later for more updates...</p>
        @endforelse
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">Popular News</div>
            <div class="card-body">
                @forelse($featured AS $article)
                @include('partials.news_snippet')
                @empty
                <p>No exciting news yet, check back later for more updates...</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection


