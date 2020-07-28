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