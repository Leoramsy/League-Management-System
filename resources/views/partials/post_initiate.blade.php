<script>
    /**
     * https://github.com/RobinHerbots/Inputmask
     */
    var currency_mask, volume_mask, mass_mask, numeric_mask;
    $(document).ready(function () {
        currency_mask = new Inputmask({
            prefix: "{{$currency_indicator ?? ''}}",
            digitsOptional: false,
            digits: 2,
            autoGroup: true,
            groupSeparator: ',',
            alias: 'numeric',
            removeMaskOnSubmit: true,
            autoUnmask: true
        });
        volume_mask = new Inputmask({
            prefix: ' ',
            suffix: " L",
            digitsOptional: false,
            digits: 0,
            autoGroup: true,
            groupSeparator: ',',
            alias: 'numeric',
            removeMaskOnSubmit: true,
            autoUnmask: true
        });
        mass_mask = new Inputmask({
            prefix: ' ',
            suffix: " KG",
            digitsOptional: false,
            digits: 0,
            autoGroup: true,
            groupSeparator: ',',
            alias: 'numeric',
            removeMaskOnSubmit: true,
            autoUnmask: true
        });
        numeric_mask = new Inputmask({
            prefix: ' ',
            digitsOptional: false,
            digits: 2,
            autoGroup: true,
            groupSeparator: ',',
            alias: 'numeric',
            removeMaskOnSubmit: true,
            autoUnmask: true
        });
        currency_mask.mask(document.querySelectorAll('.editor-input-mask-currency input'));
        currency_mask.mask(document.querySelectorAll('.input-mask-currency'));
        volume_mask.mask(document.querySelectorAll('.input-mask-volume'));
        mass_mask.mask(document.querySelectorAll('.input-mask-mass'));
        numeric_mask.mask(document.querySelectorAll('.input-mask-numeric'));
    });
</script>