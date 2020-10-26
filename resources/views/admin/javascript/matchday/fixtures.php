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
                    label: "Season:",
                    name: "fixtures.season_id",
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
                    format: 'DD/MM/YYYY h:mm a',
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
                {data: "seasons.description", editField: "fixtures.season_id"},
                {data: "match_days.description", editField: "fixtures.match_day_id"},
                {data: "home_team.name", editField: "fixtures.home_team_id"},
                {data: "away_team.name", editField: "fixtures.away_team_id"},
                {data: null, render: function (data, type, row) {
                        if (row['fixtures']['home_team_score'] == null) {
                            return "N/A";
                        } else {
                            row['fixtures']['home_team_score'];
                        }
                    }},
                {data: null, render: function (data, type, row) {
                        if (row['fixtures']['away_team_score'] == null) {
                            return "N/A";
                        } else {
                            row['fixtures']['away_team_score'];
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
                {className: "dt-cell-left", targets: [1, 2, 3, 4]}, //Align table body cells to left  
                {className: "dt-cell-center", targets: [5, 6, 7, 8]}, //Align table body cells to left  
                {searchable: false, targets: 0}
            ],
            order: [1, 'asc'],
            bLengthChange: false,
            select: {
                style: 'single',
                selector: 'td:first-child'
            }, buttons: [
                {extend: 'create', text: 'Add', className: "add-season",
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
                    extend: 'edit', text: 'Edit', className: "edit-season",
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

        fixtures_editor.dependent('fixtures.season_id', function (val, data, callback) {
            if (val > 0) {
                getData(val);
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
     * @param {type} season_id
     * @param {type} dt
     * @returns {undefined} 
     */
    function getData(season_id) {

        fixtures_editor.error('');
        fixtures_editor.field('fixtures.match_day_id').update('').message('Loading Options');
        fixtures_editor.field('fixtures.home_team_id').update('').message('Loading Options');
        fixtures_editor.field('fixtures.away_team_id').update('').message('Loading Options');
        $.ajax({
            url: "/admin/settings/fixtures/data/" + season_id,
            type: "GET"
        }).done(function (return_data) {
            fixtures_editor.field('fixtures.match_day_id').message('');
            fixtures_editor.field('fixtures.home_team_id').message('');
            fixtures_editor.field('fixtures.away_team_id').message('');
            if ('error' in return_data) {
                if (dt) {
                    fixtures_editor.error(return_data['error']);
                } else {

                }
            } else {
                fixtures_editor.field('fixtures.match_day_id').update(return_data['matchday_options']);
                fixtures_editor.field('fixtures.home_team_id').update(return_data['team_options']);
                fixtures_editor.field('fixtures.away_team_id').update(return_data['team_options']);

                fixtures_editor.field('fixtures.match_day_id').def(0).val(0);
                fixtures_editor.field('fixtures.home_team_id').def(0).val(0);
                fixtures_editor.field('fixtures.away_team_id').def(0).val(0);
            }
        });
    }
</script>