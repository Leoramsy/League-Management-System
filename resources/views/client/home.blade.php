@extends('layouts.app')
@section('js_files')
@include('client.javascript.dashboard.fixtures')
@include('client.javascript.dashboard.results')
@include('client.javascript.dashboard.logs')
@include('client.javascript.dashboard.top_scorers')
@include('client.javascript.home')
@endsection
@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Latest News</div>
            <div class="card-body">
                <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">    
                        @foreach($images AS $index => $image)
                        <li data-target="#carouselExampleIndicators" data-slide-to="{{$index}}" class="{{$index == 0 ? 'active' : ''}}"></li>
                        @endforeach                        
                    </ol>
                    <div class="carousel-inner" role="listbox">
                        @foreach($images AS $index => $image)
                        <div class="carousel-item {{$index == 0 ? 'active' : ''}}">
                            <img class="d-block img-fluid" src="{{$image}}" alt="Loading..." style="max-height: 500px; margin: auto">                            
                        </div>                        
                        @endforeach
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">Latest News</div>
            <div class="card-body">
                @forelse($news AS $article)
                @include('partials.news_snippet')
                @empty
                <p>No exciting news yet, check back later for more updates...</p>
                @endforelse
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header row">
                <div class="col-md-6">Match Centre</div>
                <div class="col-md-6">
                    {!! Form::select('league_id', $leagues, key($leagues), array('id' => 'league-select', 'class' => 'form-control input-original')) !!}
                </div>
            </div>
            <div class="card-body">                
                <ul id="dashboard-match-center" class="col-md-12 nav nav-tabs" style="border-bottom: 2px solid #1B75B9">                        
                    <li role="presentation" class="active"><a data-toggle="tab" href="#fixtures-tab">Fixtures<span></span></a></li>
                    <li role="presentation" class=""><a data-toggle="tab" href="#results-tab">Results <span></span></a></li>                       
                    <li role="presentation" class=""><a data-toggle="tab" href="#log-tab">Log Standings<span></span></a></li>                        
                </ul>
                <div class="tab-content">                       
                    <div id="fixtures-tab" class="tab-pane fade in active">  
                        <div class="table-responsive ps">
                            <table id="fixtures-table" class="table" style="width: 100%">
                                <thead>
                                    <tr>                                        
                                        <th class='dt-cell-left'>Home Team</th>
                                        <th class='dt-cell-left'>&nbsp;</th>
                                        <th class='dt-cell-left'>Away Team</th> 
                                        <th class='dt-cell-center'>Kick Off</th> 
                                        <th class='dt-cell-center'>&nbsp;</th>                                        
                                    </tr>
                                </thead>
                            </table>
                        </div>                        
                    </div>                        
                    <div id="results-tab" class="tab-pane fade">      
                        <div class="table-responsive ps">
                            <table id="results-table" class="table" style="width: 100%">
                                <thead>
                                    <tr>                                        
                                        <th class='dt-cell-left'>Home Team</th>
                                        <th class='dt-cell-left'>Score</th>
                                        <th class='dt-cell-left'>&nbsp;</th>
                                        <th class='dt-cell-left'>Away Team</th> 
                                        <th class='dt-cell-left'>Score</th> 
                                        <th class='dt-cell-center'>&nbsp;</th>                                        
                                    </tr>
                                </thead>
                            </table>
                        </div>       
                    </div>                        
                    <div id="log-tab" class="tab-pane fade">     
                        <div class="table-responsive ps">
                            <table id="logs-table" class="table" style="width: 100%">
                                <thead>
                                    <tr>            
                                        <th class='dt-cell-center'>Position</th>
                                        <th class='dt-cell-left'>Team</th>
                                        <th class='dt-cell-center'>Played</th>
                                        <th class='dt-cell-center'>Win</th>
                                        <th class='dt-cell-center'>Draw</th> 
                                        <th class='dt-cell-center'>Loss</th> 
                                        <th class='dt-cell-center'>Points</th>                                        
                                    </tr>
                                </thead>
                            </table>
                        </div> 
                    </div> 

                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">Top Goal Scorers</div>
            <div class="card-body">
                <table id="top-scorers-table" class="table" style="width: 100%">
                    <thead>
                        <tr>                            
                            <th class='dt-cell-left'>Player</th>
                            <th class='dt-cell-left'>Team</th>
                            <th class='dt-cell-left'>No. of Games</th> 
                            <th class='dt-cell-left'>No. of Goals</th> 
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection


