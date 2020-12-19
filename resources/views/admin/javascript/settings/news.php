<script>
    var news_table;
    $(document).ready(function () {
        news_editor = new $.fn.dataTable.Editor({
            ajax: {
                create: '/admin/news/add',
                edit: {
                    type: 'PUT',
                    url: '/admin/news/edit/_id_'
                },
                remove: {
                    type: 'DELETE',
                    url: '/admin/news/delete/_id_'
                }
            },
            table: "#news-table",
            template: "#news-editor",
            fields: [
                {
                    label: "Title:",
                    name: "news.title"
                }, {
                    label: "Content:",
                    name: "news.content",
                    type: "quill"
                }, {
                    label: "Published Date:",
                    name: "news.published_date",
                    type: "datetime",
                    format: 'DD/MM/YYYY',
                    def: function () {
                        return new Date();
                    }
                }, {
                    label: "Featured:",
                    name: "news.featured",
                    type: "radio",
                    options: [
                        {label: "Yes", value: 1},
                        {label: "No", value: 0}
                    ],
                    def: 0
                }, {
                    label: "Active:",
                    name: "news.active",
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
        news_table = $('#news-table').DataTable({
            tabIndex: 1,
            pageLength: 20,
            bFilter: false,
            bInfo: false,
            dom: 'Bfrtip',
            ajax: {
                url: '/admin/news/index',
                type: "GET"
            },
            columns: [
                {data: null, defaultContent: '', orderable: false, sClass: "selector"},
                {data: "news.title"},
                {data: null, render: function (data, type, row) {
                        if (row['news']['active'] == "1") {
                            return "Active";
                        } else {
                            return "In-Active";
                        }
                    }},
                {data: null, render: function (data, type, row) {
                        if (row['news']['featured'] == "1") {
                            return "Yes";
                        } else {
                            return "No";
                        }
                    }},
                {data: "news.published_date"},
                {data: 'news.content', render: function (data, type, row) {
                        return "<a href='#' data-toggle='popover' title='Article Content' tabindex='0' data-trigger='hover' data-placement='left' data-content='" + data + "'><i class='fa fa-btn fa-envelope-o'></i></a>";
                    }}
            ],
            columnDefs: [
                {className: "dt-cell-left", targets: [1]}, //Align table body cells to left  
                {className: "dt-cell-center", targets: [2, 3, 4, 5]}, //Align table body cells to left  
                {searchable: false, targets: 0}
            ],
            order: [4, 'desc'],
            bLengthChange: false,
            select: {
                style: 'single',
                selector: 'td:first-child'
            }, buttons: [
                {extend: 'create', text: 'Add', className: "add-news",
                    action: function () {
                        news_editor.create({
                            title: '<h3>Add: Article</h3>',
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
                    extend: 'edit', text: 'Edit', className: "edit-news",
                    action: function () {
                        news_editor.edit(news_table.row({selected: true}).indexes(), {
                            title: '<h3>Edit: Article</h3>',
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
                        news_editor.title('<h3>Delete: Article</h3>').buttons([
                            {label: 'Delete', fn: function () {
                                    this.submit();
                                }},
                            {label: 'Cancel', fn: function () {
                                    this.close();
                                }}
                        ]).message('Are you sure you want to delete this Article?').remove(news_table.row({selected: true}));
                    }
                }
            ]
        });
        $(news_editor.displayNode()).addClass('modal-multi-columns');
        news_editor.on('postSubmit', function (e, json, data, action) {
            if ((json.hasOwnProperty('data') && !json.hasOwnProperty('fieldErrors')) || (json.hasOwnProperty('data') && !json.hasOwnProperty('error'))) {
                var key = Object.keys(json['data']);
                var info = json['data'][key];
                switch (action) {
                    case 'create':
                        flash_message('Article ' + info['news']['title'] + ' has been successfully added', 'success');
                        break;
                    case 'edit':
                        flash_message('Article ' + info['news']['title'] + ' has been successfully updated', 'success');
                        break;
                    case 'remove':
                        flash_message('Article has been successfully removed', 'success');
                        break;
                }
            }
        });
        
        $('body').popover({
            html: true,
            selector: '[data-toggle="popover"]'
        });

    }); //End of document
</script>