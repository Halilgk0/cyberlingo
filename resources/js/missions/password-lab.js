import { completeRequirement } from './requirement';

/** A fast offline attacker with a few modern graphics cards. */
const GUESSES_PER_SECOND = 1e10;
const SECONDS_PER_YEAR = 31_557_600;
const UNIVERSE_AGE_IN_YEARS = 13.8e9;

/** Roughly what it costs to guess one entry from a list of ~10,000 common words and patterns. */
const PREDICTABLE_PART_BITS = 13;

/** Compared after lowercasing and undoing look-alike swaps such as @ → a or 0 → o. */
const COMMON_WORDS = [
    'password', 'parola', 'sifre', 'admin', 'qwerty', 'iloveyou', 'seviyorum', 'askim', 'canim', 'merhaba',
    'welcome', 'letmein', 'monkey', 'dragon', 'football', 'futbol', 'galatasaray', 'fenerbahce', 'besiktas',
    'trabzonspor', 'istanbul', 'ankara', 'izmir', 'turkiye', 'ahmet', 'mehmet', 'mustafa', 'ayse', 'fatma',
    'zeynep', 'elif', 'emre', 'murat', 'yilmaz',
];

const KEYBOARD_SEQUENCES = ['abcdefghijklmnopqrstuvwxyz', '01234567890', 'qwertyuiop', 'asdfghjkl', 'zxcvbnm'];

const LOOKALIKES = {
    '@': 'a', 4: 'a', 3: 'e', 1: 'i', '!': 'i', '|': 'i', 0: 'o', $: 's', 5: 's', 7: 't',
    ı: 'i', ş: 's', ğ: 'g', ü: 'u', ö: 'o', ç: 'c',
};

const STRENGTH_LEVELS = [
    { maxBits: 40, label: 'Çok zayıf' },
    { maxBits: 60, label: 'Zayıf' },
    { maxBits: 80, label: 'İyi' },
    { maxBits: Infinity, label: 'Çok güçlü' },
];

/**
 * Lowercases character by character so every index still lines up with the original password.
 */
function lowercase(password) {
    return password
        .split('')
        .map((character) => {
            const lowered = character.toLocaleLowerCase('tr');

            return lowered.length === 1 ? lowered : character;
        })
        .join('');
}

function findOccurrences(haystack, needle) {
    const occurrences = [];
    let index = haystack.indexOf(needle);

    while (index !== -1) {
        occurrences.push([index, index + needle.length]);
        index = haystack.indexOf(needle, index + 1);
    }

    return occurrences;
}

/**
 * Finds the pieces an attacker would try first: common words and names, years,
 * keyboard runs and repeated characters. Overlapping hits are merged into one piece.
 */
function findPredictableParts(password) {
    const lowered = lowercase(password);
    const withoutLookalikes = lowered.replace(/./g, (character) => LOOKALIKES[character] ?? character);
    const ranges = [];

    COMMON_WORDS.forEach((word) => ranges.push(...findOccurrences(withoutLookalikes, word)));

    KEYBOARD_SEQUENCES.forEach((sequence) => {
        [sequence, [...sequence].reverse().join('')].forEach((direction) => {
            for (let start = 0; start + 4 <= direction.length; start++) {
                ranges.push(...findOccurrences(lowered, direction.slice(start, start + 4)));
            }
        });
    });

    for (const pattern of [/(?:19|20)\d{2}/g, /(.)\1{2,}/g]) {
        for (const match of lowered.matchAll(pattern)) {
            ranges.push([match.index, match.index + match[0].length]);
        }
    }

    ranges.sort((first, second) => first[0] - second[0]);

    const merged = [];

    ranges.forEach(([start, end]) => {
        const last = merged.at(-1);

        if (last && start < last[1]) {
            last[1] = Math.max(last[1], end);
        } else {
            merged.push([start, end]);
        }
    });

    return merged.map(([start, end]) => ({ text: password.slice(start, end), length: end - start }));
}

function characterPoolSize(password) {
    return (/\p{Ll}/u.test(password) ? 26 : 0)
        + (/\p{Lu}/u.test(password) ? 26 : 0)
        + (/\d/.test(password) ? 10 : 0)
        + (/[^\p{L}\d]/u.test(password) ? 33 : 0);
}

/**
 * A deliberately simple estimate: random characters cost log2(pool) bits each,
 * while a predictable piece costs only as much as picking it from a short list.
 */
