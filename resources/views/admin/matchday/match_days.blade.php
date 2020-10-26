@extends('layouts.app', ['page' => 'Match Days', 'page_slug' => 'match_days','category' => 'matchday'])
@section('js_files')
@include('admin.javascript.matchday.match_days')
@endsection
@section('content')
<div class="card">    
    <div class="card-body">
        <div class="table-responsive ps">
            <table id="match_days-table" class="table" style="width: 100%">
                <thead>
                    <tr>
                        <th>&nbsp;</th>
                        <th class='dt-cell-left'>Season</th>
                        <th class='dt-cell-left'>Description</th>
                        <th class='dt-cell-center'>Start Date</th>
                        <th class='dt-cell-center'>End Date</th>
                        <th class='dt-cell-center'>Completed</th>                                           
                    </tr>
                </thead>
            </table>
            <div id="match_days-editor" class="custom-editor">
                <fieldset class="half-set multi-set">
                    <legend><i class="fa fa-user" aria-hidden="true"></i> Match Day:</legend>                             
                    <div class="col-md-12">
                        <editor-field name="match_days.season_id"></editor-field> 
                        <editor-field name="match_days.description"></editor-field>                        
                    </div>
                    <div class="col-md-12">
                        <editor-field name="match_days.start_date"></editor-field>
                        <editor-field name="match_days.end_date"></editor-field>
                    </div> 
                    <div class="col-md-12">                       
                        <editor-field name="match_days.completed"></editor-field>
                    </div>                     
                </fieldset>                            
            </div> 
        </div>
    </div>    
</div>
@endsection