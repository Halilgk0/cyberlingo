import { react } from '../mascot';
import { completeRequirement } from './requirement';

/**
 * Scenario cards shown one at a time. A wrong category is crossed out so the
 * learner can try again; the right one files the card into its bin.
 */
export function initSorters() {
    document.querySelectorAll('[data-sorter]').forEach((sorter) => {
        const cards = [...sorter.querySelectorAll('[data-sorter-card]')];
        const progress = sorter.querySelector('[data-sorter-progress]');
        const position = sorter.querySelector('[data-sorter-position]');
        const nextButton = sorter.querySelector('[data-sorter-next]');
        const summary = sorter.querySelector('[data-sorter-summary]');
        const summaryScore = sorter.querySelector('[data-sorter-summary-score]');

        let currentIndex = 0;
        let firstTryCount = 0;

        sorter.querySelector('[data-sorter-total]').textContent = cards.length;

        const showCard = (index) => {
            currentIndex = index;
            cards.forEach((card, cardIndex) => {
                card.hidden = cardIndex !== index;
            });
            position.textContent = index + 1;
            nextButton.hidden = true;
        };

        const fileIntoBin = (card) => {
            const bin = sorter.querySelector(`[data-sorter-bin="${card.dataset.answer}"]`);
            const items = bin.querySelector('[data-sorter-bin-items]');
            const item = document.createElement('li');

            item.textContent = card.dataset.label;
            items.append(item);
            bin.querySelector('[data-sorter-bin-count]').textContent = items.children.length;
        };

        const showSummary = () => {
            cards.forEach((card) => {
                card.hidden = true;
            });
            nextButton.hidden = true;
            progress.hidden = true;
            summary.hidden = false;

            summaryScore.textContent = firstTryCount === cards.length
                ? `Kusursuz! ${cards.length} olayın hepsini ilk denemede doğru kutuya koydun.`
                : `${cards.length} olayın ${firstTryCount} tanesini ilk denemede doğru kutuya koydun.`;

            summaryScore.focus();
            completeRequirement(sorter);
        };

        cards.forEach((card) => {
            const choices = [...card.querySelectorAll('[data-choice]')];
            const status = card.querySelector('[data-sorter-card-status]');
            const explanation = card.querySelector('[data-sorter-card-explanation]');
            let missed = false;

            choices.forEach((choice) => {
                choice.addEventListener('click', () => {
                    if (choice.getAttribute('aria-disabled') === 'true') {
                        return;
                    }

                    if (choice.dataset.choice !== card.dataset.answer) {
                        missed = true;
                        choice.dataset.state = 'wrong';
                        choice.setAttribute('aria-disabled', 'true');
                        status.dataset.tone = 'wrong';
                        status.textContent = 'Bu kutu değil, bir daha düşün.';
                        react('wrong');

                        return;
                    }

                    if (!missed) {
                        firstTryCount++;
                    }

                    choice.dataset.state = 'correct';
                    choices.forEach((each) => each.setAttribute('aria-disabled', 'true'));
                    status.dataset.tone = 'correct';
                    status.textContent = 'Doğru kutu!';
                    react('correct');
                    explanation.hidden = false;
                    fileIntoBin(card);

                    nextButton.textContent = currentIndex === cards.length - 1 ? 'Sonucu gör' : 'Sonraki olay';
                    nextButton.hidden = false;
                });
            });
        });

        nextButton.addEventListener('click', () => {
            if (currentIndex === cards.length - 1) {
                showSummary();

                return;
            }

            showCard(currentIndex + 1);
            cards[currentIndex].querySelector('[data-sorter-card-text]').focus();
        });

        showCard(0);
    });
}
