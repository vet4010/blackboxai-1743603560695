define('advanced-pack:views/fields/file-upload', ['views/fields/base'], function (Dep) {

    return Dep.extend({

        template: 'advanced-pack:fields/file-upload',

        events: {
            'change [data-action="upload"]': function (e) {
                this.uploadFile(e.target.files[0]);
            }
        },

        uploadFile: function (file) {
            if (!file) return;

            let formData = new FormData();
            formData.append('file', file);

            this.notify('Uploading...');
            this.$('[data-action="upload"]').prop('disabled', true);

            $.ajax({
                url: 'Document/action/upload',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-File-Name': file.name,
                    'X-File-Type': file.type,
                    'X-File-Size': file.size
                }
            }).done(function (data) {
                this.model.set({
                    fileId: data.fileId,
                    file: {
                        name: data.name,
                        id: data.fileId
                    }
                });
                this.notify('Uploaded', 'success');
            }.bind(this)).fail(function () {
                this.notify('Upload failed', 'error');
            }.bind(this)).always(function () {
                this.$('[data-action="upload"]').prop('disabled', false);
            }.bind(this));
        }
    });
});