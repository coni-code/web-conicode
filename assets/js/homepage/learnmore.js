document.addEventListener('DOMContentLoaded', () => {
    const learnMore = document.querySelectorAll('.learn-more');
    learnMore.forEach(e => {
        e.addEventListener('click', () => {
            const description = document.querySelectorAll('#' + e.attributes.getNamedItem('data').value);
            description.forEach(d => {
                if (d.classList.contains('more')) {
                    d.classList.remove('more');
                } else {
                    d.classList.add('more');
                }
            });
        });
    });
});
