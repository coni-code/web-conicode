document.addEventListener("DOMContentLoaded", function() {
    const subMenuLinks = document.querySelectorAll("#leftside-navigation .sub-menu > a");

    subMenuLinks.forEach(function(link) {
        link.addEventListener('click', function(e) {
            const nextSubMenu = this.nextElementSibling;

            document.querySelectorAll("#leftside-navigation ul ul").forEach(function(subMenu) {
                if (subMenu !== nextSubMenu) {
                    subMenu.style.display = 'none';
                }
            });

            if (window.getComputedStyle(nextSubMenu).display === 'none') {
                nextSubMenu.style.display = 'block';
            } else {
                nextSubMenu.style.display = 'none';
            }

            e.stopPropagation();
        });
    });
});
