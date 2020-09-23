@extends('layouts.app', ['page' => 'League Formats', 'page_slug' => 'league_formats','category' => 'system'])
@section('js_files')
@include('admin.javascript.settings.league_formats')
@endsection
@section('content')
<div class="card">    
    <div class="card-body">
        <div class="table-responsive ps">
            <table id="formats-table" class="table" style="width: 100%">
                <thead>
                    <tr>
                        <th>&nbsp;</th>
                        <th class='dt-cell-left'>League Format</th>
                        <th class='dt-cell-left'>Unique Name</th>                        
                    </tr>
                </thead>
            </table>
            <div id="formats-editor" class="custom-editor">
                <fieldset class="half-set multi-set">
                    <legend><i class="fa fa-user" aria-hidden="true"></i> League Format:</legend>                             
                    <div class="col-md-12">
                        <editor-field name="league_formats.description"></editor-field>
                        <editor-field name="league_formats.slug"></editor-field>
                    </div>                    
                </fieldset>                            
            </div> 
        </div>
    </div>
</div>
@endsection