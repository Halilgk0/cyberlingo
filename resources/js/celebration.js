const CONFETTI_COLORS = ['#3fd17c', '#ffc23d', '#4cb8ff', '#ff7aa2', '#a98bff', '#ff9a3c'];
const CONFETTI_PIECES = 70;
const COUNT_UP_MILLISECONDS = 900;

const prefersReducedMotion = () => window.matchMedia('(prefers-reduced-motion: reduce)').matches;

function burstConfetti(container) {
    if (prefersReducedMotion()) {
        return;
    }

    container.replaceChildren(
        ...Array.from({ length: CONFETTI_PIECES }, () => {
            const piece = document.createElement('span');

            piece.className = 'confetti-piece';
            piece.style.left = `${Math.random() * 100}%`;
            piece.style.background = CONFETTI_COLORS[Math.floor(Math.random() * CONFETTI_COLORS.length)];
            piece.style.setProperty('--fall-duration', `${2 + Math.random() * 1.6}s`);
            piece.style.setProperty('--fall-delay', `${Math.random() * 0.5}s`);
            piece.style.setProperty('--drift', `${(Math.random() - 0.5) * 220}px`);
            piece.style.setProperty('--spin', `${(Math.random() - 0.5) * 1440}deg`);

            return piece;
        }),
    );
}

/** Counts a number up from zero, so earned XP feels earned. */
function countUp(element, target) {
    if (prefersReducedMotion() || target === 0) {
        element.textContent = target;

        return;
    }

    const startedAt = performance.now();

    const step = (now) => {
        const progress = Math.min(1, (now - startedAt) / COUNT_UP_MILLISECONDS);

        element.textContent = Math.round(target * (1 - (1 - progress) ** 3));

        if (progress < 1) {
            requestAnimationFrame(step);
        }
    };

    requestAnimationFrame(step);
}

/**
 * Opens the end-of-mission screen with what the server returned for the completion.
 */
export function openCelebration(result) {
    const celebration = document.querySelector('[data-celebration]');

    if (!celebration) {
        return;
    }

    const find = (name) => celebration.querySelector(`[data-celebration-${name}]`);
    const primary = find('primary');
    const secondary = find('secondary');

    celebration.hidden = false;
    document.body.style.overflow = 'hidden';
    document.dispatchEvent(new CustomEvent('celebration:open'));
    celebration.querySelector('[data-mascot]').dataset.mood = 'cheer';
    burstConfetti(celebration.querySelector('[data-confetti]'));
    countUp(find('xp'), result.xpEarned);

    if (result.guest) {
        find('subtitle').textContent = 'İlk görevini bitirdin. Harika bir başlangıç!';
        find('streak-card').hidden = true;
        find('xp').closest('.rounded-2xl').style.gridColumn = '1 / -1';
        find('rank').hidden = true;
        find('guest').hidden = false;
        primary.textContent = 'Ücretsiz hesap oluştur';
        primary.href = result.registerUrl;
        secondary.textContent = 'Şimdilik değil';
        secondary.href = result.pathUrl;
    } else {
        find('subtitle').textContent = result.xpEarned > 0
            ? 'Bilgin ve XP’n artıyor.'
            : 'Bu görevi bugün zaten tekrar etmiştin; serin yine de sürüyor.';
        find('streak').textContent = result.streak;
        find('level').textContent = result.rank.level;
        find('rank-title').textContent = result.rank.title;
        find('rank-next').textContent = result.rank.nextTitle ? `Sıradaki: ${result.rank.nextTitle}` : 'En yüksek seviye';
        requestAnimationFrame(() => {
            find('rank-bar').style.width = `${result.rank.progress}%`;
        });

        if (result.rank.rankedUp) {
            find('rank-up').hidden = false;
            find('rank-up').textContent = `Seviye atladın! Artık bir “${result.rank.title}”sın.`;
        }

        const template = celebration.querySelector('[data-celebration-achievement]');

        find('achievements').replaceChildren(
            ...result.achievements.map((achievement, index) => {
                const item = template.content.firstElementChild.cloneNode(true);

                item.style.animationDelay = `${400 + index * 150}ms`;
                item.querySelector('[data-achievement-emoji]').textContent = achievement.emoji;
                item.querySelector('[data-achievement-title]').textContent = achievement.title;
                item.querySelector('[data-achievement-description]').textContent = achievement.description;

                return item;
            }),
        );

        primary.textContent = result.next ? `Sıradaki görev: ${result.next.title}` : 'Öğrenme yoluna dön';
        primary.href = result.next ? result.next.url : result.pathUrl;

        if (result.certificateUrl) {
            primary.textContent = 'Siber Şövalye Beratını al';
            primary.href = result.certificateUrl;
        }
        secondary.hidden = !result.next;
        secondary.href = result.pathUrl;
    }

    celebration.querySelector('#celebration-title').focus();
}
