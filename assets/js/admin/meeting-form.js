document.addEventListener('DOMContentLoaded', () => {
    const statusSelect = $('.meeting-status-select').select2();
    const usersSelect = $('.meeting-users-select').select2();

    statusSelect.addEventListener('change', event => {
        handleUserDisabling(event.target, usersSelect);
    });

    handleUserDisabling(statusSelect, usersSelect);
});

function handleUserDisabling(statusSelect, usersSelect) {
    const numericValue = parseInt(statusSelect.val(), 10);
    if (numericValue === 0) {
        usersSelect.disabled = true;
        // eslint-disable-next-line no-return-assign
        Array.from(usersSelect.options).forEach(option => option.selected = false);
    } else {
        usersSelect.prop('disabled', false);
    }
}
