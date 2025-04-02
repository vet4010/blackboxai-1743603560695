define('advanced-pack:views/task/record/detail', ['views/record/detail'], function (Dep) {

    return Dep.extend({

        setup: function () {
            Dep.prototype.setup.call(this);
            
            this.addField('parentTask', {
                type: 'link',
                view: 'advanced-pack:views/fields/parent-task'
            });

            this.addPanel('childTasks', {
                label: 'Child Tasks',
                view: 'advanced-pack:views/task/record/panels/child-tasks',
                hidden: false
            });
        }
    });
});