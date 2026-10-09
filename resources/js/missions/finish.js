import { openCelebration } from '../celebration';

function csrfToken() {
    return document.querySelector('meta[name="csrf-token"]')?.content ?? '';
}

/**
 * The panel at the bottom of a mission page. It lists what is left to do, keeps the
 * lesson progress bar in the header up to date and, once every requirement is met,
 * saves the completion and opens the celebration screen.
 */
export function initFinish() {
    const panel = document.querySelector('[data-finish]');

    if (!panel) {
        return;
    }

    const requirements = [...document.querySelectorAll('[data-requirement]')];
    const status = panel.querySelector('[data-finish-status]');
    const remainingList = panel.querySelector('[data-finish-remaining]');
    const stamp = panel.querySelector('[data-finish-stamp]');
    const finishButton = panel.querySelector('[data-finish-button]');
    const progress = document.querySelector('[data-lesson-progress]');
    const progressBar = document.querySelector('[data-lesson-progress-bar]');

    const render = () => {
        const remaining = requirements.filter((requirement) => !requirement.hasAttribute('data-done'));
        const percent = Math.round(((requirements.length - remaining.length) / Math.max(1, requirements.length)) * 100);

        progress?.setAttribute('aria-valuenow', percent);

        if (progressBar) {
            progressBar.style.width = `${Math.max(3, percent)}%`;
        }

        remainingList.replaceChildren(
            ...remaining.map((requirement) => {
                const item = document.createElement('li');
                item.textContent = requirement.dataset.requirement;

                return item;
            }),
        );

        finishButton.disabled = remaining.length > 0;
        status.textContent = remaining.length > 0
            ? 'Görevi bitirmek için şunlar kaldı:'
            : 'Her şey hazır! Görevi tamamla ve ödülünü al.';
    };

    document.addEventListener('requirement:completed', render);

    finishButton.addEventListener('click', async () => {
        finishButton.disabled = true;
        status.textContent = 'Kaydediliyor…';

        try {
            const response = await fetch(panel.dataset.completeUrl, {
                method: 'POST',
                headers: { Accept: 'application/json', 'X-CSRF-TOKEN': csrfToken() },
            });

            if (!response.ok) {
                throw new Error(`Completion failed with status ${response.status}`);
            }

            const result = await response.json();

            stamp.hidden = false;
            stamp.classList.add('stamp-in');
            status.textContent = 'Görev tamamlandı!';
            openCelebration(result);
        } catch {
            status.textContent = 'Görev kaydedilemedi. İnternet bağlantını kontrol edip tekrar dene; olmazsa sayfayı yenile.';
            finishButton.disabled = false;
        }
    });

    render();
}
