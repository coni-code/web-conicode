document.addEventListener('DOMContentLoaded', () => {
    const navElements = document.querySelectorAll('.nav-item');
    const headerElements = document.querySelectorAll('.card-element');

    navElements.forEach(navElement => {
        navElement.addEventListener('mouseenter', () => {
            const navDataBox = navElement.getAttribute('data-box');

            headerElements.forEach(headerElement => {
                const headerDataBox = headerElement.getAttribute('data-box');
                if (navDataBox === headerDataBox) {
                    headerElement.classList.add('hovered');
                }
            });
        });

        navElement.addEventListener('mouseleave', () => {
            const navDataBox = navElement.getAttribute('data-box');

            headerElements.forEach(headerElement => {
                const headerDataBox = headerElement.getAttribute('data-box');
                if (navDataBox === headerDataBox) {
                    headerElement.classList.remove('hovered');
                }
            });
        });
    });

    headerElements.forEach(headerElement => {
        headerElement.addEventListener('mouseenter', () => {
            const headerDataBox = headerElement.getAttribute('data-box');

            navElements.forEach(navElement => {
                const navDataBox = navElement.getAttribute('data-box');
                if (headerDataBox === navDataBox) {
                    navElement.classList.add('hovered');
                }
            });
        });
    });

    headerElements.forEach(headerElement => {
        headerElement.addEventListener('mouseleave', () => {
            const headerDataBox = headerElement.getAttribute('data-box');

            navElements.forEach(navElement => {
                const navDataBox = navElement.getAttribute('data-box');
                if (headerDataBox === navDataBox) {
                    navElement.classList.remove('hovered');
                }
            });
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
