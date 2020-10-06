$.fn.DataTable.Editor.fieldTypes.uploadMany = $.extend(true, {}, $.fn.DataTable.Editor.baseFieldType, {
    create: function (conf) {
        var editor = this;
        var container = _commonUpload(editor, conf, function (val) {
            var selector = $('#' + val[0]).siblings('div.file-detail-container').children('.btn-index'); //conf._val = conf._val.concat(val);
            var idx = $(selector).data('idx');
            $.fn.DataTable.Editor.fieldTypes.uploadMany.set.call(editor, conf, conf._val, idx);
        });

        container.addClass('multi').on('click', 'button.remove', function (e) {
            e.stopPropagation();
            var idx = $(this).data('idx');
            conf._val.splice(idx, 1);
            $.fn.DataTable.Editor.fieldTypes.uploadMany.set.call(editor, conf, conf._val, 0);
        });

        return container;
    },
    get: function (conf) {
        return conf._val;
    },
    set: function (conf, val, idx) {
        console.log(idx);
        // Default value for fields is an empty string, whereas we want []
        if (!val) {
            val = [];
        }

        if (!$.isArray(val)) {
            throw 'Upload collections must have an array as a value';
        }

        conf._val = val;
        var that = this;
        var container = conf._input;
        if (conf.display) {
            var rendered = container.find('div.rendered').empty();
            if (rendered.hasClass('flipster')) {
                rendered.attr('class', 'rendered');
            }
            //console.log(val);
            if (val.length) {
                var list = $('<ul/>').appendTo(rendered);
                $.each(val, function (i, file) {
                    //'temp' in that.file('screenshots', file)
                    list.append(
                            '<li>' +
                            conf.display(file, i) +
                            '<div class="file-detail-container">' +
                            '<span>' +
                            that.file('screenshots', file).filename + 
                            '</span>' +
                            (that.file('screenshots', file).hasOwnProperty('temp') ? '<div class="btn-index remove" data-idx="' + i + '"></div>' : '<button class="btn-index ' + that.classes.form.button + ' remove" data-idx="' + i + '">&times;</button>') +
                            '</div>' +
                            '</li>'
                            );
                });
            } else {
                rendered.append('<span>' + (conf.noFileText || 'No files') + '</span>');
            }
            rendered.flipster({
                style: 'carousel',
                start: ($.isNumeric(idx) ? idx : 'center'),
                buttons: true,
                onItemSwitch: function(currentItem, previousItem){
                    
                }
            });
        }
        conf._input.find('input').triggerHandler('upload.editor', [conf._val]);
    },
    enable: function (conf) {
        conf._input.find('input').prop('disabled', false);
        conf._enabled = true;
    },
    disable: function (conf) {
        conf._input.find('input').prop('disabled', true);
        conf._enabled = false;
    },
    canReturnSubmit: function (conf, node) {
        return false;
    }
});

function _commonUpload(editor, conf, dropCallback) {
    var btnClass = editor.classes.form.button;
    var container = $(
            '<div class="editor_upload">' +
            '<div class="eu_table">' +
            '<div class="row">' +
            '<div class="cell upload">' +
            '<button class="' + btnClass + '" />' +
            '<input type="file"/>' +
            '</div>' +
            '<div class="cell clearValue">' +
            '<button class="' + btnClass + '" />' +
            '</div>' +
            '</div>' +
            '<div class="row second">' +
            '<div class="cell">' +
            '<div class="drop"><span/></div>' +
            '</div>' +
            '<div class="cell">' +
            '<div class="rendered"/>' +
            '</div>' +
            '<div class="display_rendered"/>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>'
            );

    conf._input = container;
    conf._enabled = true;

    _buttonText(conf);

    if (window.FileReader && conf.dragDrop !== false) {
        container.find('div.drop span').text(
                conf.dragDropText || "Drag and drop a file here to upload"
                );

        var dragDrop = container.find('div.drop');
        dragDrop.on('drop', function (e) {
                    if (conf._enabled) {
                        $.fn.DataTable.Editor.upload(editor, conf, e.originalEvent.dataTransfer.files, _buttonText, dropCallback);
                        dragDrop.removeClass('over');
                    }
                    return false;
                }).on('dragleave dragexit', function (e) {
                    if (conf._enabled) {
                        dragDrop.removeClass('over');
                    }
                    return false;
                }).on('dragover', function (e) {
                    if (conf._enabled) {
                        dragDrop.addClass('over');
                    }
                    return false;
                });

        // When an Editor is open with a file upload input there is a
        // reasonable chance that the user will miss the drop point when
        // dragging and dropping. Rather than loading the file in the browser,
        // we want nothing to happen, otherwise the form will be lost.
        editor.on('open', function () {
                    $('body').on('dragover.DTE_Upload drop.DTE_Upload', function (e) {
                        return false;
                    });
                }).on('close', function () {
                    $('body').off('dragover.DTE_Upload drop.DTE_Upload');
                });
    } else {
        container.addClass('noDrop');
        container.append(container.find('div.rendered'));
    }

    container.find('div.clearValue button').on('click', function () {
        $.fn.DataTable.Editor.fieldTypes.upload.set.call(editor, conf, '', null);
    });

    container.find('input[type=file]').on('change', function () {
        $.fn.DataTable.Editor.upload(editor, conf, this.files, _buttonText, function (ids) {
            dropCallback.call(editor, ids);

            // Clear the value so change will happen on the next file select,
            // even if it is the same file
            container.find('input[type=file]').val('');
        });
    });

    return container;
}


function _buttonText(conf, text) {
    if (text === null || text === undefined) {
        text = conf.uploadText || "Choose file...";
    }

    conf._input.find('div.upload button').html(text);
}
