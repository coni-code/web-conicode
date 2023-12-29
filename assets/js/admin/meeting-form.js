document.addEventListener('DOMContentLoaded', () => {
    const statusSelect = document.querySelector('.meeting-status-select');
    const usersSelect = document.querySelector('.meeting-users-select');

    statusSelect.addEventListener('change', (event) => {
        handleUserDisabling(event.target, usersSelect);
    })

    handleUserDisabling(statusSelect, usersSelect);
})

function handleUserDisabling(statusSelect, usersSelect) {
    const numericValue = parseInt(statusSelect.value, 10);
    if (numericValue === 0) {
        usersSelect.disabled = true;
        Array.from(usersSelect.options).forEach(option => option.selected = false);
    } else {
        usersSelect.disabled = false;
    }
}
