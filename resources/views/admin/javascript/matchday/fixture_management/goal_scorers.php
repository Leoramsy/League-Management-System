<script>
    var goal_scorers_table, scorers_table;
    $(document).ready(function () {
        /*
         * Select2
         */
        $(".scorers-select").select2({
            theme: "bootstrap"
        });

        /***** INIT TABLE *****/
        goal_scorers_table = $('#goal-scorers-table').DataTable({
            tabIndex: 1,
            pageLength: 20,
            dom: 'Bfrtip',
            columnDefs: [
                {className: "dt-cell-left", targets: [1, 2]}, //Align table body cells to left  
                {className: "dt-cell-center", targets: [0, 3]}, //Align table body cells to left  
                {searchable: false, targets: 0}
            ],
            order: [0, 'asc'],
            bLengthChange: false,
            select: {
                style: 'single',
                selector: 'td:first-child'
            }, buttons: [
                {extend: 'create', text: 'Add Scorers', className: "add-player",
                    action: function () {
                        var rows = goal_scorers_table.rows().data();
                        var fixture_id = $('#fixture-id').val();
                        var csrf_token = $('meta[name="csrf-token"]').attr('content'); //Tag is in the main layout //csrf_token() 
                        var form = $('<form>', {
                            'method': 'post',
                            'action': "/admin/settings/fixtures/" + fixture_id + "/management/scores/add"
                        }).append($('<input>', {
                            'name': '_token',
                            'value': csrf_token,
                            'type': 'hidden'
                        }));
                        for (var i = 0; i < rows.length; i++) {
                            form.append($('<input>', {
                                'name': "goal_scorers[" + i + "][number]",
                                'value': rows[i][0],
                                'type': 'hidden'
                            })).append($('<input>', {
                                'name': "goal_scorers[" + i + "][home_team_scorer]",
                                'value': $("#home-player-select-" + rows[i][0]).val(),
                                'type': 'hidden'
                            })).append($('<input>', {
                                'name': "goal_scorers[" + i + "][away_team_scorer]",
                                'value': $("#away-player-select-" + rows[i][0]).val(),
                                'type': 'hidden'
                            })).append($('<input>', {
                                'name': "goal_scorers[" + i + "][own_goal]",
                                'value': $('input[name=own_goal_' + rows[i][0] + ']:checked').val() == 'yes' ? true : false,
                                'type': 'hidden'
                            }));
                        }
                        form.appendTo('body').submit();
                        this.close();
                    }
                }
            ]
        });

        /***** INIT TABLE *****/
        scorers_table = $('#scorers-table').DataTable({
            tabIndex: 1,
            pageLength: 20,            
            ajax: {
                url: '/admin/settings/fixtures/{{$fixture->id}}/management/scores',
                type: "GET",
                data: function (d) {
                    d.fixture_id = $('#fixture-id').val();
                }
            },
            columns: [
                {data: null, defaultContent: '', orderable: false, sClass: "selector"},
                {data: "fixture_goals.goal_number"},
                {data: "players.name"},
                {data: "teams.name"},
                {data: "fixture_goals.own_goal"}
            ],
            columnDefs: [
                {className: "dt-cell-left", targets: [1, 2, 3]}, //Align table body cells to left  
                {className: "dt-cell-center", targets: []}, //Align table body cells to left  
                {searchable: false, targets: 0}
            ],
            order: [1, 'asc'],
            bLengthChange: false,
            select: {
                style: 'single',
                selector: 'td:first-child'
            }
        });
    }); //End of document   

</script>