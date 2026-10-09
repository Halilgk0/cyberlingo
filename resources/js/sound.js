const STORAGE_KEY = 'cyberlingo.sound';

/**
 * Each sound is a few short notes: [frequency in Hz, start in seconds, length in seconds, wave, volume].
 * They are synthesized on the fly, so the app ships no audio files.
 */
const SOUNDS = {
    correct: [
        [660, 0, 0.12, 'triangle', 0.14],
        [990, 0.09, 0.2, 'triangle', 0.12],
    ],
    wrong: [
        [196, 0, 0.16, 'sawtooth', 0.05],
        [147, 0.12, 0.24, 'sawtooth', 0.05],
    ],
    done: [
        [784, 0.25, 0.1, 'sine', 0.1],
        [1047, 0.33, 0.22, 'sine', 0.1],
    ],
    victory: [
        [523, 0, 0.16, 'triangle', 0.14],
        [659, 0.14, 0.16, 'triangle', 0.14],
        [784, 0.28, 0.16, 'triangle', 0.14],
        [1047, 0.42, 0.5, 'triangle', 0.16],
    ],
};

let audioContext;

function isEnabled() {
    try {
        return localStorage.getItem(STORAGE_KEY) !== 'off';
    } catch {
        return true;
    }
}

function setEnabled(isOn) {
    try {
        localStorage.setItem(STORAGE_KEY, isOn ? 'on' : 'off');
    } catch {
        // Without storage the choice simply lasts until the page is closed.
    }
}

export function play(name) {
    if (!isEnabled() || !SOUNDS[name] || !window.AudioContext) {
        return;
    }

    audioContext ??= new AudioContext();
    const now = audioContext.currentTime;

    SOUNDS[name].forEach(([frequency, start, length, wave, volume]) => {
        const oscillator = audioContext.createOscillator();
        const gain = audioContext.createGain();

        oscillator.type = wave;
        oscillator.frequency.value = frequency;
        gain.gain.setValueAtTime(0, now + start);
        gain.gain.linearRampToValueAtTime(volume, now + start + 0.015);
        gain.gain.exponentialRampToValueAtTime(0.0001, now + start + length);

        oscillator.connect(gain).connect(audioContext.destination);
        oscillator.start(now + start);
        oscillator.stop(now + start + length + 0.05);
    });
}

/**
 * Plays a sound for every answer, finished step and finished mission,
 * and wires up the speaker buttons that turn sound on and off.
 */
export function initSound() {
    const toggles = [...document.querySelectorAll('[data-sound-toggle]')];

    const render = () => {
        const isOn = isEnabled();

        toggles.forEach((toggle) => {
            toggle.setAttribute('aria-pressed', String(isOn));
            toggle.setAttribute('aria-label', isOn ? 'Sesi kapat' : 'Sesi aç');
        });
    };

    toggles.forEach((toggle) => {
        toggle.addEventListener('click', () => {
            setEnabled(!isEnabled());
            render();
            play('correct');
        });
    });

    document.addEventListener('mascot:react', (event) => play(event.detail.reaction));
    document.addEventListener('requirement:completed', () => play('done'));
    document.addEventListener('celebration:open', () => play('victory'));

    render();
}
