<div class="table-responsive ps" style="padding-top: 20px">
    @if ($fixture->completed)
    @if ($has_goals == 0)
    <table id="goal-scorers-table" class="table" style="width: 100%">
        <thead>
            <tr>                
                <th class='dt-cell-left'>Goal Number</th>
                <th class='dt-cell-left'>{{$fixture->home_team}} Scorer</th>
                <th class='dt-cell-left'>{{$fixture->away_team}} Scorer</th>
                <th class='dt-cell-left'>Own Goal?</th>                                     
            </tr>
        </thead>
        <tbody>
            @for ($i = 1; $i <= $goals; $i++)
            <tr>
                <td>{{$i}}</td>
                <td>
                    {!! Form::select('home_player_id', $home_team_players, key($home_team_players), array('id' => 'home-player-select-' . $i, 'class' => 'form-control input-original scorers-select')) !!}
                </td>
                <td>
                    {!! Form::select('away_player_id', $away_team_players, key($away_team_players), array('id' => 'away-player-select-' . $i, 'class' => 'form-control input-original scorers-select')) !!}
                </td>
                <td>
                    {{ Form::checkbox('own_goal_' . $i, 'yes', false) }}
                </td>
            </tr>
            @endfor
        </tbody>
    </table>
    @else
    <table id="scorers-table" class="table" style="width: 100%">
        <thead>
            <tr>
                <th>&nbsp;</th>
                <th class='dt-cell-left'>Goal Number</th>
                <th class='dt-cell-left'>Scorer</th>
                <th class='dt-cell-left'>Team</th>
                <th class='dt-cell-left'>Own Goal?</th>                       
            </tr>
        </thead>
    </table>
    @endif
    @else
    <div class="text-center">
        <h3>Fixture is not completed yet</h3>
    </div>
    @endif

</div>
