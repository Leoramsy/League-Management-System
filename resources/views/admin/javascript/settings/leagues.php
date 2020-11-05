<script>
    var leagues_table;
    $(document).ready(function () {
        leagues_editor = new $.fn.dataTable.Editor({
            ajax: {
                create: '/admin/settings/leagues/add',
                edit: {
                    type: 'PUT',
                    url: '/admin/settings/leagues/edit/_id_'
                },
                remove: {
                    type: 'DELETE',
                    url: '/admin/settings/leagues/delete/_id_'
                }
            },
            table: "#leagues-table",
            template: "#leagues-editor",
            fields: [
                {
                    label: "Season:",
                    name: "leagues.season_id",
                    type: "select2",
                    def: 0
                }, {
                    label: "League Format:",
                    name: "leagues.league_format_id",
                    type: "select2",
                    def: 0
                }, {
                    label: "League Name:",
                    name: "leagues.description"
                }, {
                    label: "Active:",
                    name: "leagues.active",
                    type: "radio",
                    options: [
                        {label: "Yes", value: 1},
                        {label: "No", value: 0}
                    ],
                    def: 1
                }, {
                    label: "End Date:",
                    name: "leagues.end_date",
                    type: "datetime",
                    format: 'DD/MM/YYYY',
                    def: function () {
                        return new Date();
                    }
                }, {
                    label: "Start Date:",
                    name: "leagues.start_date",
                    type: "datetime",
                    format: 'DD/MM/YYYY',
                    def: function () {
                        return new Date();
                    }
                }

            ]
        });
        /***** INIT TABLE *****/
        leagues_table = $('#leagues-table').DataTable({
            tabIndex: 1,
            pageLength: 20,
            bFilter: false,
            bInfo: false,
            dom: 'Bfrtip',
            ajax: {
                url: '/admin/settings/leagues/index',
                type: "GET"
            },
            columns: [
                {data: null, defaultContent: '', orderable: false, sClass: "selector"},
                {data: "seasons.description", editField: "leagues.season_id"},
                {data: "league_formats.description", editField: "leagues.league_format_id"},
                {data: "leagues.description"},
                {data: "leagues.start_date"},
                {data: "leagues.end_date"},
                {data: null, render: function (data, type, row) {
                        if (row['leagues']['active'] == "1") {
                            return "Active";
                        } else {
                            return "In-Active";
                        }
                    }}
            ],
            columnDefs: [
                {className: "dt-cell-left", targets: [1, 2, 4]}, //Align table body cells to left  
                {className: "dt-cell-center", targets: [6, 4, 5]}, //Align table body cells to left  
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
                        leagues_editor.create({
                            title: '<h3>Add: League</h3>',
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
                        leagues_editor.edit(leagues_table.row({selected: true}).indexes(), {
                            title: '<h3>Edit: League</h3>',
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
                        leagues_editor.title('<h3>Delete: League</h3>').buttons([
                            {label: 'Delete', fn: function () {
                                    this.submit();
                                }},
                            {label: 'Cancel', fn: function () {
                                    this.close();
                                }}
                        ]).message('Are you sure you want to delete this league?').remove(leagues_table.row({selected: true}));
                    }
                }
            ]
        });
        $(leagues_editor.displayNode()).addClass('modal-multi-columns');
        leagues_editor.on('postSubmit', function (e, json, data, action) {
            if ((json.hasOwnProperty('data') && !json.hasOwnProperty('fieldErrors')) || (json.hasOwnProperty('data') && !json.hasOwnProperty('error'))) {
                var key = Object.keys(json['data']);
                var info = json['data'][key];
                switch (action) {
                    case 'create':
                        flash_message('League ' + info['leagues']['description'] + ' has been successfully added', 'success');
                        break;
                    case 'edit':
                        flash_message('League ' + info['leagues']['description'] + ' has been successfully updated', 'success');
                        break;
                    case 'remove':
                        flash_message('League has been successfully removed', 'success');
                        break;
                }
            }
        });

    }); //End of document
</script>