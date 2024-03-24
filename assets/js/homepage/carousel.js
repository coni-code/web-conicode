import '@glidejs/glide/dist/glide.min.js';

document.addEventListener('DOMContentLoaded', () => {
    const width = window.innerWidth;

    const techCountElement = document.getElementById('tech-count');
    if (!techCountElement) {
        return;
    }

    const techCount = techCountElement.attributes.getNamedItem('data-count').value;
    const technology = new Glide('#technology', {
        type: 'carousel',
        startAt: 0,
        perView: width <= 900 ? width <= 600 ? 1 : Math.min(techCount, 2) : Math.min(techCount, 3),
    });
    technology.mount();

    const teamCountElement = document.getElementById('team-count');
    if (!teamCountElement) {
        return;
    }

    const teamCount = teamCountElement.attributes.getNamedItem('data-count').value;
    const team = new Glide('#team', {
        type: 'carousel',
        startAt: 0,
        perView: width <= 900 ? width <= 600 ? 1 : Math.min(teamCount, 2) : Math.min(teamCount, 3),
    });

    team.mount();
});
