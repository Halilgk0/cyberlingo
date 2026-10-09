/**
 * The step links at the top of a mission tick themselves off: a step with exercises once
 * all of them are done, a reading step once the learner has scrolled past it.
 */
function initStepChecks() {
    const links = [...document.querySelectorAll('[data-step-link]')];

    if (links.length === 0) {
        return;
    }

    const markDone = (link) => {
        if (link.hasAttribute('data-done')) {
            return;
        }

        link.setAttribute('data-done', '');
        link.querySelector('[data-step-status]').textContent = '(tamamlandı)';
    };

    const steps = links.map((link) => {
        const section = document.getElementById(link.dataset.stepLink);

        return { link, section, requirements: [...(section?.querySelectorAll('[data-requirement]') ?? [])] };
    }).filter((step) => step.section);

    const readingSteps = steps.filter((step) => step.requirements.length === 0);

    document.addEventListener('requirement:completed', () => {
        steps
            .filter((step) => step.requirements.length > 0)
            .filter((step) => step.requirements.every((requirement) => requirement.hasAttribute('data-done')))
            .forEach((step) => markDone(step.link));
    });

    let isQueued = false;

    const checkReadingSteps = () => {
        isQueued = false;
        readingSteps
            .filter((step) => step.section.getBoundingClientRect().bottom < window.innerHeight * 0.5)
            .forEach((step) => markDone(step.link));
    };

    window.addEventListener('scroll', () => {
        if (!isQueued) {
            isQueued = true;
            requestAnimationFrame(checkReadingSteps);
        }
    }, { passive: true });
}

/**
 * Leaving a mission halfway loses its progress, so the close button asks first,
 * but only when something was done and the mission is not saved yet.
 */
function initLeaveConfirmation() {
    const leave = document.querySelector('[data-leave-mission]');
    const dialog = document.querySelector('[data-leave-dialog]');

    if (!leave || !dialog || typeof dialog.showModal !== 'function') {
        return;
    }

    leave.addEventListener('click', (event) => {
        const hasProgress = document.querySelector('[data-requirement][data-done]') !== null;
        const isSaved = document.querySelector('[data-finish][data-saved]') !== null;

        if (hasProgress && !isSaved) {
            event.preventDefault();
            dialog.showModal();
        }
    });

    dialog.querySelector('[data-leave-stay]').addEventListener('click', () => dialog.close());

    // A tap on the dimmed backdrop also means "stay".
    dialog.addEventListener('click', (event) => {
        if (event.target === dialog) {
            dialog.close();
        }
    });
}

export function initMissionNavigation() {
    initStepChecks();
    initLeaveConfirmation();
}
