import { react } from '../mascot';
import { completeRequirement } from './requirement';

/**
 * A log to read like an analyst. Tapping a line of an attack trace lights up every line
 * of that trace and explains it; tapping an ordinary line says why it is ordinary.
 * The filter box narrows the log to lines containing the typed text.
 */
export function initLogHunts() {
    document.querySelectorAll('[data-log-hunt]').forEach((hunt) => {
        const lines = [...hunt.querySelectorAll('[data-log-line]')];
        const groups = [...new Set(lines.map((line) => line.dataset.evidence).filter(Boolean))];
        const foundCount = hunt.querySelector('[data-log-found]');
        const found = new Set();
        let openHint = null;

        hunt.querySelector('[data-log-total]').textContent = groups.length;

        const explanationFor = (line) => {
            const own = line.querySelector('[data-log-why]');
            const shared = line.dataset.evidence && hunt.querySelector(`[data-evidence-why="${line.dataset.evidence}"]`);

            return (own ?? shared)?.content.cloneNode(true) ?? document.createTextNode('Bu satır olağan görünüyor.');
        };

        const showFeedback = (line, tone, title) => {
            const feedback = line.querySelector('[data-log-feedback]');
            const heading = document.createElement('strong');

            heading.textContent = `${title} `;
            feedback.dataset.tone = tone;
            feedback.replaceChildren(heading, explanationFor(line));
            feedback.hidden = false;

            return feedback;
        };

        lines.forEach((line) => {
            const button = line.querySelector('button');

            button.addEventListener('click', () => {
                if (openHint) {
                    openHint.hidden = true;
                    openHint = null;
                }

                const group = line.dataset.evidence;

                if (!group) {
                    button.dataset.state = 'wrong';
                    setTimeout(() => delete button.dataset.state, 600);
                    openHint = showFeedback(line, 'wrong', 'Olağan bir satır.');
                    react('wrong');

                    return;
                }

                showFeedback(line, 'correct', 'İz bulundu!');

                if (found.has(group)) {
                    return;
                }

                found.add(group);
                lines
                    .filter((other) => other.dataset.evidence === group)
                    .forEach((other) => other.querySelector('button').setAttribute('data-found', ''));
                foundCount.textContent = found.size;
                react('correct');

                if (found.size === groups.length) {
                    const summary = hunt.querySelector('[data-log-summary]');

                    summary.hidden = false;
                    summary.focus({ preventScroll: true });
                    completeRequirement(hunt);
                }
            });
        });

        const filter = hunt.querySelector('[data-log-filter]');
        const empty = hunt.querySelector('[data-log-empty]');

        filter.addEventListener('input', () => {
            const query = filter.value.trim().toLocaleLowerCase('tr');

            lines.forEach((line) => {
                line.hidden = query !== '' && !line.querySelector('button').textContent.toLocaleLowerCase('tr').includes(query);
            });
            empty.hidden = lines.some((line) => !line.hidden);
        });
    });
}
