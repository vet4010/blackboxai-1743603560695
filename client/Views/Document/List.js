define('advanced-pack:views/document/list', ['views/list'], function (Dep) {

    return Dep.extend({

        template: 'advanced-pack:document/list',

        rowActionsView: 'advanced-pack:views/document/record/row-actions',

        setup: function () {
            Dep.prototype.setup.call(this);
            this.addMenuItem('buttons', {
                action: 'upload',
                html: this.translate('Upload', 'labels', 'Document'),
                className: 'btn btn-default'
            });
        },

        actionUpload: function () {
            this.createView('quickCreate', 'views/modals/edit-with-cancel', {
                scope: 'Document',
                attributes: {
                    assignedUserId: this.getUser().id
                }
            }, function (view) {
                view.render();
                this.listenToOnce(view, 'after:save', function () {
                    this.collection.fetch();
                }, this);
            });
        },

        getRowActions: function () {
            return [{
                action: 'download',
                label: 'Download',
                data: {
                    id: this.model.id
                }
            }];
        }
    });
});