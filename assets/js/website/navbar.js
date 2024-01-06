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
});
