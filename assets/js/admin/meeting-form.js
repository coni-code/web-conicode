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
    usersSelect.disabled = numericValue === 0;
}
