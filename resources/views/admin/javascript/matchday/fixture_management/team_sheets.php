<script>
    var players_table, players_editor, team_sheet_table;
    $(document).ready(function () {
        /*
         * Select2
         */
        $("#team-select").select2({
            theme: "bootstrap"
        }).on('change', function () {
            players_table.ajax.reload();
            team_sheet_table.ajax.reload();
        });

        players_editor = new $.fn.dataTable.Editor({
            table: "#players-table",
            template: "#players-editor"
        });
        /***** INIT TABLE *****/
        players_table = $('#players-table').DataTable({
            tabIndex: 1,
            pageLength: 20,
            dom: 'Bfrtip',
            ajax: {
                url: '/admin/settings/fixtures/{{$fixture->id}}/management/players',
                type: "GET",
                data: function (d) {
                    d.team_id = $('#team-select').val();
                    d.fixture_id = $('#fixture-id').val();
                }
            },
            columns: [
                {data: null, defaultContent: '', orderable: false, sClass: "selector"},
                {data: "players.name"},
                {data: "players.surname"},
                {data: "positions.description"}
            ],
            columnDefs: [
                {className: "dt-cell-left", targets: [1, 2, 3]}, //Align table body cells to left  
                {className: "dt-cell-center", targets: []}, //Align table body cells to left  
                {searchable: false, targets: 0}
            ],
            order: [1, 'asc'],
            bLengthChange: false,
            select: {
                style: 'multiple',
                selector: 'td:first-child'
            }, buttons: [
                {extend: 'edit', text: 'Add to Team Sheet', className: "add-player",
                    action: function () {
                        players_editor.edit(players_table.row({selected: true}).index(), {
                            title: "<h3>Team Sheet: Add Players</h3>",
                            buttons: [
                                {
                                    label: 'Add',
                                    fn: function (e) {
                                        var rows = players_table.rows({selected: true}).data();
                                        var fixture_id = $('#fixture-id').val();
                                        var csrf_token = $('meta[name="csrf-token"]').attr('content'); //Tag is in the main layout //csrf_token() 
                                        var form = $('<form>', {
                                            'method': 'post',
                                            'action': "/admin/settings/fixtures/" + fixture_id + "/management/players/add"
                                        }).append($('<input>', {
                                            'name': '_token',
                                            'value': csrf_token,
                                            'type': 'hidden'
                                        })).append($('<input>', {
                                            'name': 'team_id',
                                            'value': $("#team-select").val(),
                                            'type': 'hidden'
                                        }));
                                        for (var i = 0; i < rows.length; i++) {
                                            form.append($('<input>', {
                                                'name': 'player_ids[]',
                                                'value': rows[i]['players']['id'],
                                                'type': 'hidden'
                                            }));
                                        }
                                        form.appendTo('body').submit();
                                        this.close();
                                    }
                                },
                                {
                                    label: 'Cancel',
                                    fn: function (e) {
                                        this.close();
                                    }
                                }
                            ]
                        });
                    }
                }, {
                    text: '<i class="fa fa-refresh" aria-hidden="true" rel="tooltip" title="Refresh table results"></i>', className: "",
                    action: function () {
                        players_table.ajax.reload();
                    }
                }
            ]
        });

        /***** INIT TABLE *****/
        team_sheet_table = $('#team-sheet-table').DataTable({
            tabIndex: 1,
            pageLength: 20,
            dom: 'Bfrtip',
            ajax: {
                url: '/admin/settings/fixtures/{{$fixture->id}}/management/players',
                type: "GET",
                data: function (d) {
                    d.team_id = $('#team-select').val();
                    d.fixture_id = $('#fixture-id').val();
                    d.team_sheet = true;
                }
            },
            columns: [
                {data: null, defaultContent: '', orderable: false, sClass: "selector"},
                {data: "players.name"},
                {data: "players.surname"},
                {data: "positions.description"}
            ],
            columnDefs: [
                {className: "dt-cell-left", targets: [1, 2, 3]}, //Align table body cells to left  
                {className: "dt-cell-center", targets: []}, //Align table body cells to left  
                {searchable: false, targets: 0}
            ],
            order: [1, 'asc'],
            bLengthChange: false,
            select: {
                style: 'multiple',
                selector: 'td:first-child'
            }, buttons: [
                {extend: 'edit', text: 'Remove from Team Sheet', className: "remove-player",
                    action: function () {
                        var rows = team_sheet_table.rows({selected: true}).data();
                        var fixture_id = $('#fixture-id').val();
                        var csrf_token = $('meta[name="csrf-token"]').attr('content'); //Tag is in the main layout //csrf_token() 
                        var form = $('<form>', {
                            'method': 'post',
                            'action': "/admin/settings/fixtures/" + fixture_id + "/management/players/remove"
                        }).append($('<input>', {
                            'name': '_token',
                            'value': csrf_token,
                            'type': 'hidden'
                        })).append($('<input>', {
                            'name': 'team_id',
                            'value': $("#team-select").val(),
                            'type': 'hidden'
                        }));
                        for (var i = 0; i < rows.length; i++) {
                            form.append($('<input>', {
                                'name': 'fixture_player_ids[]',
                                'value': rows[i]['players']['id'],
                                'type': 'hidden'
                            }));
                        }
                        form.appendTo('body').submit();
                    }
                }, {
                    text: '<i class="fa fa-refresh" aria-hidden="true" rel="tooltip" title="Refresh table results"></i>', className: "",
                    action: function () {
                        team_sheet_table.ajax.reload();
                    }
                }
            ]
        });
    }); //End of document   

</script>