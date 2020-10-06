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
                    name: "fixtures.home_score"
                }, {
                    label: "Away Score:",
                    name: "fixtures.away_score"
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
                {data: "fixtures.description"},
                {data: "fixtures.start_date"},
                {data: "fixtures.end_date"},
                {data: null, render: function (data, type, row) {
                        if (row['fixtures']['active'] == "1") {
                            return "Active";
                        } else {
                            return "In-Active";
                        }
                    }}
            ],
            columnDefs: [
                {className: "dt-cell-left", targets: [1, 2]}, //Align table body cells to left  
                {className: "dt-cell-center", targets: [3, 4, 5]}, //Align table body cells to left  
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
                            title: '<h3>Add: Season</h3>',
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
                            title: '<h3>Edit: Season</h3>',
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
                        fixtures_editor.title('<h3>Delete: Season</h3>').buttons([
                            {label: 'Delete', fn: function () {
                                    this.submit();
                                }},
                            {label: 'Cancel', fn: function () {
                                    this.close();
                                }}
                        ]).message('Are you sure you want to delete this season?').remove(fixtures_table.row({selected: true}));
                    }
                }
            ]
        });
        $(fixtures_editor.displayNode()).addClass('modal-multi-columns');
        fixtures_editor.on('postSubmit', function (e, json, data, action) {
            if ((json.hasOwnProperty('data') && !json.hasOwnProperty('fieldErrors')) || (json.hasOwnProperty('data') && !json.hasOwnProperty('error'))) {
                var key = Object.keys(json['data']);
                var info = json['data'][key];
                switch (action) {
                    case 'create':
                        flash_message('Season ' + info['fixtures']['description'] + ' has been successfully added', 'success');
                        break;
                    case 'edit':
                        flash_message('Season ' + info['fixtures']['description'] + ' has been successfully updated', 'success');
                        break;
                    case 'remove':
                        flash_message('Season has been successfully removed', 'success');
                        break;
                }
            }
        });

    }); //End of document
</script>