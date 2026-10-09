/**
 * Flips an `x-switch` button and returns whether it is now on.
 */
export function toggleSwitch(button) {
    const isOn = button.getAttribute('aria-checked') !== 'true';

    button.setAttribute('aria-checked', String(isOn));

    return isOn;
}
