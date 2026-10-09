import { completeRequirement } from './requirement';
import { toggleSwitch } from './switch';

const ALPHABET = [...'ABCÇDEFGĞHIİJKLMNOÖPRSŞTUÜVYZ'];

/**
 * Shifts every letter of the Turkish alphabet `shift` places (backwards when negative).
 * Anything that is not one of the 29 letters, such as spaces and punctuation, stays as it is.
 */
function caesarShift(text, shift) {
    return [...text.toLocaleUpperCase('tr')]
        .map((character) => {
            const index = ALPHABET.indexOf(character);

            return index === -1 ? character : ALPHABET[(((index + shift) % ALPHABET.length) + ALPHABET.length) % ALPHABET.length];
        })
        .join('');
}

/**
 * The Caesar wheel: the learner's message is encrypted live while they move the key slider.
 */
function initCaesarWheel() {
    const wheel = document.querySelector('[data-caesar-wheel]');

    if (!wheel) {
        return;
    }

    const input = wheel.querySelector('[data-caesar-input]');
    const shiftInput = wheel.querySelector('[data-caesar-shift]');
    const shiftValue = wheel.querySelector('[data-caesar-shift-value]');
    const letters = [...wheel.querySelectorAll('[data-caesar-letter]')];
    const plain = wheel.querySelector('[data-caesar-plain]');
    const cipher = wheel.querySelector('[data-caesar-cipher]');
    const status = wheel.querySelector('[data-caesar-status]');

    const render = () => {
        const shift = Number(shiftInput.value);
        const message = input.value.toLocaleUpperCase('tr');
        const encrypted = caesarShift(message, shift);
        const letterCount = [...message].filter((character) => ALPHABET.includes(character)).length;

        shiftValue.textContent = shift;
        letters.forEach((letter) => {
            letter.querySelector('[data-caesar-mapped]').textContent = caesarShift(letter.dataset.caesarLetter, shift);
            letter.toggleAttribute('data-active', message.includes(letter.dataset.caesarLetter));
        });

        plain.textContent = message || '…';
        cipher.textContent = encrypted || '…';

        if (letterCount < 3) {
            status.textContent = '';

            return;
        }

        status.textContent = `Mesajın şifrelendi! Anahtarın ${shift} olduğunu bilmeyen biri sadece “${encrypted}” görür.`;
        completeRequirement(wheel);
    };

    input.addEventListener('input', render);
    shiftInput.addEventListener('input', render);
    render();
}

/**
 * The code-breaking challenge: try keys by hand until the intercepted message reads,
 * then watch a computer try all 28 keys at once.
 */
function initCaesarCrack() {
    const crack = document.querySelector('[data-caesar-crack]');

    if (!crack) {
        return;
    }

    const key = Number(crack.dataset.key);
    const ciphertext = caesarShift(crack.dataset.plaintext, key);
    const shiftInput = crack.querySelector('[data-crack-shift]');
    const shiftValue = crack.querySelector('[data-crack-shift-value]');
    const attempt = crack.querySelector('[data-crack-attempt]');
    const status = crack.querySelector('[data-crack-status]');
    const brute = crack.querySelector('[data-crack-brute]');
    const bruteButton = crack.querySelector('[data-crack-brute-button]');
    const bruteList = crack.querySelector('[data-crack-brute-list]');
    const bruteNote = crack.querySelector('[data-crack-brute-note]');
    const triedKeys = new Set();

    crack.querySelector('[data-crack-cipher]').textContent = ciphertext;

    const render = () => {
        const shift = Number(shiftInput.value);
        const isKey = shift === key;

        triedKeys.add(shift);
        shiftValue.textContent = shift;
        attempt.textContent = caesarShift(ciphertext, -shift);
        attempt.toggleAttribute('data-cracked', isKey);

        if (isKey && brute.hidden) {
            status.textContent = `Kırdın! Anahtar ${key}. Bunun için ${triedKeys.size} farklı anahtar denedin.`;
            brute.hidden = false;
            completeRequirement(crack);
        }
    };

    shiftInput.addEventListener('input', render);

    bruteButton.addEventListener('click', () => {
        const startedAt = performance.now();
        const candidates = Array.from({ length: ALPHABET.length - 1 }, (_, index) => [index + 1, caesarShift(ciphertext, -(index + 1))]);
        const elapsed = performance.now() - startedAt;

        bruteList.replaceChildren(
            ...candidates.map(([candidateKey, text]) => {
                const item = document.createElement('li');

                item.textContent = `${String(candidateKey).padStart(2, '0')} → ${text}`;
                item.toggleAttribute('data-match', candidateKey === key);

                return item;
            }),
        );

        bruteButton.hidden = true;
        bruteNote.hidden = false;
        bruteNote.textContent = `Bilgisayar ${candidates.length} anahtarın hepsini ${elapsed < 1 ? '1 milisaniyeden kısa' : `${Math.round(elapsed)} milisaniye`} sürede denedi ve okunabilir olanı hemen buldu. Modern şifrelerin 28 değil, 39 basamaklı bir sayı kadar anahtar kullanmasının nedeni bu.`;
    });

    render();
}

/**
 * The end-to-end encryption figure: the switch decides what the server in the middle sees.
 */
function initEndToEnd() {
    document.querySelectorAll('[data-e2e]').forEach((figure) => {
        figure.querySelector('[data-e2e-toggle]').addEventListener('click', (event) => {
            figure.toggleAttribute('data-on', toggleSwitch(event.currentTarget));
        });
    });
}

export function initEncryption() {
    initCaesarWheel();
    initCaesarCrack();
    initEndToEnd();
}
