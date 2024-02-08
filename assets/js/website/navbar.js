import { handleDropdown } from '../dropdown';

document.addEventListener('DOMContentLoaded', () => {
    handleDropdown();

    const navItems = document.querySelectorAll('.nav-item');
    const teamId = document.getElementById('team');
    const homeId = document.getElementById('home');
    const portfolioId = document.getElementById('portfolio');
    const contactId = document.getElementById('contact');
    const teamDataBox = teamId.getAttribute('data-box');
    const homeDataBox = homeId.getAttribute('data-box');
    const portfolioDataBox = portfolioId.getAttribute('data-box');
    const contactDataBox = contactId.getAttribute('data-box');

    const dataBoxTab = [teamDataBox, homeDataBox, portfolioDataBox, contactDataBox];

    navItems.forEach(navItem => {
        navItem.addEventListener('click', () => {
            const navDataBox = navItem.getAttribute('data-box');
            for (let i = 0; i < dataBoxTab.length; i++) {
                if (navDataBox === dataBoxTab[i]) {
                    const sectionId = dataBoxTab[i];
                    const section = document.getElementById(sectionId);
                    section.scrollIntoView({ behavior: 'smooth' });
                }
            }
        });
    });
});
