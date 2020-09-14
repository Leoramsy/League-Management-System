<script>
    var formats_table;
    $(document).ready(function () {
        formats_editor = new $.fn.dataTable.Editor({
            ajax: {
                create: '/admin/settings/leagues/formats/add',
                edit: {
                    type: 'PUT',
                    url: '/admin/settings/leagues/formats/edit/_id_'
                },
                remove: {
                    type: 'DELETE',
                    url: '/admin/settings/leagues/formats/delete/_id_'
                }
            },
            table: "#formats-table",
            template: "#formats-editor",
            fields: [
                {
                    label: "League Format:",
                    name: "league_formats.description"
                }, {
                    label: "Unique Name:",
                    name: "league_formats.slug"
                }
            ]
        });
        /***** INIT TABLE *****/
        formats_table = $('#formats-table').DataTable({
            tabIndex: 1,
            pageLength: 20,
            bFilter: false,
            bInfo: false,
            dom: 'Bfrtip',
            ajax: {
                url: '/admin/settings/leagues/formats/index',
                type: "GET"
            },
            columns: [
                {data: null, defaultContent: '', orderable: false, sClass: "selector"},
                {data: "league_formats.description"},
                {data: "league_formats.slug"}
            ],
            columnDefs: [
                {className: "dt-cell-left", targets: [1, 2]}, //Align table body cells to left  
                {className: "dt-cell-center", targets: []}, //Align table body cells to left  
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
                        formats_editor.create({
                            title: '<h3>Add: League Format</h3>',
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
                        formats_editor.edit(formats_table.row({selected: true}).indexes(), {
                            title: '<h3>Edit: League Format</h3>',
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
                        formats_editor.title('<h3>Delete: League Format</h3>').buttons([
                            {label: 'Delete', fn: function () {
                                    this.submit();
                                }},
                            {label: 'Cancel', fn: function () {
                                    this.close();
                                }}
                        ]).message('Are you sure you want to delete this format?').remove(formats_table.row({selected: true}));
                    }
                }
            ]
        });
        $(formats_editor.displayNode()).addClass('modal-multi-columns');
        formats_editor.on('postSubmit', function (e, json, data, action) {
            if ((json.hasOwnProperty('data') && !json.hasOwnProperty('fieldErrors')) || (json.hasOwnProperty('data') && !json.hasOwnProperty('error'))) {
                var key = Object.keys(json['data']);
                var info = json['data'][key];
                switch (action) {
                    case 'create':
                        flash_message('League Format ' + info['league_formats']['description'] + ' has been successfully added', 'success');
                        break;
                    case 'edit':
                        flash_message('League Format ' + info['league_formats']['description'] + ' has been successfully updated', 'success');
                        break;
                    case 'remove':
                        flash_message('League Format has been successfully removed', 'success');
                        break;
                }
            }
        });

    }); //End of document
</script>