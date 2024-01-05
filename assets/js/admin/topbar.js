document.addEventListener('DOMContentLoaded', () => {
    const topbartoggle = document.querySelector('#admin-layout .toggle-dropdown');
    const dropdown = document.querySelector('#admin-layout .dropdown-menu');

    function toggleDropdown() {
        dropdown.classList.toggle('show');
    }

    topbartoggle.addEventListener('click', toggleDropdown);

    document.addEventListener('click', event => {
        if (!dropdown.contains(event.target) && !topbartoggle.contains(event.target)) {
            dropdown.classList.remove('show');
        }
    });
});
