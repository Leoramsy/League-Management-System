@extends('layouts.app', ['page' => 'Fixture Management', 'page_slug' => 'fixtures','category' => 'matchday'])
@section('js_files')
@include('admin.javascript.matchday.fixture_management.team_sheets')
@include('admin.javascript.matchday.fixture_management.goal_scorers')
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div  id="content" class="card">
            <div class="card-body">      
                <!-- form -->
                {!! Form::open(array('id' => 'fixture-management-form')) !!}                             
                <div class="col-md-12 row">
                    <div class="col-md-3">
                        <b> {!! Form::label('match_day', 'Match Day:', ['class' => 'awesome']) !!}</b>
                        {!! Form::text('match_day', $fixture->match_day, array('class' => 'form-control input-original', 'readonly' => 'true')) !!}
                    </div> 
                    <div class="col-md-3">
                        <b> {!! Form::label('home_team', 'Home Team:', ['class' => 'awesome']) !!}</b>
                        {!! Form::text('home_team', $fixture->home_team, array('class' => 'form-control input-original', 'readonly' => 'true')) !!}
                    </div> 
                    <div class="col-md-3">
                        <b> {!! Form::label('away_team', 'Away Team:', ['class' => 'awesome']) !!}</b>
                        {!! Form::text('away_team', $fixture->away_team, array('class' => 'form-control input-original', 'readonly' => 'true')) !!}
                    </div> 
                    <div class="col-md-3">
                        <b> {!! Form::label('kick_off', 'Kick Off:', ['class' => 'awesome']) !!}</b>
                        {!! Form::text('kick_off', $fixture->kick_off->format('d/m/Y H:i'), array('class' => 'form-control input-original', 'readonly' => 'true')) !!}
                    </div> 
                    <div class="col-md-3">
                        <b> {!! Form::label('type', 'Match Type:', ['class' => 'awesome']) !!}</b>
                        {!! Form::text('type', $fixture->fixture_type, array('class' => 'form-control input-original', 'readonly' => 'true')) !!}
                    </div>                    
                    <div class="col-md-3">
                        <b> {!! Form::label('home_team_score', 'Home Team Score:', ['class' => 'awesome']) !!}</b>
                        {!! Form::text('home_team_score', $fixture->home_team_score, array('class' => 'form-control input-original', 'readonly' => 'true')) !!}
                    </div> 
                    <div class="col-md-3">
                        <b> {!! Form::label('away_team_score', 'Away Team Score:', ['class' => 'awesome']) !!}</b>
                        {!! Form::text('away_team_score', $fixture->away_team_score, array('class' => 'form-control input-original', 'readonly' => 'true')) !!}
                    </div> 
                    <div class="col-md-3">
                        <b> {!! Form::label('completed', 'Completed:', ['class' => 'awesome']) !!}</b>
                        {!! Form::text('completed', ($fixture->completed ? 'Yes' : 'No'), array('class' => 'form-control input-original', 'readonly' => 'true')) !!}
                        {!! Form::hidden('fixture_id', $fixture->id, array('id' => 'fixture-id', 'class' => 'form-control input-original', 'readonly' => 'true')) !!}
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
                    <li role="presentation" class="{{ !$fixture->completed ? '' : 'active' }} col text-center"><a data-toggle="tab" href="#team-sheet-tab" >Team Sheet<span></span></a></li>
                    <li role="presentation" class="{{ !$fixture->completed ? 'active' : ''}} col text-center"><a data-toggle="tab" href="#goal-scorers-tab" >Goal Scorers<span></span></a></li>
                    <li role="presentation" class="col text-center"><a data-toggle="tab" href="#cards-tab" >Cards<span></span></a></li>               
                </ul>                      
                <div class="tab-content">                       
                    <!--<div id="team-sheets-tab" class="tab-pane fade {{ $fixture->completed ? '' : 'in active'}}">    -->  
                    <div id="team-sheet-tab" class="tab-pane {{ !$fixture->completed ? '' : 'in active'}}"> 
                        @include('admin.matchday.fixture_management.team_sheets')
                    </div>                        
                    <div id="goal-scorers-tab" class="tab-pane {{ !$fixture->completed ? 'in active' : ''}}">      
                        @include('admin.matchday.fixture_management.goal_scorers')
                    </div>                        
                    <div id="cards-tab" class="tab-pane">     
                        @include('admin.matchday.fixture_management.cards')
                    </div>
                </div>                
            </div>
        </div>
    </div>
</div>
@endsection
