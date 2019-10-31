<script>
    var teams_table;
    $(document).ready(function () {
        /***** INIT TABLE *****/
        teams_table = $('#teams-table').DataTable({
            serverSide: true,
            processing: true,
            tabIndex: 1,
            pageLength: 20,
            bFilter: false,
            bInfo: false,
            rowId: 'id',
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