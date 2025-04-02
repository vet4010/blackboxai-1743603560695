define('advanced-pack:views/fields/parent-task', ['views/fields/link'], function (Dep) {

    return Dep.extend({

        select: function (model) {
            var self = this;
            this.createView('dialog', 'views/modals/select-records', {
                scope: 'Task',
                createButton: false,
                primaryFilterName: 'notChildren',
                primaryFilterData: {
                    id: this.model.id
                }
            }, function (view) {
                view.render();
                this.listenToOnce(view, 'select', function (model) {
                    self.model.set({
                        parentId: model.id,
                        parentName: model.get('name')
                    });
                    view.close();
                }, this);
            });
        }
    });
});