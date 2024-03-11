import '@glidejs/glide/dist/glide.min.js';

const width = window.innerWidth;

const portfolio = new Glide('#portfolio', {
    type: 'carousel',
    startAt: 0,
    perView: 1,
    focusAt: 'center',
});

portfolio.mount();
const count = document.getElementById('team-count').attributes.getNamedItem('data-count').value;
const team = new Glide('#team', {
    type: 'carousel',
    startAt: 1,
    perView: width <= 900 ? width <= 600 ? 1 : Math.min(count, 2) : Math.min(count, 3),
});

team.mount();
