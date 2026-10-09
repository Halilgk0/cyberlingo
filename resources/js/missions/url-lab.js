import { react } from '../mascot';
import { completeRequirement } from './requirement';

/** Why a part that is not the domain cannot tell who owns the address. */
const WRONG_PART_HINTS = {
    protocol: 'Bu protokol. Sadece bağlantının nasıl kurulduğunu söyler, adresin kime ait olduğunu değil. Tekrar dene.',
    subdomain: 'Bu bir alt alan adı. Alan adının sahibi buraya istediği her şeyi yazabilir. Tekrar dene.',
    path: 'Bu, ilk eğik çizgiden sonra gelen yol kısmı. Buraya da herkes istediğini yazabilir. Tekrar dene.',
};

/**
 * The link lab: one address at a time, the learner finds the part that names its
 * owner, then judges whether it is the genuine site.
 */
export function initUrlLabs() {
    const lab = document.querySelector('[data-url-lab]');

    if (!lab) {
        return;
    }

    const addresses = [...lab.querySelectorAll('[data-url-address]')];
    const progress = lab.querySelector('[data-url-lab-progress]');
    const position = lab.querySelector('[data-url-lab-position]');
    const scoreCount = lab.querySelector('[data-url-lab-score]');
    const nextButton = lab.querySelector('[data-url-lab-next]');
    const summary = lab.querySelector('[data-url-lab-summary]');
    const summaryScore = lab.querySelector('[data-url-lab-summary-score]');
    const summaryMessage = lab.querySelector('[data-url-lab-summary-message]');
    const restartButton = lab.querySelector('[data-url-lab-restart]');

    let currentIndex = 0;
    let score = 0;

    lab.querySelector('[data-url-lab-total]').textContent = addresses.length;

    const showAddress = (index) => {
        currentIndex = index;
        addresses.forEach((address, addressIndex) => {
            address.hidden = addressIndex !== index;
        });
        position.textContent = index + 1;
        nextButton.hidden = true;
    };

    const showSummary = () => {
        addresses.forEach((address) => {
            address.hidden = true;
        });
        nextButton.hidden = true;
        progress.hidden = true;
        summary.hidden = false;

        summaryScore.textContent = `${addresses.length} bağlantının ${score} tanesinde doğru karar verdin.`;

        if (score === addresses.length) {
            summaryMessage.textContent = 'Kusursuz! Hiçbir sahte adres seni kandıramadı. Gerçek hayatta da tıklamadan önce alan adını oku.';
        } else if (score >= addresses.length - 2) {
            summaryMessage.textContent = 'İyi iş! Kaçırdıklarını görmek istersen baştan başlayabilirsin.';
        } else {
            summaryMessage.textContent = 'Adres okumak pratik ister. Yukarıdaki kuralı bir daha oku: ilk eğik çizgiyi bul, oradan sola doğru oku. Sonra tekrar dene.';
        }

        summaryScore.focus();
        completeRequirement(lab);
    };

    addresses.forEach((address) => {
        const parts = [...address.querySelectorAll('[data-url-part]')];
        const findStatus = address.querySelector('[data-url-find-status]');
        const judge = address.querySelector('[data-url-judge]');
        const judgeButtons = [...address.querySelectorAll('[data-judge]')];
        const feedback = address.querySelector('[data-url-feedback]');
        const result = address.querySelector('[data-url-result]');

        parts.forEach((part) => {
            part.addEventListener('click', () => {
                if (part.getAttribute('aria-disabled') === 'true') {
                    return;
                }

                if (part.dataset.urlPart !== 'domain') {
                    part.dataset.state = 'wrong';
                    part.setAttribute('aria-disabled', 'true');
                    findStatus.dataset.tone = 'wrong';
                    findStatus.textContent = WRONG_PART_HINTS[part.dataset.urlPart];
                    react('wrong');

                    return;
                }

                parts.forEach((each) => {
                    delete each.dataset.state;
                    each.setAttribute('aria-disabled', 'true');
                });
                part.dataset.state = 'correct';
                address.setAttribute('data-revealed', '');
                findStatus.dataset.tone = 'correct';
                findStatus.textContent = `Doğru! Bu adresin sahibi: ${part.textContent.trim()}`;
                react('correct');

                judge.hidden = false;
                judge.querySelector('[data-url-judge-prompt]').focus();
            });
        });

        judgeButtons.forEach((button) => {
            button.addEventListener('click', () => {
                if (address.hasAttribute('data-answered')) {
                    return;
                }

                const isCorrect = button.dataset.judge === address.dataset.genuine;

                if (isCorrect) {
                    score++;
                    scoreCount.textContent = score;
                }

                address.setAttribute('data-answered', '');
                judgeButtons.forEach((each) => each.setAttribute('aria-disabled', 'true'));
                button.setAttribute('aria-pressed', 'true');

                result.dataset.tone = isCorrect ? 'correct' : 'wrong';
                result.textContent = isCorrect ? 'Doğru karar!' : 'Bu sefer olmadı.';
                react(isCorrect ? 'correct' : 'wrong');
                feedback.hidden = false;

                nextButton.textContent = currentIndex === addresses.length - 1 ? 'Sonucu gör' : 'Sonraki bağlantı';
                nextButton.hidden = false;
                result.focus();
            });
        });
    });

    nextButton.addEventListener('click', () => {
        if (currentIndex === addresses.length - 1) {
            showSummary();

            return;
        }

        showAddress(currentIndex + 1);
        addresses[currentIndex].querySelector('[data-url-find-prompt]').focus();
    });

    restartButton.addEventListener('click', () => {
        addresses.forEach((address) => {
            address.removeAttribute('data-revealed');
            address.removeAttribute('data-answered');
            address.querySelectorAll('[data-url-part]').forEach((part) => {
                delete part.dataset.state;
                part.removeAttribute('aria-disabled');
            });
            address.querySelectorAll('[data-judge]').forEach((button) => {
                button.removeAttribute('aria-disabled');
                button.removeAttribute('aria-pressed');
            });

            const findStatus = address.querySelector('[data-url-find-status]');
            delete findStatus.dataset.tone;
            findStatus.textContent = '';
            address.querySelector('[data-url-judge]').hidden = true;
            address.querySelector('[data-url-feedback]').hidden = true;
        });

        score = 0;
        scoreCount.textContent = score;
        summary.hidden = true;
        progress.hidden = false;
        showAddress(0);
        addresses[0].querySelector('[data-url-find-prompt]').focus();
    });

    showAddress(0);
}
