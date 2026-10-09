import { react } from '../mascot';
import { completeRequirement } from './requirement';

/**
 * The practice inbox: one email at a time, the learner calls it safe or phishing,
 * then the clues that give it away are highlighted and explained.
 */
export function initInbox() {
    const inbox = document.querySelector('[data-inbox]');

    if (!inbox) {
        return;
    }

    const emails = [...inbox.querySelectorAll('[data-email]')];
    const progress = inbox.querySelector('[data-inbox-progress]');
    const position = inbox.querySelector('[data-inbox-position]');
    const scoreCount = inbox.querySelector('[data-inbox-score]');
    const nextButton = inbox.querySelector('[data-inbox-next]');
    const summary = inbox.querySelector('[data-inbox-summary]');
    const summaryScore = inbox.querySelector('[data-inbox-summary-score]');
    const summaryMessage = inbox.querySelector('[data-inbox-summary-message]');
    const restartButton = inbox.querySelector('[data-inbox-restart]');

    const passScore = Number(inbox.dataset.passScore ?? 0);

    let currentIndex = 0;
    let score = 0;

    inbox.querySelector('[data-inbox-total]').textContent = emails.length;

    const showEmail = (index) => {
        currentIndex = index;
        emails.forEach((email, emailIndex) => {
            email.hidden = emailIndex !== index;
        });
        position.textContent = index + 1;
        nextButton.hidden = true;
    };

    const showSummary = () => {
        emails.forEach((email) => {
            email.hidden = true;
        });
        nextButton.hidden = true;
        progress.hidden = true;
        summary.hidden = false;

        summaryScore.textContent = `${emails.length} e-postanın ${score} tanesini doğru bildin.`;
        summaryScore.focus();

        /* A dragon trial sets `data-pass-score`: below it, the step stays open until the learner tries again. */
        if (passScore > 0) {
            if (score < passScore) {
                summaryMessage.textContent = `Ejderha bu kez kazandı. Geçmek için en az ${passScore} doğru gerekiyor. İpuçlarını gözden geçir ve gelen kutusunu baştan başlat.`;
                react('wrong');

                return;
            }

            summaryMessage.textContent = 'Ejderhayı yendin! En ustaca hazırlanmış tuzaklar bile seni kandıramadı.';
            completeRequirement(inbox);

            return;
        }

        if (score === emails.length) {
            summaryMessage.textContent = 'Harika! Hiçbir yeme takılmadın. Gerçek gelen kutunda da aynı dikkatle bakmaya devam et.';
        } else if (score >= emails.length - 2) {
            summaryMessage.textContent = 'İyi iş! Kaçırdıklarına bir daha göz atmak istersen gelen kutusunu baştan başlatabilirsin.';
        } else {
            summaryMessage.textContent = 'Oltalama e-postaları gerçekten ikna edici olabilir. Yukarıdaki işaretler listesine tekrar bak ve bir daha dene.';
        }

        completeRequirement(inbox);
    };

    emails.forEach((email) => {
        const answerButtons = [...email.querySelectorAll('[data-answer]')];
        const feedback = email.querySelector('[data-email-feedback]');
        const result = email.querySelector('[data-email-result]');

        answerButtons.forEach((button) => {
            button.addEventListener('click', () => {
                if (email.hasAttribute('data-revealed')) {
                    return;
                }

                const isCorrect = button.dataset.answer === email.dataset.verdict;

                if (isCorrect) {
                    score++;
                    scoreCount.textContent = score;
                }

                email.setAttribute('data-revealed', '');
                answerButtons.forEach((each) => each.setAttribute('aria-disabled', 'true'));
                button.setAttribute('aria-pressed', 'true');

                result.dataset.tone = isCorrect ? 'correct' : 'wrong';
                result.textContent = isCorrect ? 'Doğru bildin!' : 'Bu sefer olmadı.';
                react(isCorrect ? 'correct' : 'wrong');
                feedback.hidden = false;

                nextButton.textContent = currentIndex === emails.length - 1 ? 'Sonucu gör' : 'Sonraki e-posta';
                nextButton.hidden = false;
                result.focus();
            });
        });
    });

    nextButton.addEventListener('click', () => {
        if (currentIndex === emails.length - 1) {
            showSummary();

            return;
        }

        showEmail(currentIndex + 1);
        emails[currentIndex].querySelector('[data-email-subject]').focus();
    });

    restartButton.addEventListener('click', () => {
        emails.forEach((email) => {
            email.removeAttribute('data-revealed');
            email.querySelector('[data-email-feedback]').hidden = true;
            email.querySelectorAll('[data-answer]').forEach((button) => {
                button.removeAttribute('aria-disabled');
                button.removeAttribute('aria-pressed');
            });
        });

        score = 0;
        scoreCount.textContent = score;
        summary.hidden = true;
        progress.hidden = false;
        showEmail(0);
        emails[0].querySelector('[data-email-subject]').focus();
    });

    inbox.querySelectorAll('[data-fake-link] button').forEach((button) => {
        button.addEventListener('click', () => {
            button.closest('[data-fake-link]').toggleAttribute('data-open');
        });
    });

    showEmail(0);
}
