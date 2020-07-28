/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 * 
 * https://bootsnipp.com/snippets/featured/form-wizard-using-tabs
 */
$(document).ready(function () {
    $('.nav-tabs > li a[title]').tooltip();
    //Wizard
    $('a[data-toggle="tab"]').on('show.bs.tab', function (e) {
        var $target = $(e.target);
        if ($target.parent().hasClass('disabled')) {
            return false;
        }        
        if ($target.parent().is(':last-child')) {
            var table_id = $('table').attr('id');
            var datatable = $('#' + table_id).DataTable();
            var editor = datatable.editor();
            $("editor-field").each(function () {
                var value = '';
                var name = $(this).attr("name");
                var editor_field = editor.field(name);                
                var node = editor_field.input();
                var selector = name.replace(".", "_");
                switch (true) {
                    case node.is("select"):
                        value = editor_field.displayed() && editor_field.val() != null ? editor_field.inst().select2('data')[0].text : '';
                        break;
                    case (node.is("input[type=text]") || node.is("textarea")):
                        value = editor_field.displayed() ? editor_field.val() : ''; //node.inputmask("hasMaskedValue") ? "TEST" : editor_field.val();
                        break;
                    case node.is("input[type=radio]"):
                        value = editor_field.displayed() ? $("input[name='" + name + "']:checked").siblings('label').html() : '';
                        break;
                }
                if ($('#summary_' + selector + ' > span').hasClass('input-mask')) {
                    //Apply formatting 
                    $('#summary_' + selector + ' > span').empty().html(value ? splitMille(value) : 0);
                } else {
                    $('#summary_' + selector + ' > span').empty().html(value);
                }
            }).get();
        }


        if (!$target.parent().hasClass('disabled')) {
            var $active = $('.wizard .nav-tabs li.active');
            $active.removeClass('active');
            $target.parent().addClass('active');
        }
    });

    $(".next-step").click(function (e) {
        var $active = $('.wizard .nav-tabs li.active');
        $active.removeClass('active');
        $active.next().removeClass('disabled').addClass('active');
        nextTab($active);
    });

    $(".prev-step").click(function (e) {
        var $active = $('.wizard .nav-tabs li.active');
        $active.removeClass('active');
        $active.prev().addClass('active');
        prevTab($active);
    });

});

function firstTab() {
    $("#wiz_nav_tab li:first-child").find('a[data-toggle="tab"]').click();
}

function nextTab(elem) {
    $(elem).next().find('a[data-toggle="tab"]').click();
}
function prevTab(elem) {
    $(elem).prev().find('a[data-toggle="tab"]').click();
}

function splitMille(n, separator = ',') {
    // Cast to string
    let num = (n + '');

    // Test for and get any decimals (the later operations won't support them)
    let decimals = '';
    if (/\./.test(num)) {
        // This regex grabs the decimal point as well as the decimal numbers
        decimals = num.replace(/^.*(\..*)$/, '$1');
    }

    // Remove decimals from the number string
    num = num.replace(decimals, '')
            // Reverse the number string through Array functions
            .split('').reverse().join('')
            // Split into groups of 1-3 characters (with optional supported character "-" for negative numbers)
            .match(/[0-9]{1,3}-?/g)
            // Add in the mille separator character and reverse back
            .join(separator).split('').reverse().join('');

    // Put the decimals back and output the formatted number
    return `${num}${decimals}`;
}