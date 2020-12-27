<script>
    var fixtures_table;
    $(document).ready(function () {
        fixtures_editor = new $.fn.dataTable.Editor({
            ajax: {
                create: '/admin/settings/fixtures/add',
                edit: {
                    type: 'PUT',
                    url: '/admin/settings/fixtures/edit/_id_'
                },
                remove: {
                    type: 'DELETE',
                    url: '/admin/settings/fixtures/delete/_id_'
                }
            },
            table: "#fixtures-table",
            template: "#fixtures-editor",
            fields: [
                {
                    label: "League:",
                    name: "fixtures.league_id",
                    type: "select2",
                    opts: {
                        minimumResultsForSearch: 1
                    },
                    def: 0
                }, {
                    label: "Fixture Type:",
                    name: "fixtures.fixture_type_id",
                    type: "select2",
                    opts: {
                        minimumResultsForSearch: 1
                    },
                    def: 0
                }, {
                    label: "Home Score:",
                    name: "fixtures.home_team_score"
                }, {
                    label: "Away Score:",
                    name: "fixtures.away_team_score"
                }, {
                    label: "Matchday:",
                    name: "fixtures.match_day_id",
                    type: "select2",
                    opts: {
                        minimumResultsForSearch: 1
                    },
                    def: 0
                }, {
                    label: "Home Team:",
                    name: "fixtures.home_team_id",
                    type: "select2",
                    opts: {
                        minimumResultsForSearch: 1
                    },
                    def: 0
                }, {
                    label: "Away Team:",
                    name: "fixtures.away_team_id",
                    type: "select2",
                    opts: {
                        minimumResultsForSearch: 1
                    },
                    def: 0
                }, {
                    label: "Postponed:",
                    name: "fixtures.postponed",
                    type: "radio",
                    options: [
                        {label: "Yes", value: 1},
                        {label: "No", value: 0}
                    ],
                    def: 0
                }, {
                    label: "Completed:",
                    name: "fixtures.completed",
                    type: "radio",
                    options: [
                        {label: "Yes", value: 1},
                        {label: "No", value: 0}
                    ],
                    def: 0
                }, {
                    label: "Drawn Match:",
                    name: "fixtures.drawn_match",
                    type: "radio",
                    options: [
                        {label: "Yes", value: 1},
                        {label: "No", value: 0}
                    ],
                    def: 0
                }, {
                    label: "Kick Off:",
                    name: "fixtures.kick_off",
                    type: "datetime",
                    format: 'DD/MM/YYYY hh:mm',
                    def: function () {
                        return new Date();
                    }
                }
            ]
        });

        /***** INIT TABLE *****/
        fixtures_table = $('#fixtures-table').DataTable({
            tabIndex: 1,
            pageLength: 20,
            bFilter: false,
            bInfo: false,
            dom: 'Bfrtip',
            ajax: {
                url: '/admin/settings/fixtures/index',
                type: "GET"
            },
            columns: [
                {data: null, defaultContent: '', orderable: false, sClass: "selector"},
                {data: "leagues.description", editField: "fixtures.league_id"},
                {data: "match_days.description", editField: "fixtures.match_day_id"},
                {data: "home_team.name", editField: "fixtures.home_team_id"},
                {data: "away_team.name", editField: "fixtures.away_team_id"},
                {data: null, editField: "fixtures.fixture_type_id", render: function (data, type, row) {
                        if (row['fixture_types']['description'] == null) {
                            return "N/A";
                        } else {
                            return row['fixture_types']['description'];
                        }
                    }},
                {data: null, render: function (data, type, row) {
                        if (row['fixtures']['home_team_score'] == null) {
                            return "N/A";
                        } else {
                            return row['fixtures']['home_team_score'];
                        }
                    }},
                {data: null, render: function (data, type, row) {
                        if (row['fixtures']['away_team_score'] == null) {
                            return "N/A";
                        } else {
                            return row['fixtures']['away_team_score'];
                        }
                    }},
                {data: "fixtures.kick_off"},
                {data: null, render: function (data, type, row) {
                        if (row['fixtures']['completed'] == "1") {
                            return "Yes";
                        } else {
                            return "No";
                        }
                    }}
            ],
            columnDefs: [
                {className: "dt-cell-left", targets: [1, 2, 3, 4, 5]}, //Align table body cells to left  
                {className: "dt-cell-center", targets: [6, 7, 8, 9]}, //Align table body cells to left  
                {searchable: false, targets: 0}
            ],
            order: [8, 'desc'],
            bLengthChange: false,
            select: {
                style: 'single',
                selector: 'td:first-child'
            }, buttons: [
                {extend: 'create', text: 'Add', className: "add-league",
                    action: function () {
                        fixtures_editor.create({
                            title: '<h3>Add: Fixture</h3>',
                            buttons: [
                                {
                                    label: 'Add',
                                    fn: function (e) {
                                        this.submit();
                                    }
                                },
                                {
                                    label: 'Close',
                                    fn: function (e) {
                                        this.close();
                                    }
                                }
                            ]
                        });
                    }
                }, {
                    extend: 'edit', text: 'Edit', className: "edit-league",
                    action: function () {
                        fixtures_editor.edit(fixtures_table.row({selected: true}).indexes(), {
                            title: '<h3>Edit: Fixture</h3>',
                            buttons: [
                                {
                                    label: 'Update',
                                    fn: function (e) {
                                        this.submit();
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
                        var league_id = fixtures_table.row({selected: true}).data().fixtures.league_id;
                        fixtures_editor.field('fixtures.league_id').inst().select2().val(league_id).trigger("change");
                    }
                }, {
                    extend: 'remove',
                    text: 'Delete',
                    action: function () {
                        fixtures_editor.title('<h3>Delete: Fixture</h3>').buttons([
                            {label: 'Delete', fn: function () {
                                    this.submit();
                                }},
                            {label: 'Cancel', fn: function () {
                                    this.close();
                                }}
                        ]).message('Are you sure you want to delete this Fixture?').remove(fixtures_table.row({selected: true}).indexes());
                    }
                }
            ]
        });

        fixtures_editor.dependent('fixtures.league_id', function (val, data, callback) {
            if (val > 0) {
                var home_team_id = (fixtures_editor.mode() === "edit" ? data["row"]["fixtures"]["home_team_id"] : 0);
                var away_team_id = (fixtures_editor.mode() === "edit" ? data["row"]["fixtures"]["away_team_id"] : 0);
                var match_day_id = (fixtures_editor.mode() === "edit" ? data["row"]["fixtures"]["match_day_id"] : 0);
                getData(val, match_day_id, home_team_id, away_team_id);
            }
        });


        $(fixtures_editor.displayNode()).addClass('modal-multi-columns');
        fixtures_editor.on('postSubmit', function (e, json, data, action) {
            if ((json.hasOwnProperty('data') && !json.hasOwnProperty('fieldErrors')) || (json.hasOwnProperty('data') && !json.hasOwnProperty('error'))) {
                var key = Object.keys(json['data']);
                var info = json['data'][key];
                switch (action) {
                    case 'create':
                        flash_message('Fixture has been successfully added', 'success');
                        break;
                    case 'edit':
                        flash_message('Fixture has been successfully updated', 'success');
                        break;
                    case 'remove':
                        flash_message('Fixture has been successfully removed', 'success');
                        break;
                }
            }
        });

    }); //End of document
    /**
     * 
     * @param {type} league_id
     * @param {type} dt
     * @returns {undefined} 
     */
    function getData(league_id, match_day_id, home_team_id, away_team_id) {
        fixtures_editor.error('');
        fixtures_editor.field('fixtures.match_day_id').update('').message('Loading Options');
        fixtures_editor.field('fixtures.home_team_id').update('').message('Loading Options');
        fixtures_editor.field('fixtures.away_team_id').update('').message('Loading Options');
        $.ajax({
            url: "/admin/settings/fixtures/data/" + league_id,
            type: "GET"
        }).done(function (return_data) {
            fixtures_editor.field('fixtures.match_day_id').message('');
            fixtures_editor.field('fixtures.home_team_id').message('');
            fixtures_editor.field('fixtures.away_team_id').message('');
            if ('error' in return_data) {
                fixtures_editor.error(return_data['error']);
            } else {
                var match_day;
                var home_team;
                var away_team;
                for (var i = 0; i < return_data['matchday_options'].length; i++) {
                    if (return_data['matchday_options'][i]["value"] == match_day_id)
                    {
                        match_day = true;
                        break;
                    }
                }

                for (var i = 0; i < return_data['team_options'].length; i++) {
                    if (return_data['team_options'][i]["value"] == home_team_id)
                    {
                        home_team = true;
                        break;
                    }
                }

                for (var i = 0; i < return_data['team_options'].length; i++) {
                    if (return_data['team_options'][i]["value"] == away_team_id)
                    {
                        away_team = true;
                        break;
                    }
                }

                fixtures_editor.field('fixtures.match_day_id').update(return_data['matchday_options']);
                fixtures_editor.field('fixtures.home_team_id').update(return_data['team_options']);
                fixtures_editor.field('fixtures.away_team_id').update(return_data['team_options']);

                fixtures_editor.field('fixtures.match_day_id').def((match_day ? match_day_id : 0)).val((match_day ? match_day_id : 0));
                fixtures_editor.field('fixtures.home_team_id').def((home_team ? home_team_id : 0)).val((home_team ? home_team_id : 0));
                fixtures_editor.field('fixtures.away_team_id').def((away_team ? away_team_id : 0)).val((away_team ? away_team_id : 0));
            }
        });
    }
</script>