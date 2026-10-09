import { completeRequirement } from './requirement';

/**
 * The castle in the defense-in-depth lesson. Choosing a layer (on the drawing or in
 * the list) lights it up and explains its cyber counterpart; seeing all five completes the step.
 */
export function initCastle() {
    const castle = document.querySelector('[data-castle]');

    if (!castle) {
        return;
    }

    const art = castle.querySelector('[data-castle-art]');
    const buttons = [...castle.querySelectorAll('[data-castle-layer]')];
    const parts = [...castle.querySelectorAll('[data-castle-part]')];
    const info = castle.querySelector('[data-castle-info]');
    const progress = castle.querySelector('[data-castle-progress]');
    const inspected = new Set();

    const select = (layer) => {
        art.setAttribute('data-focus', '');
        parts.forEach((part) => part.toggleAttribute('data-active', part.dataset.castlePart === layer));
        buttons.forEach((button) => button.setAttribute('aria-pressed', String(button.dataset.castleLayer === layer)));
        info.replaceChildren(castle.querySelector(`[data-castle-template="${layer}"]`).content.cloneNode(true));

        inspected.add(layer);
        castle.querySelector(`[data-castle-layer="${layer}"]`).setAttribute('data-inspected', '');
        progress.textContent = inspected.size;

        if (inspected.size === buttons.length) {
            completeRequirement(castle);
        }
    };

    buttons.forEach((button) => button.addEventListener('click', () => select(button.dataset.castleLayer)));
    parts.forEach((part) => part.addEventListener('click', () => select(part.dataset.castlePart)));
}
