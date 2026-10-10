const STORAGE_KEY = 'cyberlingo.welcomed';

/**
 * Shows the welcome dialog the first time someone opens the learning path, then remembers
 * it in the browser so it never interrupts again. Without storage it simply shows once.
 */
export function initOnboarding() {
    const dialog = document.querySelector('[data-welcome]');

    if (!dialog || typeof dialog.showModal !== 'function') {
        return;
    }

    let seen = false;
    try {
        seen = localStorage.getItem(STORAGE_KEY) === '1';
    } catch {
        seen = false;
    }

    if (seen) {
        return;
    }

    dialog.hidden = false;
    dialog.showModal();

    const close = () => {
        try {
            localStorage.setItem(STORAGE_KEY, '1');
        } catch {
            // No storage: the dialog simply may appear again next time.
        }
        dialog.close();
    };

    dialog.querySelector('[data-welcome-start]').addEventListener('click', close);
    dialog.addEventListener('cancel', close);
}
