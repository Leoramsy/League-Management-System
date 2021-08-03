<script>
    $(document).ready(function () {
        /*
         * Select2
         */
        $("#league-select").select2({
            theme: "bootstrap"
        }).on('change', function () {
            fixtures_table.ajax.reload();
            logs_table.ajax.reload();
            results_table.ajax.reload();
            top_scorers_table.ajax.reload();
        });

    }); //End of document
</script>