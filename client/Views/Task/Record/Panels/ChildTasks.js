define('advanced-pack:views/task/record/panels/child-tasks', ['views/record/panels/relationship'], function (Dep) {

    return Dep.extend({

        template: 'advanced-pack:task/record/panels/child-tasks',

        setup: function () {
            Dep.prototype.setup.call(this);
            
            this.listenTo(this.model, 'change:parentId', function () {
                this.collection.fetch();
            }, this);
        },

        actionCreateRelated: function () {
            this.createView('quickCreate', 'views/modals/edit-with-cancel', {
                scope: 'Task',
                attributes: {
                    parentId: this.model.id,
                    parentName: this.model.get('name')
                }
            }, function (view) {
                view.render();
                this.listenToOnce(view, 'after:save', function () {
                    this.collection.fetch();
                }, this);
            });
        },

        getCreateAttributes: function () {
            return {
                parentId: this.model.id,
                parentName: this.model.get('name')
            };
        }
    });
});