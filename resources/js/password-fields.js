/**
 * Password fields get a button that shows the typed password, so a typo is easy to spot
 * on a phone keyboard. A field with a minimum length also counts the characters as the
 * learner types.
 */
export function initPasswordFields() {
    document.querySelectorAll('[data-password-toggle]').forEach((toggle) => {
        const input = document.getElementById(toggle.getAttribute('aria-controls'));
        const label = toggle.querySelector('[data-password-toggle-label]');

        toggle.hidden = false;
        toggle.setAttribute('aria-label', 'Parolayı göster');

        toggle.addEventListener('click', () => {
            const isShown = input.type === 'text';

            input.type = isShown ? 'password' : 'text';
            toggle.setAttribute('aria-pressed', String(!isShown));
            toggle.setAttribute('aria-label', isShown ? 'Parolayı göster' : 'Parolayı gizle');
            label.textContent = isShown ? 'Göster' : 'Gizle';
            input.focus();
        });

        // Never send a form with the password left readable on screen.
        input.form?.addEventListener('submit', () => {
            input.type = 'password';
        });
    });

    document.querySelectorAll('[data-password-length]').forEach((counter) => {
        const input = counter.parentElement.querySelector('input');
        const minimum = input.minLength;

        const render = () => {
            const length = [...input.value].length;
            const missing = minimum - length;

            counter.hidden = length === 0;
            counter.toggleAttribute('data-enough', missing <= 0);
            counter.textContent = missing > 0
                ? `${length} karakter · ${missing} tane daha`
                : `${length} karakter · uzunluk tamam ✓`;
        };

        input.addEventListener('input', render);
        render();
    });
}
