/**
 * Elements marked `data-reveal` slide in the first time they scroll into view.
 * Whatever is already on screen when the page opens shows straight away. The `js`
 * class on <html> is what lets the CSS hide the rest, so without this script
 * everything simply stays visible.
 */
export function initReveal() {
    const elements = [...document.querySelectorAll('[data-reveal]')].filter((element) => {
        const isOnScreen = element.getBoundingClientRect().top < window.innerHeight;

        if (isOnScreen) {
            element.setAttribute('data-visible', '');
        }

        return !isOnScreen;
    });

    if (elements.length === 0 || !('IntersectionObserver' in window)) {
        return;
    }

    document.documentElement.classList.add('js');

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.setAttribute('data-visible', '');
                    observer.unobserve(entry.target);
                }
            });
        },
        { rootMargin: '0px 0px -8% 0px' },
    );

    elements.forEach((element) => observer.observe(element));
}

/**
 * Buttons marked `data-print` open the browser's print dialog, for the certificate.
 */
export function initPrint() {
    document.querySelectorAll('[data-print]').forEach((button) => {
        button.addEventListener('click', () => window.print());
    });
}

/**
 * The status toast at the top of the page closes itself after a while, or on request.
 */
export function initToast() {
    const toast = document.querySelector('[data-toast]');

    if (!toast) {
        return;
    }

    const close = () => toast.remove();

    toast.querySelector('[data-toast-close]').addEventListener('click', close);
    setTimeout(close, 6000);
}
