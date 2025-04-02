define('advanced-pack:views/document/record/edit', ['views/record/edit'], function (Dep) {

    return Dep.extend({

        setup: function () {
            Dep.prototype.setup.call(this);

            this.listenTo(this.model, 'after:save', function () {
                if (this.model.get('fileId')) {
                    this.hideField('file');
                }
            }, this);

            this.setupFileUpload();
        },

        setupFileUpload: function () {
            this.addField('file', {
                view: 'advanced-pack:views/fields/file-upload',
                required: this.model.isNew()
            });
        }
    });
});