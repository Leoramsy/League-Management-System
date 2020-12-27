<script>
    $(document).ready(function () {
        $("#league-select").change(function () {
            fixtures_table.ajax.reload();
            logs_table.ajax.reload();
            results_table.ajax.reload();
        });

        $("#team-select").change(function () {
            fixtures_table.ajax.reload();
            results_table.ajax.reload();
        });

    }); //End of document
</script>