/** How long the coach keeps its reaction before going back to its idle pose. */
const REACTION_MILLISECONDS = 2400;

const REACTIONS = {
    correct: { mood: 'cheer', messages: ['Harika!', 'Süpersin!', 'Aynen böyle!', 'Doğru bildin!', 'Çok iyi!'] },
    wrong: { mood: 'sad', messages: ['Olsun, tekrar dene!', 'Az kaldı!', 'Bir daha bak!', 'Hata yapmak öğrenmektir.'] },
    done: { mood: 'cheer', messages: ['Bir adım daha tamam!', 'Bu adımı bitirdin!', 'Devam, çok iyi gidiyorsun!'] },
};

/**
 * Tells the coach how the last answer went: 'correct' or 'wrong'.
 * Exercises call this; the coach (if the page has one) reacts.
 */
export function react(reaction) {
    document.dispatchEvent(new CustomEvent('mascot:react', { detail: { reaction } }));
}

function pick(messages) {
    return messages[Math.floor(Math.random() * messages.length)];
}

/**
 * Bit in the corner of a mission page: cheers right answers, frowns at wrong ones,
 * and celebrates every finished step.
 */
export function initCoach() {
    const coach = document.querySelector('[data-coach]');

    if (!coach) {
        return;
    }

    const mascot = coach.querySelector('[data-mascot]');
    const bubble = coach.querySelector('[data-coach-bubble]');
    let resetTimer;

    const flash = (className) => {
        mascot.classList.remove('mascot-hit', 'mascot-burst');
        // Force a reflow so the same animation can replay on repeated reactions.
        void mascot.getBoundingClientRect();
        mascot.classList.add(className);
    };

    mascot.addEventListener('animationend', () => mascot.classList.remove('mascot-hit', 'mascot-burst'));

    const show = (reaction) => {
        const { mood, messages } = REACTIONS[reaction];

        flash(reaction === 'wrong' ? 'mascot-hit' : 'mascot-burst');
        mascot.dataset.mood = mood;
        bubble.textContent = pick(messages);
        bubble.setAttribute('data-visible', '');
        coach.setAttribute('data-active', '');

        clearTimeout(resetTimer);
        resetTimer = setTimeout(() => {
            mascot.dataset.mood = 'happy';
            bubble.removeAttribute('data-visible');
            coach.removeAttribute('data-active');
        }, REACTION_MILLISECONDS);
    };

    document.addEventListener('mascot:react', (event) => show(event.detail.reaction));
    document.addEventListener('requirement:completed', () => show('done'));
}
