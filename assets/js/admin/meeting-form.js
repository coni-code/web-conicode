document.addEventListener('DOMContentLoaded', () => {
    const statusSelect = $('.meeting-status-select').select2();
    const usersSelect = $('.meeting-users-select').select2();

    statusSelect.on('change', () => {
        handleUserDisabling(statusSelect, usersSelect);
    });

    handleUserDisabling(statusSelect, usersSelect);
});

function handleUserDisabling(statusSelect, usersSelect) {
    const numericValue = parseInt(statusSelect.val(), 10);
    if (numericValue === 0) {
        usersSelect.prop('disabled', true);
        usersSelect.val(null).trigger('change');
    } else {
        usersSelect.prop('disabled', false);
    }
}
