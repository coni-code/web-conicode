import '@glidejs/glide/dist/glide.min.js';

const glide = new Glide('#portfolio', {
    type: 'carousel',
    startAt: 0,
    perView: 1,
    peek: 200,
    focusAt: 'center',
});

glide.mount();
