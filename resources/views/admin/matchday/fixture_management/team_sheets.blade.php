<div class="col-md-12 row" style="padding: 10px 20px">                     
    <div class="col-md-5">
        <b>{!! Form::label('team_id', 'Team:', ['class' => 'awesome']) !!}</b>
        {!! Form::select('team_id', $teams, key($teams), array('id' => 'team-select', 'class' => 'form-control input-original', 'data-original' => key($teams))) !!}
    </div>                     
</div>
<div class="col-md-5" style="float: left">
    <div class="col-md-12" style="padding: 15px 0px">
        <h4 style="color: black; font-weight: bold">Available Players</h4> 
    </div>
    <div class="table-responsive ps">
        <table id="players-table" class="table" style="width: 100%">
            <thead>
                <tr>
                    <th>&nbsp;</th>
                    <th class='dt-cell-left'>Name</th>
                    <th class='dt-cell-left'>Surname</th>                     
                    <th class='dt-cell-left'>Position</th>                    
                </tr>
            </thead>
        </table>    
    </div>
    <div id="players-editor" class="custom-editor">
        <fieldset class="half-set multi-set">
            <legend><i class="fa fa-user" aria-hidden="true"></i> Team Sheet:</legend>                             
            <div class="col-md-12">
                <h4>Assign selected players to team sheet?</h4>
            </div>                     
        </fieldset>                            
    </div>
</div>
<div class="col-md-5" style="float: right">
    <div class="col-md-12" style="padding: 15px 0px">
        <h4 style="color: black; font-weight: bold">Team Sheet</h4> 
    </div>
    <div class="table-responsive ps">
        <table id="team-sheet-table" class="table" style="width: 100%">
            <thead>
                <tr>
                    <th>&nbsp;</th>
                    <th class='dt-cell-left'>Name</th>
                    <th class='dt-cell-left'>Surname</th>                    
                    <th class='dt-cell-left'>Position</th>                         
                </tr>
            </thead>
        </table>    
    </div>
</div>

