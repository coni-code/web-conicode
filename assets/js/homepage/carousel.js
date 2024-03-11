import '@glidejs/glide/dist/glide.min.js';

document.addEventListener('DOMContentLoaded', () => {
    const width = window.innerWidth;
    const portfolio = new Glide('#portfolio', {
        type: 'carousel',
        startAt: 0,
        perView: 1,
        focusAt: 'center',
    });

    portfolio.mount();
    const teamCountElement = document.getElementById('team-count');
    if (!teamCountElement) {
        return;
    }

    const count = teamCountElement.attributes.getNamedItem('data-count').value;
    const team = new Glide('#team', {
        type: 'carousel',
        startAt: 1,
        perView: width <= 900 ? width <= 600 ? 1 : Math.min(count, 2) : Math.min(count, 3),
    });

    team.mount();
});
