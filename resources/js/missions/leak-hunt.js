import { react } from '../mascot';
import { completeRequirement } from './requirement';

/**
 * The profile hunt: the learner clicks the pieces of a profile that leak something useful
 * to an attacker. Each find is listed with why it is risky; a hint points at one left to find.
 */
export function initLeakHunt() {
    const hunt = document.querySelector('[data-leak-hunt]');

    if (!hunt) {
        return;
    }

    const leaks = [...hunt.querySelectorAll('[data-leak]')];
    const count = hunt.querySelector('[data-leak-count]');
    const bar = hunt.querySelector('[data-leak-bar]');
    const status = hunt.querySelector('[data-leak-status]');
    const foundList = hunt.querySelector('[data-leak-found]');
    const itemTemplate = hunt.querySelector('[data-leak-item]');
    const hintButton = hunt.querySelector('[data-leak-hint]');
    const summary = document.querySelector('[data-leak-summary]');

    hunt.querySelector('[data-leak-total]').textContent = leaks.length;

    const unfoundLeaks = () => leaks.filter((leak) => !leak.hasAttribute('data-found'));

    const find = (leak) => {
        if (leak.hasAttribute('data-found')) {
            return;
        }

        leak.setAttribute('data-found', '');
        leak.removeAttribute('data-hinted');
        leak.setAttribute('aria-disabled', 'true');

        const item = itemTemplate.content.firstElementChild.cloneNode(true);
        item.querySelector('[data-leak-item-label]').textContent = leak.dataset.leakLabel;
        item.querySelector('[data-leak-item-risk]').textContent = leak.dataset.leakRisk;
        foundList.append(item);

        const foundCount = leaks.length - unfoundLeaks().length;
        count.textContent = foundCount;
        bar.style.width = `${(foundCount / leaks.length) * 100}%`;
        status.textContent = `Buldun: ${leak.dataset.leakLabel}.`;
        react('correct');

        if (foundCount === leaks.length) {
            status.textContent = 'Hepsini buldun!';
            hintButton.hidden = true;
            summary.hidden = false;
            summary.focus();
            completeRequirement(hunt);
        }
    };

    leaks.forEach((leak) => {
        leak.addEventListener('click', () => find(leak));
        leak.addEventListener('keydown', (event) => {
            if (event.key === 'Enter' || event.key === ' ') {
                event.preventDefault();
                find(leak);
            }
        });
    });

    hintButton.addEventListener('click', () => {
        const [nextLeak] = unfoundLeaks();

        if (!nextLeak) {
            return;
        }

        leaks.forEach((leak) => leak.removeAttribute('data-hinted'));
        nextLeak.setAttribute('data-hinted', '');
        nextLeak.scrollIntoView({
            block: 'center',
            behavior: window.matchMedia('(prefers-reduced-motion: reduce)').matches ? 'auto' : 'smooth',
        });
        status.textContent = 'Kesik çizgiyle işaretlenen yere bak.';
    });
}
