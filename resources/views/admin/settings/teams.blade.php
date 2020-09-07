@extends('layouts.app', ['page' => 'Teams', 'page_slug' => 'teams','category' => 'system'])
@section('js_files')
@include('admin.javascript.settings.teams')
@endsection
@section('content')
<div class="card">    
    <div class="card-body">
        <div class="table-responsive ps">
            <table id="teams-table" class="table" style="width: 100%">
                <thead>
                    <tr>
                        <th>&nbsp;</th>
                        <th class='dt-cell-left'>Name</th>
                        <th class='dt-cell-left'>Nick Name</th>
                        <th class='dt-cell-left'>Contact Person</th>
                        <th class='dt-cell-left'>Tel No</th>                
                        <th class='dt-cell-left'>Email</th>
                        <th class='dt-cell-left'>Home Colour</th>
                        <th class='dt-cell-left'>Away Colour</th>
                        <th class='dt-cell-left'>Home Ground</th>
                        <th class='dt-cell-center'>Active</th>
                    </tr>
                </thead>
            </table>
            <div id="teams-editor" class="custom-editor">
                <fieldset class="half-set multi-set">
                    <legend><i class="fa fa-user" aria-hidden="true"></i> Team:</legend>                             
                    <div class="col-md-12">
                        <editor-field name="teams.name"></editor-field>
                        <editor-field name="teams.nick_name"></editor-field>
                    </div>
                    <div class="col-md-12">
                        <editor-field name="teams.contact_person"></editor-field>
                        <editor-field name="teams.phone_number"></editor-field>
                    </div>
                    <div class="col-md-12">
                        <editor-field name="teams.email"></editor-field>   
                        <editor-field name="teams.home_ground"></editor-field>   
                    </div>
                    <div class="col-md-12">
                        <editor-field name="teams.home_color_id"></editor-field>   
                        <editor-field name="teams.away_color_id"></editor-field>   
                    </div>
                    <div class="col-md-12">
                        <editor-field name="teams.active"></editor-field>  
                    </div>
                </fieldset>                            
            </div> 
        </div>
    </div>
</div>
@endsection