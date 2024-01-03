document.addEventListener('DOMContentLoaded', function () {
    let cardElements = document.querySelectorAll('.card-element');
    let navItems = document.querySelectorAll('.nav-item');

    cardElements.forEach(function (element, index) {
        element.addEventListener('mouseenter', function () {
            navItems[index].classList.add('hovered');
        });

        element.addEventListener('mouseleave', function () {
            navItems[index].classList.remove('hovered');
        });
    });

    navItems.forEach(function (element, index) {
        element.addEventListener('mouseenter', function () {
            cardElements[index].classList.add('hovered');
        });

        element.addEventListener('mouseleave', function () {
            cardElements[index].classList.remove('hovered');
        });
    });
});

