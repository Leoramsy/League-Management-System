@extends('layouts.app', ['page' => 'Leagues', 'page_slug' => 'leagues','category' => 'system'])
@section('js_files')
@include('admin.javascript.settings.leagues')
@endsection
@section('content')
<div class="card">    
    <div class="card-body">
        <div class="table-responsive ps">
            <table id="leagues-table" class="table" style="width: 100%">
                <thead>
                    <tr>
                        <th>&nbsp;</th>
                        <th class='dt-cell-left'>Season</th>
                        <th class='dt-cell-left'>League Format</th>
                        <th class='dt-cell-left'>League Name</th> 
                        <th class='dt-cell-center'>Start Date</th> 
                        <th class='dt-cell-center'>End Date</th> 
                        <th class='dt-cell-center'>Active</th> 
                    </tr>
                </thead>
            </table>
            <div id="leagues-editor" class="custom-editor">
                <fieldset class="half-set multi-set">
                    <legend><i class="fa fa-user" aria-hidden="true"></i> League:</legend>                             
                    <div class="col-md-12">
                        <editor-field name="leagues.season_id"></editor-field>
                        <editor-field name="leagues.league_format_id"></editor-field>
                    </div>
                    <div class="col-md-12">
                        <editor-field name="leagues.description"></editor-field>
                        <editor-field name="leagues.active"></editor-field>
                    </div>
                    <div class="col-md-12">
                        <editor-field name="leagues.start_date"></editor-field>
                        <editor-field name="leagues.end_date"></editor-field>
                    </div>                
                </fieldset>                            
            </div> 
        </div>
    </div>
</div>
@endsection