function estimateBits(password, predictableParts) {
    const predictableLength = predictableParts.reduce((total, part) => total + part.length, 0);
    const randomLength = password.length - predictableLength;

    return randomLength * Math.log2(characterPoolSize(password)) + predictableParts.length * PREDICTABLE_PART_BITS;
}

function formatDuration(seconds) {
    const format = (value) => new Intl.NumberFormat('tr-TR', { maximumFractionDigits: 0 }).format(Math.max(1, value));
    const years = seconds / SECONDS_PER_YEAR;

    if (seconds < 1) {
        return '1 saniyeden kısa';
    }

    if (seconds < 60) {
        return `${format(seconds)} saniye`;
    }

    if (seconds < 3600) {
        return `${format(seconds / 60)} dakika`;
    }

    if (seconds < 86_400) {
        return `${format(seconds / 3600)} saat`;
    }

    if (years < 1) {
        return `${format(seconds / 86_400)} gün`;
    }

    if (years < 1e3) {
        return `${format(years)} yıl`;
    }

    if (years < 1e6) {
        return `${format(years / 1e3)} bin yıl`;
    }

    if (years < 1e9) {
        return `${format(years / 1e6)} milyon yıl`;
    }

    if (years < UNIVERSE_AGE_IN_YEARS) {
        return `${format(years / 1e9)} milyar yıl`;
    }

    return 'Evrenin yaşından uzun';
}

export function initPasswordLab() {
    const lab = document.querySelector('[data-password-lab]');

    if (!lab) {
        return;
    }

    const input = lab.querySelector('[data-password-input]');
    const crackTime = lab.querySelector('[data-crack-time]');
    const strengthLabel = lab.querySelector('[data-strength-label]');
    const segments = [...lab.querySelectorAll('[data-strength-segment]')];
    const weakParts = lab.querySelector('[data-weak-parts]');
    const checkItems = [...lab.querySelectorAll('[data-check]')];
    const status = lab.querySelector('[data-lab-status]');

    const render = () => {
        const password = input.value;
        const isEmpty = password.length === 0;
        const predictableParts = isEmpty ? [] : findPredictableParts(password);

        const checks = {
            length: [...password].length >= 12,
            uppercase: /\p{Lu}/u.test(password),
            lowercase: /\p{Ll}/u.test(password),
            digit: /\d/.test(password),
            symbol: /[^\p{L}\d]/u.test(password),
            unpredictable: !isEmpty && predictableParts.length === 0,
        };

        checkItems.forEach((item) => {
            const passed = checks[item.dataset.check];

            item.dataset.state = isEmpty ? 'idle' : (passed ? 'pass' : 'fail');
            item.querySelector('[data-check-state]').textContent = passed ? 'karşılandı' : 'karşılanmadı';
        });

        if (isEmpty) {
            crackTime.textContent = '…';
            strengthLabel.textContent = 'henüz yok';
            segments.forEach((segment) => delete segment.dataset.fill);
            weakParts.hidden = true;
            status.textContent = '';

            return;
        }

        const bits = estimateBits(password, predictableParts);
        const level = STRENGTH_LEVELS.findIndex((each) => bits < each.maxBits) + 1;

        crackTime.textContent = formatDuration(2 ** bits / GUESSES_PER_SECOND / 2);
        strengthLabel.textContent = STRENGTH_LEVELS[level - 1].label;
        segments.forEach((segment, index) => {
            if (index < level) {
                segment.dataset.fill = level;
            } else {
                delete segment.dataset.fill;
            }
        });

        weakParts.hidden = predictableParts.length === 0;
        weakParts.textContent = `Tahmin edilmesi kolay parçalar: ${predictableParts.map((part) => `“${part.text}”`).join(', ')}. Saldırganlar önce bunları dener.`;

        if (Object.values(checks).every(Boolean)) {
            status.textContent = 'Harika, bu parola tüm kontrollerden geçti! Gerçek hesaplarında da böyle bir parola kullan, ama bunu değil: buraya yazdığın her şeyi artık “görülmüş” say.';
            completeRequirement(lab);
        } else {
            status.textContent = '';
        }
    };

    input.addEventListener('input', render);

    lab.querySelectorAll('[data-password-sample]').forEach((sample) => {
        sample.addEventListener('click', () => {
            input.value = sample.dataset.passwordSample;
            render();
            input.focus();
        });
    });

    render();
}
