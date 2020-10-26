<script>
    var match_days_table;
    $(document).ready(function () {
        match_days_editor = new $.fn.dataTable.Editor({
            ajax: {
                create: '/admin/settings/match_days/add',
                edit: {
                    type: 'PUT',
                    url: '/admin/settings/match_days/edit/_id_'
                },
                remove: {
                    type: 'DELETE',
                    url: '/admin/settings/match_days/delete/_id_'
                }
            },
            table: "#match_days-table",
            template: "#match_days-editor",
            fields: [
                {
                    label: "Season:",
                    name: "match_days.season_id",
                    type: "select2",
                    opts: {
                        minimumResultsForSearch: 1
                    },
                    def: 0
                }, {
                    label: "Description:",
                    name: "match_days.description"
                }, {
                    label: "Completed:",
                    name: "match_days.completed",
                    type: "radio",
                    options: [
                        {label: "Yes", value: 1},
                        {label: "No", value: 0}
                    ],
                    def: 0
                }, {
                    label: "Start Date:",
                    name: "match_days.start_date",
                    type: "datetime",
                    format: 'DD/MM/YYYY',
                    def: function () {
                        return new Date();
                    }
                }, {
                    label: "End Date:",
                    name: "match_days.end_date",
                    type: "datetime",
                    format: 'DD/MM/YYYY',
                    def: function () {
                        return new Date();
                    }
                }
            ]
        });
        /***** INIT TABLE *****/
        match_days_table = $('#match_days-table').DataTable({
            tabIndex: 1,
            pageLength: 20,
            bFilter: false,
            bInfo: false,
            dom: 'Bfrtip',
            ajax: {
                url: '/admin/settings/match_days/index',
                type: "GET"
            },
            columns: [
                {data: null, defaultContent: '', orderable: false, sClass: "selector"},
                {data: "seasons.description", editField: "match_days.season_id"},
                {data: "match_days.description"},
                {data: "match_days.start_date"},
                {data: "match_days.end_date"},
                {data: null, render: function (data, type, row) {
                        if (row['match_days']['completed'] == "1") {
                            return "Yes";
                        } else {
                            return "No";
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
                        match_days_editor.create({
                            title: '<h3>Add: Match Day</h3>',
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
                        match_days_editor.edit(match_days_table.row({selected: true}).indexes(), {
                            title: '<h3>Edit: Match Day</h3>',
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
                        match_days_editor.title('<h3>Delete: Match Day</h3>').buttons([
                            {label: 'Delete', fn: function () {
                                    this.submit();
                                }},
                            {label: 'Cancel', fn: function () {
                                    this.close();
                                }}
                        ]).message('Are you sure you want to delete this Match Day?').remove(match_days_table.row({selected: true}));
                    }
                }
            ]
        });


        
        $(match_days_editor.displayNode()).addClass('modal-multi-columns');
        match_days_editor.on('postSubmit', function (e, json, data, action) {
            if ((json.hasOwnProperty('data') && !json.hasOwnProperty('fieldErrors')) || (json.hasOwnProperty('data') && !json.hasOwnProperty('error'))) {
                var key = Object.keys(json['data']);
                var info = json['data'][key];
                switch (action) {
                    case 'create':
                        flash_message('Match Day ' + info['match_days']['description'] + ' has been successfully added', 'success');
                        break;
                    case 'edit':
                        flash_message('Match Day ' + info['match_days']['description'] + ' has been successfully updated', 'success');
                        break;
                    case 'remove':
                        flash_message('Match Day has been successfully removed', 'success');
                        break;
                }
            }
        });
    }); //End of document    
</script>