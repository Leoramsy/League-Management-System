/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/*
 * Request these new columns to be included for the Editor.
 * For now we will overwrite them!
 * @type type
 */
$.extend(true, $.fn.dataTable.Editor.classes, {
    "field": {
        "label": "col-xs-4 col-sm-4 col-md-4 col-lg-4 control-label",
        "input": "col-xs-8 col-sm-8 col-md-8 col-lg-8 controls"
    }
});


(function ($, DataTable) {

    if (!DataTable.ext.editorFields) {
        DataTable.ext.editorFields = {};
    }

    var Editor = DataTable.Editor;
    var _fieldTypes = DataTable.ext.editorFields;

    _fieldTypes.colorpicker = {
        create: function (conf) {
            var that = this;

            conf._enabled = true;

            // Create the elements to use for the input
            conf._input = $(
                    '<div id="' + Editor.safeId(conf.id) + '">' +
                    '<input type="text" class="basic"/>' +
                    '<em id="basic-log"></em>' +
                    '</div>');

            // Use the fact that we are called in the Editor instance's scope to call
            // input.ClassName
            $("input.basic", conf._input).spectrum({
                //color: "#f00",
                change: function (color) {
                    $("#basic-log").text(color.toHexString());
                }
            });
            return conf._input;
        },

        get: function (conf) {
            var val = $("input.basic", conf._input).spectrum("get").toHexString();
            return val;
        },

        set: function (conf, val) {
            $("input.basic", conf._input).spectrum({
                color: val,
                change: function (color) {
                    $("#basic-log").text("change called: " + color.toHexString());
                }
            });
        },

        enable: function (conf) {
            conf._enabled = true;
            $(conf._input).removeClass('disabled');
        },

        disable: function (conf) {
            conf._enabled = false;
            $(conf._input).addClass('disabled');
        }
    };
})(jQuery, jQuery.fn.dataTable);



/*
 $.extend(true, $.fn.dataTable.Editor.classes, {
 
 "header": {
 "wrapper": "DTE_Header modal-header"
 },
 "body": {
 "wrapper": "DTE_Body modal-body"
 },
 "footer": {
 "wrapper": "DTE_Footer modal-footer"
 },
 "form": {
 "tag": "form-horizontal",
 "button": "btn btn-default"
 },
 "field": {
 "wrapper": "DTE_Field",
 "label": "col-sm-4 col-md-4 col-lg-4 control-label",
 "input": "col-sm-8 col-md-8 col-lg-8 controls"
 
 "error": "error has-error",
 "msg-labelInfo": "help-block",
 "msg-info": "help-block",
 "msg-message": "help-block",
 "msg-error": "help-block",
 "multiValue": "well well-sm multi-value",
 "multiInfo": "small",
 "multiRestore": "well well-sm multi-restore"
 
 }
 });
 */