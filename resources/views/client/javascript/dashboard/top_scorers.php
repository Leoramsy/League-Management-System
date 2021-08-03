<script>
    var top_scorers_table;
    $(document).ready(function () {
        /***** INIT TABLE *****/
        top_scorers_table = $('#top-scorers-table').DataTable({
            processing: true,
            tabIndex: 1,
            paging: false,
            bFilter: false,
            pageLength: 5,
            bInfo: false,
            targets: 'no-sort',
            bSort: false,
            ajax: {
                url: '/data',
                type: "GET",
                data: function (d) {
                    d.league_id = $("#league-select").val();
                    d.type = 'top_scorers';
                }
            },
            columns: [
                {data: "players.name"},
                {data: "teams.name"},
                {data: "fixture_goals.games"},
                {data: "fixture_goals.goals"}
            ],
            columnDefs: [
                {className: "dt-cell-left", targets: [0, 1]}, //Align table body cells to left      
                {className: "dt-cell-center", targets: [2, 3]}, //Align table body cells to left      
                {searchable: false, targets: 0}
            ],
            language: {
                emptyTable: "No Top Goal Scorers to show, check back later"
            },
            bLengthChange: false,
            order: [[3, 'desc'],[0, 'asc']]
        });

    }); //End of document
</script>