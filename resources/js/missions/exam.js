import { react } from '../mascot';
import { completeRequirement } from './requirement';

/**
 * An exam: one try per question, the right answer is shown either way, and the
 * score at the end has to reach the pass mark to complete the step.
 */
export function initExams() {
    document.querySelectorAll('[data-exam]').forEach((exam) => {
        const questions = [...exam.querySelectorAll('[data-exam-question]')];
        const passScore = Number(exam.dataset.passScore);
        const progress = exam.querySelector('[data-exam-progress]');
        const position = exam.querySelector('[data-exam-position]');
        const scoreCount = exam.querySelector('[data-exam-score]');
        const pips = exam.querySelector('[data-exam-pips]');
        const nextButton = exam.querySelector('[data-exam-next]');
        const summary = exam.querySelector('[data-exam-summary]');
        const summaryScore = exam.querySelector('[data-exam-summary-score]');
        const summaryMessage = exam.querySelector('[data-exam-summary-message]');

        let currentIndex = 0;
        let score = 0;

        exam.querySelector('[data-exam-total]').textContent = questions.length;

        /* One pip per question above the exam: grey until answered, then green or red. */
        const pipElements = questions.map(() => {
            const pip = document.createElement('span');
            pip.className = 'h-2 grow rounded-full bg-line transition-colors data-[result=correct]:bg-safe data-[result=wrong]:bg-alert';

            return pip;
        });
        pips.replaceChildren(...pipElements);

        const showQuestion = (index) => {
            currentIndex = index;
            questions.forEach((question, questionIndex) => {
                question.hidden = questionIndex !== index;
            });
            position.textContent = index + 1;
            nextButton.hidden = true;
        };

        const showSummary = () => {
            questions.forEach((question) => {
                question.hidden = true;
            });
            nextButton.hidden = true;
            progress.hidden = true;
            summary.hidden = false;
            summaryScore.textContent = `${questions.length} sorunun ${score} tanesini doğru bildin.`;
            summaryScore.focus();

            if (score < passScore) {
                summaryMessage.textContent = `Kale bu kez düştü. Geçmek için en az ${passScore} doğru gerekiyor. Yanlış yaptığın konuların derslerine dönüp sınavı yeniden başlat.`;
                react('wrong');

                return;
            }

            summaryMessage.textContent = score === questions.length
                ? 'Kusursuz savunma! Hiçbir saldırı surlarını aşamadı.'
                : 'Kuşatmayı püskürttün! Kalen sağlam, sen de artık gerçek bir Siber Şövalyesin.';
            completeRequirement(exam);
        };

        questions.forEach((question, questionIndex) => {
            const options = [...question.querySelectorAll('[data-option]')];
            const feedback = question.querySelector('[data-exam-feedback]');
            const result = question.querySelector('[data-exam-result]');

            options.forEach((option) => {
                option.addEventListener('click', () => {
                    if (question.hasAttribute('data-answered')) {
                        return;
                    }

                    const isCorrect = option.hasAttribute('data-correct');

                    question.setAttribute('data-answered', '');
                    options.forEach((each) => {
                        each.setAttribute('aria-disabled', 'true');

                        if (each.hasAttribute('data-correct')) {
                            each.dataset.state = 'correct';
                        }
                    });

                    if (!isCorrect) {
                        option.dataset.state = 'wrong';
                    }

                    score += isCorrect ? 1 : 0;
                    scoreCount.textContent = score;
                    pipElements[questionIndex].dataset.result = isCorrect ? 'correct' : 'wrong';
                    result.dataset.tone = isCorrect ? 'correct' : 'wrong';
                    result.textContent = isCorrect ? 'Doğru!' : 'Yanlış; doğru cevap yeşil olan.';
                    feedback.hidden = false;
                    react(isCorrect ? 'correct' : 'wrong');

                    nextButton.textContent = questionIndex === questions.length - 1 ? 'Sonucu gör' : 'Sonraki soru';
                    nextButton.hidden = false;
                });
            });
        });

        nextButton.addEventListener('click', () => {
            if (currentIndex === questions.length - 1) {
                showSummary();

                return;
            }

            showQuestion(currentIndex + 1);
            questions[currentIndex].querySelector('[data-exam-prompt]').focus();
        });

        exam.querySelector('[data-exam-restart]').addEventListener('click', () => {
            questions.forEach((question) => {
                question.removeAttribute('data-answered');
                question.querySelector('[data-exam-feedback]').hidden = true;
                question.querySelectorAll('[data-option]').forEach((option) => {
                    option.removeAttribute('aria-disabled');
                    delete option.dataset.state;
                });
            });
            pipElements.forEach((pip) => delete pip.dataset.result);

            score = 0;
            scoreCount.textContent = score;
            summary.hidden = true;
            progress.hidden = false;
            showQuestion(0);
            questions[0].querySelector('[data-exam-prompt]').focus();
        });

        showQuestion(0);
    });
}
