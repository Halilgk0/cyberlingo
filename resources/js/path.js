/**
 * On the learning path, bring the current mission (the one with the "Başla" bubble) into
 * view on load, so a learner lands on where they left off instead of the top of a long path.
 * Only when the page opens fresh at the top, so it never fights a deliberate scroll or an anchor.
 */
export function initPath() {
    const current = document.querySelector('[data-current-node]');

    if (!current || location.hash || window.scrollY > 10) {
        return;
    }

    const motion = window.matchMedia('(prefers-reduced-motion: reduce)').matches ? 'auto' : 'smooth';

    requestAnimationFrame(() => current.scrollIntoView({ behavior: motion, block: 'center' }));
}
