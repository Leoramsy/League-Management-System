<script>
    var teams_table;
    $(document).ready(function () {
        teams_editor = new $.fn.dataTable.Editor({
            ajax: {
                create: '/admin/settings/teams/add',
                edit: {
                    type: 'PUT',
                    url: '/admin/settings/teams/edit/_id_'
                },
                remove: {
                    type: 'DELETE',
                    url: '/admin/settings/teams/delete/_id_'
                }
            },
            table: "#teams-table",
            template: "#teams-editor",
            fields: [
                {
                    label: "Team Name:",
                    name: "teams.name"
                }, {
                    label: "Nick Name:",
                    name: "teams.nick_name"
                }, {
                    label: "Contact Person",
                    name: "teams.contact_person"
                }, {
                    label: "Phone Number:",
                    name: "teams.phone_number"
                }, {
                    label: "Email:",
                    name: "teams.email"
                }, {
                    label: "Home Color:",
                    name: "teams.home_color_id",
                    type: "select2"
                }, {
                    label: "Away Color:",
                    name: "teams.away_color_id",
                    type: "select2"
                }, {
                    label: "Home Ground:",
                    name: "teams.home_ground"
                }, {
                    label: "Active:",
                    name: "teams.active",
                    type: "radio",
                    options: [
                        {label: "Yes", value: 1},
                        {label: "No", value: 0}
                    ],
                    def: 1
                }
            ]
        });
        /***** INIT TABLE *****/
        teams_table = $('#teams-table').DataTable({
            serverSide: true,
            tabIndex: 1,
            pageLength: 20,
            bFilter: false,
            bInfo: false,
            rowId: 'id',
            dom: 'Bfrtip',
            ajax: {
                url: '/admin/settings/teams/index',
                type: "GET"
            },
            columns: [
                {data: null, defaultContent: '', orderable: false, sClass: "selector"},
                {data: "teams.name"},
                {data: "teams.nick_name"},
                {data: "teams.contact_person"},
                {data: "teams.phone_number"},
                {data: "teams.email"},
                {data: "teams.home_colours"},
                {data: "teams.away_colours"},
                {data: "teams.home_ground"},
                {data: "teams.active"}
            ],
            columnDefs: [
                {className: "dt-cell-left", targets: [1, 2, 3, 4, 5, 6, 7, 8]}, //Align table body cells to left  
                {className: "dt-cell-center", targets: [9]}, //Align table body cells to left  
                {searchable: false, targets: 0}
            ],
            order: [1, 'asc'],
            bLengthChange: false,
            select: {
                style: 'single',
                selector: 'td:first-child'
            }, buttons: [
                {extend: 'create', text: 'Add', className: "add-team",
                    action: function () {
                        teams_editor.create({
                            title: '<h3>Add: Team</h3>',
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
                    extend: 'edit', text: 'Edit', className: "edit-team",
                    action: function () {
                        teams_editor.edit(teams_table.row({selected: true}).indexes(), {
                            title: '<h3>Edit: Team</h3>',
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
                        teams_editor.title('<h3>Delete: Team</h3>').buttons([
                            {label: 'Delete', fn: function () {
                                    this.submit();
                                }},
                            {label: 'Cancel', fn: function () {
                                    this.close();
                                }}
                        ]).message('Are you sure you want to delete this team?').remove(teams_table.row({selected: true}));
                    }
                }
            ]
        });        
        $(teams_editor.displayNode()).addClass('modal-multi-columns');

    }); //End of document
</script>