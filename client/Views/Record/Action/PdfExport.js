define('advanced-pack:views/record/action/pdf-export', ['view'], function (Dep) {

    return Dep.extend({

        template: 'advanced-pack:record/action/pdf-export',

        events: {
            'click [data-action="exportPdf"]': function () {
                this.exportPdf();
            }
        },

        exportPdf: function () {
            let model = this.model;
            let url = `${model.name}/${model.id}/pdf`;

            this.createView('dialog', 'advanced-pack:views/modals/pdf-export', {
                url: url
            }, function (view) {
                view.render();
            });
        }
    });
});