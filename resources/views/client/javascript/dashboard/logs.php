<script>
    var fixtures_table;
    $(document).ready(function () {
        /***** INIT TABLE *****/
        fixtures_table = $('#logs-table').DataTable({
            processing: true,
            tabIndex: 1,
            paging: false,
            bFilter: false,
            bInfo: false,
            targets: 'no-sort',
            bSort: false,
            ajax: {
                url: '/data',
                type: "GET",
                data: function (d) {
                    d.league_id = $("#league-select").val();
                    d.type = 'logs';
                }
            },
            columns: [
                {data: "fixtures.position"},
                {data: "teams.name"},
                {data: "fixtures.played"},
                {data: "fixtures.won"},
                {data: "fixtures.draw"},
                {data: "fixtures.lost"},
                {data: "fixtures.points"}
            ],
            columnDefs: [
                {className: "dt-cell-left", targets: [1]}, //Align table body cells to left      
                {className: "dt-cell-center", targets: [0, 2, 3, 4, 5, 6]}, //Align table body cells to left      
                {searchable: false, targets: 0}
            ],
            bLengthChange: false,
            order: [0, 'asc']
        });

    }); //End of document
</script>