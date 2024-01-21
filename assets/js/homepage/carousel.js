import '@glidejs/glide/dist/glide.min.js';

const {width} = screen.width;
const portfolio = new Glide('#portfolio', {
    type: 'carousel',
    startAt: 0,
    perView: 1,
    focusAt: 'center',
});

portfolio.mount();

const team = new Glide('#team', {
    type: 'carousel',
    startAt: 1,
    perView: width <= 900 ? width <= 600 ? 1 : 2 : 3,
});

team.mount();
