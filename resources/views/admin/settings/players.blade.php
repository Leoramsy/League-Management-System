@extends('layouts.app', ['page' => 'Players', 'page_slug' => 'players','category' => 'system'])
@section('js_files')
{!! Html::script('js/datatables/editor.upload.js') !!}
@include('admin.javascript.settings.players')
@endsection
@section('content')
<div class="card">    
    <div class="card-body">
        <div class="table-responsive ps">
            <table id="players-table" class="table" style="width: 100%">
                <thead>
                    <tr>
                        <th>&nbsp;</th>
                        <th class='dt-cell-left'>Name</th>
                        <th class='dt-cell-left'>Surname</th> 
                        <th class='dt-cell-left'>Nick Name</th>
                        <th class='dt-cell-left'>Position</th> 
                        <th class='dt-cell-center'>Date of Birth</th> 
                        <th class='dt-cell-center'>Active</th> 
                    </tr>
                </thead>
            </table>
            <div id="players-editor" class="custom-editor">
                <fieldset class="half-set multi-set">
                    <legend><i class="fa fa-user" aria-hidden="true"></i> Player:</legend>                             
                    <div class="col-md-12">
                        <editor-field name="players.position_id"></editor-field>
                        <editor-field name="players.name"></editor-field>                        
                    </div>   
                    <div class="col-md-12">
                        <editor-field name="players.nick_name"></editor-field>
                        <editor-field name="players.surname"></editor-field>
                    </div>   
                    <div class="col-md-12">
                        <editor-field name="players.id_number"></editor-field>  
                        <editor-field name="players.contact_number"></editor-field>  
                    </div> 
                    <div class="col-md-12">
                        <editor-field name="players.date_of_birth"></editor-field>  
                        <editor-field name="players.active"></editor-field>  
                    </div> 
                    <div class="col-md-12">
                        <editor-field name="players.image"></editor-field>                        
                    </div>
                </fieldset>                
                <fieldset class="full-set">
                    <div class="col-md-12">
                        <editor-field name="team_players[].team_id"></editor-field>                                        
                    </div>                    
                </fieldset>
            </div> 
        </div>
    </div>
</div>
@endsection