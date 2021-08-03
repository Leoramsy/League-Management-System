<script>
    $(document).ready(function () {
        $("#league-select").select2({
            theme: "bootstrap"
        }).on('change', function () {
            fixtures_table.ajax.reload();
            logs_table.ajax.reload();
            results_table.ajax.reload();
            statistics_table.ajax.reload();
        });

        $("#team-select").select2({
            theme: "bootstrap"
        }).on('change', function () {
            fixtures_table.ajax.reload();
            results_table.ajax.reload();
        });

    }); //End of document
</script>