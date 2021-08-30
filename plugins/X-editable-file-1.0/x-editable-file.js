/**
 File editable input.

 @class file
 @extends abstractinput
 @experimental
 @example
 <a href="#" id="file" data-type="file" data-pk="1" data-value="filename.jpg"></a>

<script>
    $('#file').editable({
        url: '/post',
        type: 'file',
        pk: 1,
        inputclass: '',
        method: 'POST',
        name: 'file',
        buttonLabel: 'Chose file',
        maxFilenameLength: 50,
        allowDelete: true,
        deleteLabel: 'Delete'
    });
</script>
 **/

(function ($) {

    "use strict";

    var File = function (options) {
        this.init('file', options, File.defaults);
    };

    //inherit from Abstract input
    $.fn.editableutils.inherit(File, $.fn.editabletypes.abstractinput);

    $.extend(File.prototype, {
        render: function() {
            var self = this;
            this.$input = this.$tpl.find('input');

            this.$input.filter('[name="file"]').bind('change focus click', function() {
                var filename = self.getFilename($(this).val());
                self.setFilename(filename);
                self.fileSelected = true;
            });

            if(this.options.onlyDelete) {

                this.$tpl.closest('button, .editable-filename, .editable-file').css('display', 'none');
                this.options.allowDelete = true;

            } else {

                this.$tpl.find('button').text(this.options.buttonLabel);

            }

            if(this.options.allowDelete) {

                this.$tpl.parent().append(this.getDeleteHtml());

            }

            if($.fn.editableform.engine === 'bs3') {
                this.$tpl.find('button').addClass('btn btn-default');
            }

            if(this.options.inputclass) {
                this.$tpl.find('button').addClass(this.options.inputclass);
            }
        },
        value2html: function(value, element) {
            if(!value) {
                $(element).empty();
                return;
            }

            if(this.withDeleting) {

                value = '';

            }

            $(element).html(value);
        },
        value2input: function(value) {
            if(!value) {
                return;
            }
            this.$input.filter('[name="file"]').val(value.file);
        },
        input2value: function() {
            return this.getFullFilename(this.$input.filter('[name="file"]').val());
        },
        activate: function() {

            var self = this;
            this.withDeleting = false;
            $(this.options.scope).editable('option', 'savenochange', true );
            $(this.options.scope).editable('option', 'ajaxOptions', {
                dataType: 'json',
                contentType: false,
                processData: false,
                type: this.options.method,
                success: function(response) {

                    self.fileSelected = false;

                }
            });
            $(this.options.scope).editable('option', 'params', function(){

                var form = self.$tpl.closest('form').get(0);
                var formData = new FormData(form);
                var deleteFlag = formData.get('delete');

                if(!self.fileSelected || deleteFlag == 1) {

                    formData.delete('file');

                }

                if(deleteFlag) {

                    self.withDeleting = true;

                }

                formData.append('pk', $(self.options.scope).data('pk'));
                formData.append('name', self.options.name);

                if(typeof self.options.formData === 'function') {
                    formData = self.options.formData.call(self.options.scope, formData);
                }

                return formData;

            });

        },
        getFullFilename: function(path) {

            return path.split(/[\/\\]/).pop();

        },
        getFilename: function(path) {

            var filename = this.getFullFilename(path);
            var maxLength = this.options.maxFilenameLength;

            if(filename.length > maxLength) {

                filename = filename.substr(0, maxLength) +'..';

            }

            return filename;

        },
        getDeleteHtml: function() {

            var label = this.options.deleteLabel;
            return ['<div class="editable-delete-file">',
                    '<label><input name="delete" type="checkbox" value="1"> '+ label +'</label>',
                    '</div>'].join('');

        },
        setFilename: function(filename) {

            if(filename) {

                $(this.$tpl[1]).text(filename);

            }

        },
        fileSelected: false,
        withDeleting: false
    });

    File.defaults = $.extend({}, $.fn.editabletypes.abstractinput.defaults, {
        tpl: [
            '<div class="editable-file">',
            '<span style="position:relative; display: inline-block; overflow: hidden; cursor: pointer;">',
            '<input type="file" name="file" class="input-small" size="1" style="opacity: 0;filter: alpha(opacity=0); cursor: pointer; font-size: 400%; height: 600%; position: absolute; top: 0; right: 0; width: 240%" />',
            '<button class="btn btn-sm" type="button" style="cursor: pointer; display: inline-block; margin-right: 5px;"></button>',
            '</span></div>',
            '<div class="editable-filename"></div>'
        ].join(''),

        inputclass: '',
        method: 'POST',
        name: 'file',
        buttonLabel: 'Chose file',
        maxFilenameLength: 50,
        allowDelete: true,
        onlyDelete: false,
        deleteLabel: 'Delete',
        formData: null
    });

    $.fn.editabletypes.file = File;

}(window.jQuery));
