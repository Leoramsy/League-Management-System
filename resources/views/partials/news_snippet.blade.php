<div style="border-bottom: 1px solid grey; padding-bottom: 10px">                    
    <a href="{{ route('news.view', $article->id) }}"><h4 style="color: black">{{$article->title}}</h4></a>
    <h6>{{$article->date}}</h6>
    {!! substr($article->content, 0, 150) !!}...                
    <a href="{{ route('news.view', $article->id) }}" style="font-weight: bold">(read more)</a>
</div>