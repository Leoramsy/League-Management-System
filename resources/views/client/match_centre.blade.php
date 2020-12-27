@extends('layouts.app', ['page' => ucfirst($type), 'page_slug' => $type,'category' => 'match-centre'])
@section('js_files')
@include('client.javascript.match_centre.fixtures')
@include('client.javascript.match_centre.results')
@include('client.javascript.match_centre.statistics')
@include('client.javascript.match_centre.logs')
@include('client.javascript.match_centre')
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div  id="content" class="card">
            <div class="card-body">      
                <!-- form -->
                {!! Form::open(array('id' => 'fixtures-form')) !!}                             
                <div class="col-md-12">
                    <div class="col-md-4">
                        <b> {!! Form::label('league_id', 'League:', ['class' => 'awesome']) !!}</b>
                        {!! Form::select('league_id', $leagues, key($leagues), array('id' => 'league-select', 'class' => 'form-control input-original', 'data-original' => key($leagues))) !!}
                    </div> 
                    <div class="col-md-4">
                        <b>{!! Form::label('team_id', 'Team:', ['class' => 'awesome']) !!}</b>
                        {!! Form::select('team_id', $teams, key($teams), array('id' => 'team-select', 'class' => 'form-control input-original', 'data-original' => key($teams))) !!}
                    </div>                     
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">            
            <div class="card-body">                  
                <ul class="col-md-12 nav nav-tabs" style="border-bottom: 2px solid #1B75B9">                        
                    <li role="presentation" class="{{ $type == 'fixtures' ? 'active' : ''}} col text-center"><a data-toggle="tab" href="#fixtures-tab" >Fixtures<span></span></a></li>
                    <li role="presentation" class="{{ $type == 'results' ? 'active' : ''}} col text-center"><a data-toggle="tab" href="#results-tab" >Results<span></span></a></li>
                    <li role="presentation" class="{{ $type == 'logs' ? 'active' : ''}} col text-center"><a data-toggle="tab" href="#log-tab" >Log Standings<span></span></a></li>                
                    <li role="presentation" class="{{ $type == 'statistics' ? 'active' : ''}} col text-center"><a data-toggle="tab" href="#statistics-tab" >Statistics<span></span></a></li>            
                </ul>                      
                <div class="tab-content">                       
                    <div id="fixtures-tab" class="tab-pane fade {{ $type == 'fixtures' ? 'in active' : ''}}">      
                        @include('partials.match_centre.fixtures')
                    </div>                        
                    <div id="results-tab" class="tab-pane fade {{ $type == 'results' ? 'in active' : ''}}">      
                        @include('partials.match_centre.results')
                    </div>                        
                    <div id="log-tab" class="tab-pane fade {{ $type == 'logs' ? 'in active' : ''}}">     
                        @include('partials.match_centre.logs')
                    </div>                
                    <div id="statistics-tab" class="tab-pane fade {{ $type == 'statistics' ? 'in active' : ''}}">     
                        @include('partials.match_centre.statistics')
                    </div> 
                </div>
            </div>  
        </div>
    </div>
</div>
@endsection