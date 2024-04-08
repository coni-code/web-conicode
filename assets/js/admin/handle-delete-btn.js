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

        fetch(deleteUrl, {
            method: 'POST',
        }).then(() => {
            if (!redirectPath) {
                window.location.reload();
            } else {
                window.location.href = redirectUrl;
            }
        }).catch(error => {
            console.error('Error:', error);
        });
    });
});
