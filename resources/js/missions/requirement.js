/**
 * Each mission step that must be finished carries `data-requirement`. Marking it
 * done notifies the finish panel, which unlocks once every requirement is met.
 */
export function completeRequirement(element) {
    if (element.hasAttribute('data-done')) {
        return;
    }

    element.setAttribute('data-done', '');
    element.dispatchEvent(new CustomEvent('requirement:completed', { bubbles: true }));
}
