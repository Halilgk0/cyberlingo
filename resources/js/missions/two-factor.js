import { react } from '../mascot';
import { completeRequirement } from './requirement';

const PERIOD_SECONDS = 30;
const CODE_DIGITS = 6;
const ATTACKER_ATTEMPT_LIMIT = 5;
const BASE32_ALPHABET = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';

function base32ToBytes(base32) {
    const bits = [...base32.toUpperCase()]
        .map((character) => BASE32_ALPHABET.indexOf(character).toString(2).padStart(5, '0'))
        .join('');

    return Uint8Array.from({ length: Math.floor(bits.length / 8) }, (_, index) => parseInt(bits.slice(index * 8, index * 8 + 8), 2));
}

/**
 * Returns a function that computes the one-time code for a 30-second time step.
 * It follows RFC 6238 (TOTP with HMAC-SHA1), the same as real authenticator apps,
 * and falls back to a simple stand-in where the Web Crypto API is unavailable.
 */
async function createCodeGenerator(secret) {
    if (!window.crypto?.subtle) {
        return {
            isRealTotp: false,
            codeFor: async (step) => {
                let hash = 2166136261;

                for (const character of `${secret}:${step}`) {
                    hash = Math.imul(hash ^ character.charCodeAt(0), 16777619);
                }

                return String((hash >>> 0) % 10 ** CODE_DIGITS).padStart(CODE_DIGITS, '0');
            },
        };
    }

    const key = await crypto.subtle.importKey('raw', base32ToBytes(secret), { name: 'HMAC', hash: 'SHA-1' }, false, ['sign']);

    return {
        isRealTotp: true,
        codeFor: async (step) => {
            const counter = new ArrayBuffer(8);
            new DataView(counter).setBigUint64(0, BigInt(step));

            const hmac = new Uint8Array(await crypto.subtle.sign('HMAC', key, counter));
            const offset = hmac[hmac.length - 1] & 0x0f;
            const binary = ((hmac[offset] & 0x7f) << 24) | (hmac[offset + 1] << 16) | (hmac[offset + 2] << 8) | hmac[offset + 3];

            return String(binary % 10 ** CODE_DIGITS).padStart(CODE_DIGITS, '0');
        },
    };
}

function currentStep() {
    return Math.floor(Date.now() / 1000 / PERIOD_SECONDS);
}

function formatCode(code) {
    return `${code.slice(0, 3)} ${code.slice(3)}`;
}

/**
 * The two-step verification demo: scan the QR code with the phone, type the
 * rotating code into the site, then try (and fail) to log in as the attacker.
 */
export async function initTwoFactor() {
    const demo = document.querySelector('[data-two-factor]');

    if (!demo) {
        return;
    }

    const { isRealTotp, codeFor } = await createCodeGenerator(demo.dataset.secret);
    const state = demo.querySelector('[data-two-factor-state]');
    const steps = Object.fromEntries([...demo.querySelectorAll('[data-two-factor-step]')].map((step) => [step.dataset.twoFactorStep, step]));
    const input = demo.querySelector('[data-two-factor-input]');
    const error = demo.querySelector('[data-two-factor-error]');
    const account = demo.querySelector('[data-authenticator-account]');
    const codeDisplay = demo.querySelector('[data-authenticator-code]');
    const seconds = demo.querySelector('[data-authenticator-seconds]');
    const bar = demo.querySelector('[data-authenticator-bar]');

    let displayedStep = null;
    let displayedCode = '';

    const tick = async () => {
        const step = currentStep();
        const remaining = PERIOD_SECONDS - (Math.floor(Date.now() / 1000) % PERIOD_SECONDS);

        seconds.textContent = remaining;
        bar.style.width = `${(remaining / PERIOD_SECONDS) * 100}%`;

        if (step !== displayedStep) {
            displayedStep = step;
            displayedCode = await codeFor(step);
            codeDisplay.textContent = formatCode(displayedCode);
        }
    };

    demo.querySelector('[data-totp-note]').hidden = !isRealTotp;

    demo.querySelector('[data-authenticator-scan]').addEventListener('click', () => {
        demo.querySelector('[data-authenticator-empty]').hidden = true;
        account.hidden = false;
        steps.verify.hidden = false;

        tick();
        setInterval(tick, 1000);
        input.focus();
    });

    steps.verify.addEventListener('submit', async (event) => {
        event.preventDefault();

        const typed = input.value.replace(/\D/g, '');

        if (typed.length !== CODE_DIGITS) {
            error.textContent = 'Kod 6 haneli olmalı. Telefondaki kodu yaz.';

            return;
        }

        /* Like real sites, the code from the previous 30 seconds is still accepted in case it just expired. */
        const step = currentStep();
        const acceptedCodes = await Promise.all([codeFor(step), codeFor(step - 1)]);

        if (!acceptedCodes.includes(typed)) {
            error.textContent = 'Kod tutmadı. Telefondaki güncel kodu yaz; süresi dolmak üzereyse yenisini bekle.';
            react('wrong');

            return;
        }

        error.textContent = '';
        steps.scan.hidden = true;
        steps.verify.hidden = true;
        steps.done.hidden = false;
        state.textContent = 'Açık';
        state.setAttribute('data-on', '');
        demo.querySelector('[data-two-factor-done]').focus();
        completeRequirement(demo);
        initAttacker(() => displayedCode);
    });
}

/**
 * The attacker knows the password but not the code; every guess fails until the account locks.
 */
function initAttacker(getCurrentCode) {
    const attacker = document.querySelector('[data-attacker]');
    const log = attacker.querySelector('[data-attacker-log]');
    const guessButton = attacker.querySelector('[data-attacker-guess]');
    const status = attacker.querySelector('[data-attacker-status]');

    let attempts = 0;

    attacker.hidden = false;

    guessButton.addEventListener('click', () => {
        let guess;

        do {
            guess = String(crypto.getRandomValues(new Uint32Array(1))[0] % 10 ** CODE_DIGITS).padStart(CODE_DIGITS, '0');
        } while (guess === getCurrentCode());

        attempts++;

        const entry = document.createElement('li');
        entry.textContent = `Deneme ${attempts}: ${formatCode(guess)} → yanlış kod`;
        log.append(entry);

        if (attempts < ATTACKER_ATTEMPT_LIMIT) {
            status.textContent = `${ATTACKER_ATTEMPT_LIMIT - attempts} deneme hakkı kaldı.`;

            return;
        }

        guessButton.hidden = true;
        status.textContent = 'Çok fazla hatalı deneme. Hesap 15 dakika kilitlendi ve Ayşe’ye “hesabınıza giriş denendi” bildirimi gönderildi.';
        attacker.querySelector('[data-attacker-lesson]').hidden = false;
        completeRequirement(attacker);
    });
}
