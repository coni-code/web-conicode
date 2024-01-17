import "@glidejs/glide/dist/glide.min.js"

new Glide('#portfolio',{
        type: 'carousel',
        startAt: 0,
        perView: 1,
        peek:200,
        focusAt:'center',
}).mount()