document.addEventListener('DOMContentLoaded', () => {
    const deleteBtn = document.querySelector('.delete-btn');

    if (!deleteBtn) {
        return;
    }

    const deletePath = deleteBtn.getAttribute('data-delete-url');
    const redirectPath = deleteBtn.getAttribute('data-redirect-url');

    if (!deletePath) {
        return;
    }

    const deleteUrl = `${window.location.origin}${deletePath}`;
    const redirectUrl = `${window.location.origin}${redirectPath}`;

    deleteBtn.addEventListener('click', event => {
        event.stopPropagation();

        // eslint-disable-next-line no-alert
        const isConfirmed = confirm('Are you sure?');

        if (isConfirmed) {
            fetch(deleteUrl, {
                method: 'POST',
            }).then(() => {
                if (redirectPath) {
                    window.location.href = redirectUrl;

                    return;
                }

                window.location.reload();
            }).catch(error => {
                console.error('Error:', error);
            });
        }
    });
});
