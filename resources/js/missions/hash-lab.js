import { react } from '../mascot';
import { completeRequirement } from './requirement';

const canHash = () => Boolean(window.crypto?.subtle);

async function sha256(text) {
    const digest = await crypto.subtle.digest('SHA-256', new TextEncoder().encode(text));

    return [...new Uint8Array(digest)].map((byte) => byte.toString(16).padStart(2, '0')).join('');
}

function randomSalt() {
    return [...crypto.getRandomValues(new Uint8Array(8))].map((byte) => byte.toString(16).padStart(2, '0')).join('');
}

/**
 * Shows a hash with the characters that changed since the previous one highlighted.
 */
function renderHash(output, hash, previous) {
    output.replaceChildren(...[...hash].map((character, index) => {
        const span = document.createElement('span');

        span.textContent = character;

        if (previous && previous[index] !== character) {
            span.className = 'text-signal';
        }

        return span;
    }));
}

/**
 * The avalanche demo: the SHA-256 of whatever the learner types, updated live, with
 * the characters that changed since the last version lit up.
 */
function initAvalanche(lab) {
    const input = lab.querySelector('[data-hash-input]');
    const output = lab.querySelector('[data-hash-output]');
    const diff = lab.querySelector('[data-hash-diff]');
    let initialHash = null;
    let previousHash = null;
    let latestRequest = 0;

    const update = async () => {
        const request = ++latestRequest;
        const hash = await sha256(input.value);

        // A slower, older calculation must not overwrite a newer one.
        if (request !== latestRequest) {
            return;
        }

        renderHash(output, hash, previousHash);

        if (previousHash && previousHash !== hash) {
            const changed = [...hash].filter((character, index) => previousHash[index] !== character).length;
            diff.textContent = `Bir önceki özete göre 64 karakterden ${changed} tanesi değişti.`;
        }

        if (initialHash && hash !== initialHash && !lab.hasAttribute('data-done')) {
            react('correct');
            completeRequirement(lab);
        }

        initialHash ??= hash;
        previousHash = hash;
    };

    input.addEventListener('input', update);
    update();
}

/**
 * Two users with the same password: identical hashes until each gets a random salt.
 */
function initSaltLab(lab) {
    const password = lab.dataset.password;
    const users = [...lab.querySelectorAll('[data-salt-user]')];
    const status = lab.querySelector('[data-salt-status]');
    const button = lab.querySelector('[data-salt-button]');

    const show = async (salts) => {
        const hashes = await Promise.all(salts.map((salt) => sha256(salt + password)));

        users.forEach((user, index) => {
            user.querySelector('[data-salt-value]').textContent = salts[index] || 'yok';
            user.querySelector('[data-salt-hash]').textContent = hashes[index];
        });

        return hashes;
    };

    show(users.map(() => '')).then(() => {
        status.dataset.tone = 'wrong';
        status.textContent = 'İki özet birebir aynı: biri tahmin edilirse ikisi birden ele geçer.';
    });

    button.addEventListener('click', async () => {
        const hashes = await show(users.map(() => randomSalt()));

        status.dataset.tone = 'correct';
        status.textContent = hashes[0] !== hashes[1]
            ? 'Aynı parola, bambaşka özetler. Tuz her kullanıcının özetini benzersiz yaptı.'
            : 'Tuzlar aynı çıktı; bir daha dene.';
        button.textContent = 'Yeni tuzlar üret';
        react('correct');
        completeRequirement(lab);
    });
}

export function initHashLabs() {
    const labs = document.querySelectorAll('[data-hash-lab], [data-salt-lab]');

    if (labs.length === 0) {
        return;
    }

    // Web Crypto only works on https or localhost; without it the steps should not block the mission.
    if (!canHash()) {
        labs.forEach((lab) => {
            lab.insertAdjacentHTML('beforeend', '<p class="text-alert mt-4 font-bold">Bu tarayıcı özet hesaplayamıyor. Bu adımı geçebilirsin.</p>');
            completeRequirement(lab);
        });

        return;
    }

    document.querySelectorAll('[data-hash-lab]').forEach(initAvalanche);
    document.querySelectorAll('[data-salt-lab]').forEach(initSaltLab);
}
