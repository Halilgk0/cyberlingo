function csrfToken() {
    return document.querySelector('meta[name="csrf-token"]')?.content ?? '';
}

/**
 * The security checklist saves every tick in the background, so the save button is
 * only needed without JavaScript. The meter and the count follow along.
 */
export function initChecklist() {
    const form = document.querySelector('[data-checklist]');

    if (!form) {
        return;
    }

    const status = form.querySelector('[data-checklist-status]');
    const checked = document.querySelector('[data-checklist-checked]');
    const meter = document.querySelector('[data-checklist-meter]');
    const complete = document.querySelector('[data-checklist-complete]');

    form.querySelector('[data-checklist-save]').hidden = true;

    form.addEventListener('change', async () => {
        status.textContent = 'Kaydediliyor…';

        try {
            const response = await fetch(form.action, {
                method: 'POST',
                headers: { Accept: 'application/json', 'X-CSRF-TOKEN': csrfToken() },
                body: new FormData(form),
            });

            if (!response.ok) {
                throw new Error(`HTTP ${response.status}`);
            }

            const result = await response.json();

            checked.textContent = result.checked;
            meter.style.width = `${(result.checked / result.total) * 100}%`;
            complete.hidden = result.checked !== result.total;
            status.textContent = 'Kaydedildi.';
        } catch {
            status.textContent = 'Kaydedilemedi. Sayfayı yenileyip tekrar dene.';
        }
    });
}
