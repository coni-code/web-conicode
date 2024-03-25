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
    });
});
