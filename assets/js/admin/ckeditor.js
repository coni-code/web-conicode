
document.addEventListener('DOMContentLoaded', () => {
    // eslint-disable-next-line no-undef
    ClassicEditor
        .create(document.querySelector('#formContent'))
        .then(editor => {
            const hiddenContentField = document.getElementById('hiddenContent');
            editor.setData(document.getElementById('hiddenContent').value);
            editor.model.document.on('change:data', () => {
                document.getElementById('hiddenContent').value = editor.getData();
            });
            hiddenContentField.addEventListener('change', () => {
                editor.setData(document.getElementById('hiddenContent').value);
            });
        })
        .catch(error => {
            console.error(error);
        });
});
