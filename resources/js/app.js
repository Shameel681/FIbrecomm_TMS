import './bootstrap';

document.addEventListener('DOMContentLoaded', () => {
    const sections = document.querySelectorAll('section[id]');
    const navLinks = document.querySelectorAll('.nav-link');
    const navBar = document.querySelector('#main-nav');

    function highlightMenu() {
        let scrollY = window.pageYOffset;

        sections.forEach(current => {
            const sectionHeight = current.offsetHeight;
            // Trigger when the section is roughly in the middle of the viewport
            const sectionTop = current.offsetTop - (window.innerHeight / 2);
            const sectionId = current.getAttribute('id');

            if (scrollY >= sectionTop && scrollY < sectionTop + sectionHeight) {
                navLinks.forEach(link => {
                    const bar = link.querySelector('.underline-bar');
                    if (bar) {
                        if (link.getAttribute('href') === `#${sectionId}`) {
                            bar.classList.add('underline-bar-active');
                        } else {
                            bar.classList.remove('underline-bar-active');
                        }
                    }
                });
            }
        });
    }

    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href');
            const targetSection = document.querySelector(targetId);
            
            if (targetSection) {
                const sectionHeight = targetSection.offsetHeight;
                const windowHeight = window.innerHeight;

                // Calculation to center the section in the viewport
                let scrollToPosition = targetSection.offsetTop - (windowHeight / 2) + (sectionHeight / 2);

                // Prevent over-scrolling for the top section
                if (targetId === '#home') scrollToPosition = 0;

                window.scrollTo({
                    top: scrollToPosition,
                    behavior: 'smooth'
                });
            }
        });
    });

    window.addEventListener('scroll', highlightMenu);
    highlightMenu(); // Run once on load
});