<script>
    var fixtures_table;
    $(document).ready(function () {
        /***** INIT TABLE *****/
        fixtures_table = $('#fixtures-table').DataTable({
            processing: true,
            tabIndex: 1,
            pageLength: 20,
            bFilter: false,
            bInfo: false,
            ajax: {
                url: '/match_centre/data',
                type: "GET",
                data: {
                    type: 'fixtures'
                }
            },
            columns: [
                {data: null, defaultContent: '', orderable: false, sClass: "selector"}                
            ],
            columnDefs: [
                {className: "dt-cell-left", targets: [1, 2, 3, 4]}, //Align table body cells to left                
                {searchable: false, targets: 0}
            ],
            order: [1, 'asc'],
            bLengthChange: false,
            select: {
                style: 'single',
                selector: 'td:first-child'
            }
        });
        
    }); //End of document
</script>