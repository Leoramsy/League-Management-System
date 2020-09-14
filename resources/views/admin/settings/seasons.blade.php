@extends('layouts.app', ['page' => 'Seasons', 'page_slug' => 'seasons','category' => 'system'])
@section('js_files')
@include('admin.javascript.settings.seasons')
@endsection
@section('content')
<div class="card">    
    <div class="card-body">
        <div class="table-responsive ps">
            <table id="seasons-table" class="table" style="width: 100%">
                <thead>
                    <tr>
                        <th>&nbsp;</th>
                        <th class='dt-cell-left'>League</th>
                        <th class='dt-cell-left'>Season Name</th>
                        <th class='dt-cell-center'>Start Date</th>
                        <th class='dt-cell-center'>End Date</th> 
                        <th class='dt-cell-center'>Active</th>
                    </tr>
                </thead>
            </table>
            <div id="seasons-editor" class="custom-editor">
                <fieldset class="half-set multi-set">
                    <legend><i class="fa fa-user" aria-hidden="true"></i> Season:</legend>                             
                    <div class="col-md-12">
                        <editor-field name="seasons.league_id"></editor-field>
                        <editor-field name="seasons.description"></editor-field>
                    </div>
                    <div class="col-md-12">
                        <editor-field name="seasons.start_date"></editor-field>
                        <editor-field name="seasons.end_date"></editor-field>
                    </div>                   
                    <div class="col-md-12">
                        <editor-field name="seasons.active"></editor-field>  
                    </div>
                </fieldset>                            
            </div> 
        </div>
    </div>
</div>
@endsection