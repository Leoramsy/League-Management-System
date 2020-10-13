@extends('layouts.app', ['page' => 'Fixtures', 'page_slug' => 'fixtures','category' => 'matchday'])
@section('js_files')
@include('admin.javascript.matchday.fixtures')
@endsection
@section('content')
<div class="card">    
    <div class="card-body">
        <div class="table-responsive ps">
            <table id="fixtures-table" class="table" style="width: 100%">
                <thead>
                    <tr>
                        <th>&nbsp;</th>
                        <th class='dt-cell-left'>Season Name</th>
                        <th class='dt-cell-left'>Match Day</th>
                        <th class='dt-cell-left'>Home Team</th>
                        <th class='dt-cell-left'>Away Team</th>
                        <th class='dt-cell-right'>Home Score</th>
                        <th class='dt-cell-right'>Away Score</th>
                        <th class='dt-cell-center'>Kick Off</th> 
                        <th class='dt-cell-center'>Completed</th>                        
                    </tr>
                </thead>
            </table>
            <div id="fixtures-editor" class="custom-editor">
                <fieldset class="half-set multi-set">
                    <legend><i class="fa fa-user" aria-hidden="true"></i> Fixture:</legend>                             
                    <div class="col-md-12">
                        <editor-field name="fixtures.season_id"></editor-field> 
                        <editor-field name="fixtures.match_day_id"></editor-field>                        
                    </div>
                    <div class="col-md-12">
                        <editor-field name="fixtures.home_team_id"></editor-field>
                        <editor-field name="fixtures.away_team_id"></editor-field>
                    </div> 
                    <div class="col-md-12">
                        <editor-field name="fixtures.home_team_score"></editor-field>
                        <editor-field name="fixtures.away_team_score"></editor-field>
                    </div> 
                    <div class="col-md-12">
                        <editor-field name="fixtures.completed"></editor-field>  
                        <editor-field name="fixtures.postponed"></editor-field>  
                    </div>
                    <div class="col-md-12">
                        <editor-field name="fixtures.kick_off"></editor-field>                          
                    </div>
                </fieldset>                            
            </div> 
        </div>
    </div>
</div>
@endsection