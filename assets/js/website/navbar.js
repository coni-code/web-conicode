document.addEventListener('DOMContentLoaded', () => {
    const cardElements = document.querySelectorAll('.hover-element');
    const navItems = document.querySelectorAll('.nav-item');

    cardElements.forEach((element, index) => {
        element.addEventListener('mouseenter', () => {
            navItems[index].classList.add('hovered');
        });

        element.addEventListener('mouseleave', () => {
            navItems[index].classList.remove('hovered');
        });
    });

    navItems.forEach((element, index) => {
        element.addEventListener('mouseenter', () => {
            cardElements[index].classList.add('hovered');
        });

        element.addEventListener('mouseleave', () => {
            cardElements[index].classList.remove('hovered');
        });
    });
    handleDropdown();
});

function handleDropdown() {
    const navlangElement = document.querySelector('.nav-lang');
    const dropdownElement = document.querySelector('.home-dropdown-menu');

    if (!dropdownElement) {
        throw new Error('46b745a7-c816-49a2-aaf3-50266c8cc366');
    }

    navlangElement.addEventListener('click', () => {
        dropdownElement.classList.toggle('d-block');
    });
}
