@extends('layouts.app', ['page' => 'Article', 'page_slug' => 'news','category' => 'news'])
@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">{{$article->title}}</div>   
            <div  class="card-body">
                <a href="{{ route('news.view', $article->id) }}">
                    <img src="{{(is_null($article->image) ? 'https://via.placeholder.com/1100x350?text=No+image+to+show' : $article->image)}}" alt="Loading...">
                </a>
            </div>
        </div>       
        <div class="card">
            <div  class="card-body">
                <div class="col-md-12">
                    {!! $article->content!!}
                </div>
            </div>
        </div>       
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


