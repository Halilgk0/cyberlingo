import { react } from '../mascot';
import { bankMissedQuestion, questionSnapshot } from '../review';
import { completeRequirement } from './requirement';

/**
 * Multiple-choice questions: a wrong pick is crossed out so the learner can try
 * again, the right pick reveals the explanation. The first time a logged-in learner
 * misses a question, it is saved to their review notebook for another day.
 */
export function initQuizzes() {
    const allQuestions = [...document.querySelectorAll('[data-quiz] [data-question]')];

    document.querySelectorAll('[data-quiz]').forEach((quiz) => {
        const questions = [...quiz.querySelectorAll('[data-question]')];

        questions.forEach((question) => {
            const options = [...question.querySelectorAll('[data-option]')];
            const status = question.querySelector('[data-question-status]');
            const explanation = question.querySelector('[data-explanation]');

            options.forEach((option) => {
                option.addEventListener('click', () => {
                    if (option.getAttribute('aria-disabled') === 'true') {
                        return;
                    }

                    if (!option.hasAttribute('data-correct')) {
                        option.dataset.state = 'wrong';
                        option.setAttribute('aria-disabled', 'true');
                        status.dataset.tone = 'wrong';
                        status.textContent = 'Bu değil, bir daha dene.';
                        react('wrong');
                        bankMissedQuestion(questionSnapshot(question, allQuestions.indexOf(question)));

                        return;
                    }

                    option.dataset.state = 'correct';
                    options.forEach((each) => each.setAttribute('aria-disabled', 'true'));
                    status.dataset.tone = 'correct';
                    status.textContent = 'Doğru!';
                    react('correct');
                    explanation.hidden = false;
                    question.setAttribute('data-answered', '');

                    if (questions.every((each) => each.hasAttribute('data-answered'))) {
                        completeRequirement(quiz);
                    }
                });
            });
        });
    });
}
