const FOLDED_LETTERS = { ç: 'c', ğ: 'g', ı: 'i', ö: 'o', ş: 's', ü: 'u' };

/**
 * Lowercases Turkish text and drops its accents and hyphens, so “sifre” finds “Şifreleme”
 * for someone typing without a Turkish keyboard, and “wifi” finds “Wi-Fi”.
 */
function fold(text) {
    return text
        .toLocaleLowerCase('tr')
        .replace(/[çğıöşü]/g, (letter) => FOLDED_LETTERS[letter])
        .replace(/-/g, '');
}

/**
 * Filters the glossary as the visitor types, hiding letters with no matching term.
 */
export function initGlossary() {
    const search = document.querySelector('[data-glossary-search]');

    if (!search) {
        return;
    }

    const terms = [...document.querySelectorAll('[data-glossary-term]')].map((element) => ({
        element,
        text: fold([...element.querySelectorAll('[data-glossary-searchable]')].map((part) => part.textContent).join(' ')),
    }));
    const groups = [...document.querySelectorAll('[data-glossary-group]')];
    const count = document.querySelector('[data-glossary-count]');
    const empty = document.querySelector('[data-glossary-empty]');

    search.addEventListener('input', () => {
        const query = fold(search.value.trim());
        let matchCount = 0;

        terms.forEach(({ element, text }) => {
            const isMatch = text.includes(query);

            element.hidden = !isMatch;
            matchCount += isMatch ? 1 : 0;
        });

        groups.forEach((group) => {
            group.hidden = !group.querySelector('[data-glossary-term]:not([hidden])');
        });

        count.textContent = query ? `${matchCount} terim bulundu` : `${terms.length} terim`;
        empty.hidden = matchCount > 0;
    });
}
