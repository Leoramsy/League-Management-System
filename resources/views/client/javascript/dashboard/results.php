<script>
    var results_table;
    $(document).ready(function () {
        /***** INIT TABLE *****/
        results_table = $('#results-table').DataTable({
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
                    d.type = 'results';
                }
            },
            columns: [
                {data: "home_team.name"},
                {data: "fixtures.home_team_score"},
                {data: null, render: function (data, type, row) {
                        return "vs";
                    }},
                {data: "away_team.name"},
                {data: "fixtures.away_team_score"},
                {data: "match_days.description"}
            ],
            columnDefs: [
                {className: "dt-cell-left", targets: [0, 3]}, //Align table body cells to left      
                {className: "dt-cell-center", targets: [1, 2, 4]}, //Align table body cells to left      
                {searchable: false, targets: 0},
                {visible: false, targets: [5]}
            ],
            language: {
                emptyTable: "No results to show, check back later"
            },
            bLengthChange: false,
            order: [3, 'asc'],
            rowGroup: {
                dataSrc: ["match_days.description", "fixtures.fixture_type"],
                emptyDataGroup: null
            }
        });
    }); //End of document
</script>