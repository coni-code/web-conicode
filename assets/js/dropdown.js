export function handleDropdown() {
    const navlangElement = document.querySelector('.nav-lang');
    const dropdownElement = document.querySelector('.home-dropdown-menu');

    if (!dropdownElement) {
        throw new Error('46b745a7-c816-49a2-aaf3-50266c8cc366');
    }

    navlangElement.addEventListener('click', () => {
        dropdownElement.classList.toggle('d-block');
    });

    document.addEventListener('click', event => {
        if (!dropdownElement.contains(event.target) && !navlangElement.contains(event.target)) {
            dropdownElement.classList.remove('d-block');
        }
    });
}
