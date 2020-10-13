<script>
    var seasons_table;
    $(document).ready(function () {
        seasons_editor = new $.fn.dataTable.Editor({
            ajax: {
                create: '/admin/settings/seasons/add',
                edit: {
                    type: 'PUT',
                    url: '/admin/settings/seasons/edit/_id_'
                },
                remove: {
                    type: 'DELETE',
                    url: '/admin/settings/seasons/delete/_id_'
                }
            },
            table: "#seasons-table",
            template: "#seasons-editor",
            fields: [
                {
                    label: "League Name:",
                    name: "seasons.league_id",
                    type: "select2",
                    opts: {
                        minimumResultsForSearch: 2
                    },
                    def: 0
                }, {
                    label: "Season Name:",
                    name: "seasons.description"
                }, {
                    label: "Start Date",
                    name: "seasons.start_date",
                    type: "datetime",
                    format: 'DD/MM/YYYY',
                    def: function () {
                        return new Date();
                    }
                }, {
                    label: "End Date:",
                    name: "seasons.end_date",
                    type: "datetime",
                    format: 'DD/MM/YYYY',
                    def: function () {
                        return new Date();
                    }
                }, {
                    label: "Active:",
                    name: "seasons.active",
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
        seasons_table = $('#seasons-table').DataTable({
            tabIndex: 1,
            pageLength: 20,
            bFilter: false,
            bInfo: false,
            dom: 'Bfrtip',
            ajax: {
                url: '/admin/settings/seasons/index',
                type: "GET"
            },
            columns: [
                {data: null, defaultContent: '', orderable: false, sClass: "selector"},
                {data: "leagues.description", editField: "seasons.league_id"},
                {data: "seasons.description"},
                {data: "seasons.start_date"},
                {data: "seasons.end_date"},
                {data: null, render: function (data, type, row) {
                        if (row['seasons']['active'] == "1") {
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
                        seasons_editor.create({
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
                        seasons_editor.edit(seasons_table.row({selected: true}).indexes(), {
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
                        seasons_editor.title('<h3>Delete: Season</h3>').buttons([
                            {label: 'Delete', fn: function () {
                                    this.submit();
                                }},
                            {label: 'Cancel', fn: function () {
                                    this.close();
                                }}
                        ]).message('Are you sure you want to delete this season?').remove(seasons_table.row({selected: true}));
                    }
                }
            ]
        });
        $(seasons_editor.displayNode()).addClass('modal-multi-columns');
        seasons_editor.on('postSubmit', function (e, json, data, action) {
            if ((json.hasOwnProperty('data') && !json.hasOwnProperty('fieldErrors')) || (json.hasOwnProperty('data') && !json.hasOwnProperty('error'))) {
                var key = Object.keys(json['data']);
                var info = json['data'][key];
                switch (action) {
                    case 'create':
                        flash_message('Season ' + info['seasons']['description'] + ' has been successfully added', 'success');
                        break;
                    case 'edit':
                        flash_message('Season ' + info['seasons']['description'] + ' has been successfully updated', 'success');
                        break;
                    case 'remove':
                        flash_message('Season has been successfully removed', 'success');
                        break;
                }
            }
        });

    }); //End of document
</script>