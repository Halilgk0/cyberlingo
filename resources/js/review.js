import { react } from './mascot';

function csrfToken() {
    return document.querySelector('meta[name="csrf-token"]')?.content ?? '';
}

function isAuthed() {
    return document.querySelector('meta[name="user-authed"]')?.content === '1';
}

/**
 * Reads a quiz question into a self-contained snapshot: its prompt, any code, the options
 * with which one is right, and the explanation. The key ties it to its place in the mission.
 */
export function questionSnapshot(question, index) {
    const slug = location.pathname.replace(/\/+$/, '').split('/').pop();

    return {
        key: `${slug}:${index}`,
        mission: slug,
        missionTitle: document.querySelector('h1')?.textContent.trim() ?? 'Görev',
        prompt: question.querySelector('p')?.textContent.trim() ?? '',
        code: question.querySelector('pre')?.textContent.replace(/\s+$/, '') || null,
        explanation: question.querySelector('[data-explanation]')?.textContent.trim() || null,
        options: [...question.querySelectorAll('[data-option]')].map((option) => ({
            text: option.textContent.trim(),
            correct: option.hasAttribute('data-correct'),
        })),
    };
}

const bankedThisPage = new Set();

/**
 * Saves a missed question to the learner's review notebook, once per question per page,
 * and only for a logged-in learner. A failed request is ignored; review is a nice-to-have.
 */
export function bankMissedQuestion(snapshot) {
    if (!isAuthed() || bankedThisPage.has(snapshot.key) || snapshot.options.length < 2) {
        return;
    }

    bankedThisPage.add(snapshot.key);

    fetch('/tekrar', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', Accept: 'application/json', 'X-CSRF-TOKEN': csrfToken() },
        body: JSON.stringify(snapshot),
    }).catch(() => bankedThisPage.delete(snapshot.key));
}

function shuffle(items) {
    const copy = [...items];

    for (let i = copy.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        [copy[i], copy[j]] = [copy[j], copy[i]];
    }

    return copy;
}

/**
 * The review session on /tekrar: presents each saved question once. The right pick clears
 * the question from the notebook; a wrong pick keeps it for another day.
 */
export function initReview() {
    const session = document.querySelector('[data-review-session]');

    if (!session) {
        return;
    }

    const items = JSON.parse(session.querySelector('[data-review-items]').textContent);
    const card = session.querySelector('[data-review-card]');
    const progress = session.querySelector('[data-review-progress]');
    const summary = session.querySelector('[data-review-summary]');
    const correct = [];
    const wrong = [];
    let index = 0;

    const renderQuestion = () => {
        const item = items[index];
        const correctText = item.options.find((option) => option.correct)?.text;

        progress.textContent = `${index + 1} / ${items.length}`;
        card.replaceChildren();

        const context = document.createElement('p');
        context.className = 'rune-label text-signal text-xs';
        context.textContent = item.missionTitle;

        const prompt = document.createElement('p');
        prompt.className = 'mt-2 text-lg leading-snug font-bold';
        prompt.tabIndex = -1;
        prompt.textContent = item.prompt;
        card.append(context, prompt);

        if (item.code) {
            const pre = document.createElement('pre');
            pre.className = 'terminal mt-4 overflow-x-auto text-xs whitespace-pre-wrap [overflow-wrap:anywhere] sm:text-sm';
            const code = document.createElement('code');
            code.textContent = item.code;
            pre.append(code);
            card.append(pre);
        }

        const list = document.createElement('div');
        list.className = 'mt-4 flex flex-col gap-2';

        const status = document.createElement('p');
        const explanation = document.createElement('div');
        explanation.className = 'border-line mt-3 border-t pt-3 leading-relaxed';
        explanation.hidden = true;
        explanation.textContent = item.explanation ?? '';

        const next = document.createElement('button');
        next.type = 'button';
        next.className = 'btn-primary mt-5';
        next.textContent = index === items.length - 1 ? 'Sonucu gör' : 'Sıradaki soru';
        next.hidden = true;
        next.addEventListener('click', () => {
            if (index === items.length - 1) {
                finish();

                return;
            }

            index++;
            renderQuestion();
        });

        const buttons = shuffle(item.options).map((option) => {
            const button = document.createElement('button');
            button.type = 'button';
            button.className = 'border-line not-aria-disabled:hover:border-ink focus-visible:outline-ink data-[state=correct]:border-safe data-[state=correct]:bg-safe/10 data-[state=wrong]:border-alert data-[state=wrong]:bg-alert/8 rounded-xl border-2 px-4 py-3 text-left leading-snug transition-colors focus-visible:outline-2 aria-disabled:cursor-default aria-disabled:not-data-[state]:opacity-55';
            button.textContent = option.text;

            button.addEventListener('click', () => {
                if (list.hasAttribute('data-answered')) {
                    return;
                }

                list.setAttribute('data-answered', '');
                buttons.forEach((each) => each.setAttribute('aria-disabled', 'true'));

                if (option.correct) {
                    button.dataset.state = 'correct';
                    status.className = 'text-safe mt-3 font-bold';
                    status.textContent = 'Doğru! Bu soru defterinden siliniyor.';
                    correct.push(item.key);
                    react('correct');
                } else {
                    button.dataset.state = 'wrong';
                    buttons.find((each) => each.textContent === correctText).dataset.state = 'correct';
                    status.className = 'text-alert mt-3 font-bold';
                    status.textContent = 'Henüz tam oturmamış; bu soru tekrar karşına çıkacak.';
                    wrong.push(item.key);
                    react('wrong');
                }

                explanation.hidden = !item.explanation;
                next.hidden = false;
                next.focus({ preventScroll: true });
            });

            return button;
        });

        buttons.forEach((button) => list.append(button));
        card.append(list, status, explanation, next);
        prompt.focus({ preventScroll: true });
    };

    const finish = async () => {
        card.hidden = true;
        progress.hidden = true;

        try {
            await fetch('/tekrar/tamamla', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', Accept: 'application/json', 'X-CSRF-TOKEN': csrfToken() },
                body: JSON.stringify({ correct, wrong }),
            });
        } catch {
            // The review still happened on screen; a failed save just means it stays due.
        }

        summary.querySelector('[data-review-cleared]').textContent = correct.length;
        summary.querySelector('[data-review-again]').textContent = wrong.length;
        summary.hidden = false;
        summary.focus({ preventScroll: true });
        react('correct');
    };

    renderQuestion();
}
