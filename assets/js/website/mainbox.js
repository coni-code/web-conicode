document.addEventListener('DOMContentLoaded', () => {
    const text = document.getElementById('trans-quote').textContent;
    const typingDiv = document.getElementById('quote1');

    function typeWriter(text, i) {
        if (i < text.length) {
            typingDiv.innerHTML += text.charAt(i);
            i++;
            const char = text.charAt(i - 1);
            if (char === ',' || char === '.') {
                setTimeout(() => {
                    typeWriter(text, i);
                }, 500);
            } else {
                setTimeout(() => {
                    typeWriter(text, i);
                }, 100);
            }
        }
    }

    typeWriter(text, 0);
});
