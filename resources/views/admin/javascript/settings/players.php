<script>
    var players_table;
    $(document).ready(function () {
        players_editor = new $.fn.dataTable.Editor({
            ajax: {
                create: '/admin/settings/players/add',
                edit: {
                    type: 'PUT',
                    url: '/admin/settings/players/edit/_id_'
                },
                upload: {
                    type: 'GET',
                    url: '/admin/settings/players/image'
                },
                remove: {
                    type: 'DELETE',
                    url: '/admin/settings/players/delete/_id_'
                }
            },
            table: "#players-table",
            template: "#players-editor",
            fields: [
                {
                    label: "Position:",
                    name: "players.position_id",
                    type: "select2",
                    def: 0
                }, {
                    label: "Name:",
                    name: "players.name"
                }, {
                    label: "Surname:",
                    name: "players.surname"
                }, {
                    label: "Image:",
                    name: "players.image",
                    type: "upload",
                    display: function (file_id) {
                        return '<img src="' + players_editor.file('files', file_id).web_path + '"/>';
                    },
                    clearText: "Clear",
                    noImageText: 'No image'
                }, {
                    label: "Nick-Name:",
                    name: "players.nick_name"
                }, {
                    label: "ID No:",
                    name: "players.id_number"
                }, {
                    label: "Active:",
                    name: "players.active",
                    type: "radio",
                    options: [
                        {label: "Yes", value: 1},
                        {label: "No", value: 0}
                    ],
                    def: 1
                }, {
                    label: "Teams:",
                    name: "team_players[].team_id",
                    type: "select2",
                    opts: {
                        multiple: true,
                        allowClear: true,
                        minimumResultsForSearch: 1
                    }
                }, {
                    label: "Date of Birth:",
                    name: "players.date_of_birth",
                    type: "datetime",
                    format: 'DD/MM/YYYY',
                    def: function () {
                        return new Date();
                    }
                }
            ]
        });
        /***** INIT TABLE *****/
        players_table = $('#players-table').DataTable({
            tabIndex: 1,
            pageLength: 20,
            bFilter: false,
            bInfo: false,
            dom: 'Bfrtip',
            ajax: {
                url: '/admin/settings/players/index',
                type: "GET"
            },
            columns: [
                {data: null, defaultContent: '', orderable: false, sClass: "selector"},
                {data: "players.name"},
                {data: "players.surname"},
                {data: "players.nick_name"},
                {data: "positions.description", editField: "players.position_id"},
                {data: "players.date_of_birth"},
                {data: null, render: function (data, type, row) {
                        if (row['players']['active'] == "1") {
                            return "Active";
                        } else {
                            return "In-Active";
                        }
                    }}
            ],
            columnDefs: [
                {className: "dt-cell-left", targets: [1, 2, 3, 4]}, //Align table body cells to left  
                {className: "dt-cell-center", targets: [6, 5]}, //Align table body cells to left  
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
                        players_editor.create({
                            title: '<h3>Add: Player</h3>',
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
                        players_editor.edit(players_table.row({selected: true}).indexes(), {
                            title: '<h3>Edit: Player</h3>',
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
                        players_editor.title('<h3>Delete: Player</h3>').buttons([
                            {label: 'Delete', fn: function () {
                                    this.submit();
                                }},
                            {label: 'Cancel', fn: function () {
                                    this.close();
                                }}
                        ]).message('Are you sure you want to delete this league?').remove(players_table.row({selected: true}));
                    }
                }
            ]
        });
        $(players_editor.displayNode()).addClass('modal-multi-columns');
        players_editor.on('postSubmit', function (e, json, data, action) {
            if ((json.hasOwnProperty('data') && !json.hasOwnProperty('fieldErrors')) || (json.hasOwnProperty('data') && !json.hasOwnProperty('error'))) {
                var key = Object.keys(json['data']);
                var info = json['data'][key];
                switch (action) {
                    case 'create':
                        flash_message('Player ' + info['players']['name'] + ' has been successfully added', 'success');
                        break;
                    case 'edit':
                        flash_message('Player ' + info['players']['name'] + ' has been successfully updated', 'success');
                        break;
                    case 'remove':
                        flash_message('Player has been successfully removed', 'success');
                        break;
                }
            }
        });

    }); //End of document
</script>