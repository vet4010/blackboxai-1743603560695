define('advanced-pack:views/document/record/row-actions', ['views/record/row-actions/default'], function (Dep) {

    return Dep.extend({

        getActionList: function () {
            var list = Dep.prototype.getActionList.call(this);
            
            if (this.model.get('fileId')) {
                list.unshift({
                    action: 'download',
                    label: 'Download',
                    data: {
                        id: this.model.id
                    }
                });
            }

            return list;
        },

        actionDownload: function (data) {
            window.open(`Document/action/download?id=${data.id}`, '_blank');
        }
    });
});