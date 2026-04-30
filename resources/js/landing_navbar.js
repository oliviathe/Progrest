document.addEventListener('DOMContentLoaded', () => {
    const btn = document.getElementById('menu-btn');
    const menu = document.getElementById('mobile-menu');

    let open = false;

    if (btn && menu) {
        btn.addEventListener('click', () => {
            open = !open;

            if (open) {
                menu.classList.remove('max-h-0');
                menu.classList.add('max-h-40');
            } else {
                menu.classList.remove('max-h-40');
                menu.classList.add('max-h-0');
            }
        });
    }

    const scrollBtn = document.getElementById('scroll-features');
    const section = document.getElementById('features');

    if (scrollBtn && section) {
        scrollBtn.addEventListener('click', () => {
            const yOffset = -50;
            const y = section.getBoundingClientRect().top + window.pageYOffset + yOffset;

            window.scrollTo({
                top: y,
                behavior: 'smooth'
            });
        });
    }
});