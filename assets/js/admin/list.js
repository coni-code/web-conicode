document.addEventListener('DOMContentLoaded', () => {
    const table = document.querySelector('.base-table');

    if (!table) {
        return;
    }

    const elementName = table.getAttribute('data-element-name');

    if (!elementName) {
        return;
    }

    const rows = table.querySelectorAll('.base-row');

    rows.forEach(row => {
        const detailsPath = row.getAttribute('data-details-path');

        if (detailsPath) {
            row.addEventListener('click', () => {
                window.location.href = detailsPath;
            });
        }

        const deleteBtn = row.querySelector('.delete-btn');

        if (deleteBtn) {
            deleteBtn.addEventListener('click', event => {
                event.stopPropagation();

                const deletePath = deleteBtn.getAttribute('data-delete-url');

                if (!deletePath) {
                    return;
                }

                const deleteUrl = `${window.location.origin}${deletePath}`;

                fetch(deleteUrl, {
                    method: 'POST',
                }).then(() => {
                    window.location.reload();
                }).catch(error => {
                    console.error('Error:', error);
                });
            });
        }
    });
});
