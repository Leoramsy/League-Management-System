<script>
    var teams_table;
    $(document).ready(function () {
        teams_editor = new $.fn.dataTable.Editor({
            ajax: {
                create: '/admin/teams/add',
                edit: {
                    type: 'PUT',
                    url: '/admin/teams/edit/_id_'
                },
                remove: {
                    type: 'DELETE',
                    url: '/admin/teams/delete/_id_'
                }
            },
            table: "#teams-table",            
            idSrc: 'id',
            fields: [
                {
                    label: "Team Name:",
                    name: "name"
                }, {
                    label: "Nick Name:",
                    name: "nick_name"
                }, {
                    label: "Contact Person",
                    name: "contact_person"
                }, {
                    label: "Phone Number:",
                    name: "phone_number"
                }, {
                    label: "Email:",
                    name: "email"
                }, {
                    label: "Home Colours:",
                    name: "home_colours"
                }, {
                    label: "Away Colours:",
                    name: "away_colours"
                }, {
                    label: "Home Ground:",
                    name: "home_ground"
                }, {
                    label: "Active:",
                    name: "active",
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
                url: '/admin/teams',
                type: "GET"
            },
            columns: [
                {data: null, defaultContent: '', orderable: false, sClass: "selector"},
                {data: "name"},
                {data: "nick_name"},
                {data: "contact_person"},
                {data: "phone_number"},
                {data: "email"},
                {data: "home_colours"},
                {data: "away_colours"},
                {data: "home_ground"},
                {data: "active_indicator"}
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

    }); //End of document
</script>